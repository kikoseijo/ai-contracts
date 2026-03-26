---
name: perfect-agent-guide
description: LA SUPER GUÍA DEL AGENTE PERFECTO. Reglas estrictas de arquitectura C.O.R.E. para controladores, uso de Spatie Data y prohibición de modificar el paquete ai-contracts. Úsalo SIEMPRE que trabajes en controladores, DTOs o interactúes con el paquete sunnyface-ai-contracts en proyectos consumidores.
---

# LA SUPER GUÍA DEL AGENTE PERFECTO 🚀

Esta guía contiene los mandamientos arquitectónicos para los agentes que consumen el paquete `sunnyface-ai-contracts`.

## 🚨 REGLA DE ORO (FIJADA A FUEGO) 🚨

**NUNCA, BAJO NINGUNA CIRCUNSTANCIA, MODIFIQUES EL CÓDIGO DEL PAQUETE `sunnyface-ai-contracts`.**
Solo el agente "Gemini ORACULO PRO 2026" tiene autorización para realizar cambios en ese paquete. Si estás trabajando en un proyecto consumidor satelite (como `sunnyface` o `Sunnygestor`), asume que el paquete es de **solo lectura**. el unico agente autorizado en todo caso es el Hub bajo orden explicita de (El Jefe!) el domador de nanobots! con certificado de seguridad de la CIA!

---

## El Patrón de Controlador C.O.R.E. (Controlador de Oro)

Todos los controladores deben seguir estrictamente este patrón:

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Spoke;

use App\Actions\Spoke\ListFailedTasksAsBlindSpotsAction;
use App\Http\Controllers\Controller;
use Sunnyface\Contracts\Data\Spoke\Responses\ApiErrorResponseDTO;
use Sunnyface\Contracts\Data\Spoke\Responses\BlindSpotsResponseDTO;
use Sunnyface\Contracts\Data\Spoke\SpokeTenantIdRequest;

class BlindSpotsController extends Controller
{
    public function show(SpokeTenantIdRequest $data, ListFailedTasksAsBlindSpotsAction $action): BlindSpotsResponseDTO|ApiErrorResponseDTO
    {
        return $action->execute($data);
    }
}
```

### Características del Patrón C.O.R.E

1. **`declare(strict_types=1);`** es obligatorio en todos los archivos.
2. **Inyección Directa de DTOs:** No inyectes `Illuminate\Http\Request` ni FormRequests tradicionales. Inyecta directamente el DTO de Spatie Data (ej. `SpokeTenantIdRequest`).
3. **Delegación a Actions:** El controlador NO tiene lógica de negocio. Delega todo a una clase `Action` inyectada.
4. **Retorno de DTOs:** El controlador devuelve directamente DTOs de respuesta (o DTOs de error). Nunca uses `response()->json()`.
5. **Cuerpo Mínimo:** El método del controlador debe tener idealmente una sola línea: `return $action->execute($data);`.

---

## ❌ Anti-Patrones Detectados (LO QUE NO DEBES HACER)

Al revisar los proyectos consumidores (`sunnyface` y `SunnyGestor`), se detectaron estos errores comunes cometidos por otros agentes que **DEBES EVITAR A TODA COSTA**:

### 1. Hidratación Manual y Try/Catch (El peor error)

❌ **MAL:** (Encontrado en `SunnyGestor/app/Http/Controllers/Api/HubWebhookController.php`)

```php
public function handleTaskStatus(Request $request): JsonResponse
{
    try {
        $dto = TaskStatusWebhookDTO::from($request->all());
    } catch (\Exception $e) {
        return response()->json(['message' => 'Invalid payload format'], 422);
    }
    // ...
}
```

✅ **BIEN:** Inyecta el DTO directamente. Spatie Data valida automáticamente y lanza la excepción correcta.

```php
public function handleTaskStatus(TaskStatusWebhookDTO $dto, ProcessTaskAction $action): ResponseDTO
{
    return $action->execute($dto);
}
```

### 2. FormRequests Intermediarios Innecesarios

❌ **MAL:** (Encontrado en `sunnyface/app/Http/Controllers/Api/HubWebhookController.php`)
Usar un `FormRequest` solo para convertirlo a DTO manualmente.

```php
public function taskStatus(TaskStatusWebhookRequest $request, ProcessHubWebhookAction $action): Response
{
    $action->execute($request->toDTO());
    return response()->noContent();
}
```

✅ **BIEN:** Inyecta el DTO de Spatie Data directamente en el controlador y elimina el FormRequest.

### 3. Retornar `response()->json()` manualmente

❌ **MAL:**

```php
return response()->json(['status' => 'acknowledged'], 202);
```

✅ **BIEN:** Retorna un DTO de respuesta. Spatie Data lo convierte automáticamente a JSON gracias a la interfaz `Responsable`.

```php
return new AcknowledgedResponseDTO();
```

### 4. Controladores "Gordos"

❌ **MAL:** Escribir lógica de negocio, consultas a base de datos o manipulación de modelos dentro del controlador.
✅ **BIEN:** Mueve toda esa lógica a una clase `Action` dedicada e inyéctala en el método del controlador.

---

## ⚡️ Mandamientos Arquitectónicos Avanzados

### 1. El Mandamiento Anti-Latencia (Asincronía Obligatoria)

**LA REGLA:** Queda **ESTRICTAMENTE PROHIBIDO** realizar llamadas HTTP síncronas al Hub (o a cualquier API de IA/LLM) directamente dentro de un Controlador que sirva a un usuario web.

**EL MOTIVO:** Si el LLM tarda 4 segundos en responder, el navegador del usuario se queda congelado 4 segundos. Eso destruye la experiencia de usuario y bloquea los workers de PHP.

**LA SOLUCIÓN C.O.R.E.:** El Controlador solo puede hacer dos cosas:

1. Guarda el DTO en la base de datos con estado `pending` y despacha un Job en segundo plano (ej. `SendTaskToHubJob::dispatch()`).
2. Devuelve una respuesta rápida al frontend (ej. un DTO de "Tarea Aceptada") y deja que Reverb (WebSockets) entregue la respuesta de la IA cuando esté lista.

### 2. Pureza de las Acciones (Agnosticismo HTTP)

**LA REGLA:** Las clases dentro de `app/Actions` son ciegas a la web. **ESTRICTAMENTE PROHIBIDO** usar helpers como `request()`, `response()->json()`, `redirect()`, o leer cabeceras HTTP dentro de una Action.

**EL MOTIVO:** Una Action (ej. `ProcessHubWebhookAction`) debe poder ejecutarse desde un Controlador, desde un Comando de Artisan en la consola, o desde un Job en Redis. Si depende de la Request HTTP, rompes su reusabilidad por completo.

**LA SOLUCIÓN C.O.R.E.:**

* Las Actions **solo reciben** DTOs (o tipos primitivos) por parámetro.
* Las Actions **solo devuelven** DTOs (o Modelos).
* Si algo sale mal, **no devuelven un error 404 ni un JSON**; lanzan una Excepción de Dominio (ej. `TaskNotFoundException`), y es el Controlador (o el manejador de excepciones de Laravel) quien decide cómo traducir eso a una respuesta HTTP.

### 3. Códigos de Estado HTTP Nativos en DTOs

**LA REGLA:** Para cambiar el código HTTP de un DTO que implementa `Responsable`, **NO uses** `withResponse()` ni `response()->json()`. Sobrescribe el método `calculateResponseStatus(Request $request): int` heredado del trait de Spatie Data.

**EL MOTIVO:** Spatie Data ya maneja la conversión a respuesta HTTP. Alterar la respuesta manualmente rompe la cadena de responsabilidad del framework. Sobrescribir `calculateResponseStatus` es la forma más pura y nativa de inyectar códigos como 401, 404, 422 o 204.

**LA SOLUCIÓN C.O.R.E.:**

```php
class ApiErrorResponseDTO extends Data
{
    public function __construct(
        public readonly string $message,
        public readonly int $httpStatus = 400,
    ) {}

    public function calculateResponseStatus(\Illuminate\Http\Request $request): int
    {
        return $this->httpStatus;
    }
}
```
