# Contrato HTTP Hub ↔ Spoke — “Ojos” para el cliente

Este documento es la **fuente de verdad operativa** para quien consume el Hub desde el Spoke (Laravel, Livewire, jobs). Si aquí no está claro cómo mapear una respuesta, el Spoke queda **ciego**: arrays sueltos, `null` silenciosos y bugs en producción.

## 1. Regla de oro: JSON → DTO, no → `$array['clave']`

Tras cada `Http::` / `HubApiClient`:

1. Mirar **código HTTP** y cabeceras si aplica.
2. Decodificar cuerpo a array **solo una vez** en el borde del cliente.
3. **Inmediatamente** hidratar un DTO del paquete `sunnyface/ai-contracts` con `SomeResponseDTO::from($payload)` (o el constructor si no aplica `from`).
4. El resto del código del Spoke solo usa **propiedades tipadas** del DTO.

**Prohibido** arrastrar `$response['vaults']`, `$body['task_id']`, etc. por Actions, Livewire o vistas.

## 2. `_hub_error` (solo Spoke, nunca Hub)

- **`_hub_error` no lo envía el Hub.** Es un marcador que puede añadir el **`HubApiClient` (u otro wrapper HTTP del Spoke)** cuando hay timeout, red, 500 sin cuerpo parseable, etc.
- Si detectas `_hub_error`, **no** intentes `VaultListResponseDTO::from(...)`: no es un contrato del Hub; trátalo como fallo de transporte y muestra telemetría / retry / mensaje genérico.

## 3. Dónde vive cada DTO

| Área | Namespace típico | Uso |
|------|-------------------|-----|
| Respuestas de dominio compartidas (listados, métricas, ítems) | `Sunnyface\Contracts\Data\Network\` | Cuerpo JSON 2xx con forma estable (ej. `VaultListResponseDTO`). |
| Errores HTTP canónicos Hub→Spoke | `Sunnyface\Contracts\Data\Spoke\Responses\` | Sobre todo `ApiErrorResponseDTO` y envelopes específicos (widget, funnel, etc.). |
| Requests / webhooks entrantes | `Sunnyface\Contracts\Data\Spoke\`, `...\Network\`, etc. | Validación y firma; no mezclar con respuestas. |

**Importante:** un mismo endpoint puede devolver **200 con un DTO de negocio** o **404/422 con `ApiErrorResponseDTO`**. El Spoke debe ramificar por **status** y por **forma mínima del JSON** antes de hidratar.

## 4. Errores: `ApiErrorResponseDTO`

El Hub suele responder errores con cuerpo JSON que incluye al menos:

```json
{ "error": "Mensaje legible" }
```

En PHP, el DTO `ApiErrorResponseDTO` incluye `httpStatus` para `toResponse()` del Hub; en JSON puede ir **oculto** (`#[Hidden]`). Al hidratar **desde el Spoke** usando solo el cuerpo, pasa el status de la respuesta HTTP:

```php
$payload = $response->json();
$status = $response->status();

$error = ApiErrorResponseDTO::from([
    'error' => (string) ($payload['error'] ?? 'Unknown error'),
    'httpStatus' => $status,
]);
```

Ajusta si tu cliente ya normaliza otro formato; la regla es: **tipar el error igual que el éxito**.

## 5. Éxito: ejemplo bóvedas (`GET` listado)

El Hub devuelve un JSON compatible con `VaultListResponseDTO` (propiedad `vaults`, elementos `VaultSummaryDTO`, enums como `VaultType`, etc.).

En el Spoke:

```php
if ($response->successful()) {
    return VaultListResponseDTO::from($response->json());
}

// 4xx/5xx con forma de error
return ApiErrorResponseDTO::from([
    'error' => (string) ($response->json('error') ?? 'Request failed'),
    'httpStatus' => $response->status(),
]);
```

O devuelve un union/`Result` interno; lo crítico es **no** mezclar arrays crudos después de este punto.

## 6. Qué hace el Hub en código (referencia)

Los controladores devuelven instancias de DTO que extienden `Spatie\LaravelData\Data` y sobrescriben `toResponse()` con:

```php
return response()->json($this, $codigo);
```

Eso define la forma del JSON que el Spoke debe reversar con `::from()`.

## 7. PHP en el Hub: union de tipos en controladores

En el Hub es correcto tipar el retorno como:

`VaultListResponseDTO|ApiErrorResponseDTO`

Eso **no cambia el JSON**; solo ayuda al IDE. En el Spoke no verás la unión en runtime: debes **elegir el DTO** según HTTP + payload.

## 8. Enums y fechas

- Los **enums** se serializan como su `value` (string); `::from()` los reconstruye.
- Fechas en DTOs de red suelen ir como **string** (`created_at`, etc.) para estabilidad entre procesos; no asumas `Carbon` en el contrato compartido salvo que el DTO lo exponga explícitamente.

---

**Resumen para “Claudia” en el Spoke:** una respuesta HTTP = una decisión = un DTO. Sin ese paso, el Spoke trabaja a ciegas.
