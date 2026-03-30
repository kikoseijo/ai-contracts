# Contrato HTTP Hub <-> Spoke

Este documento es la **fuente de verdad operativa** para quien consume el Hub desde el Spoke (Laravel, Livewire, jobs). Si aqui no esta claro como mapear una respuesta, el Spoke queda **ciego**: arrays sueltos, `null` silenciosos y bugs en produccion.

## 1. Regla de oro: JSON -> DTO, no -> `$array['clave']`

Tras cada `Http::` / `HubCommunicationService`:

1. Mirar **codigo HTTP** y cabeceras si aplica.
2. Decodificar cuerpo a array **solo una vez** en el borde del cliente.
3. **Inmediatamente** hidratar un DTO del paquete `sunnyface/ai-contracts` con `SomeResponseDTO::from($payload)`.
4. El resto del codigo del Spoke solo usa **propiedades tipadas** del DTO.

**Prohibido** arrastrar `$response['vaults']`, `$body['task_id']`, etc. por Actions, Livewire o vistas.

## 2. Donde vive cada DTO

| Area | Namespace | Uso |
|------|-----------|-----|
| Respuestas de dominio compartidas (listados, metricas, webhooks) | `Sunnyface\Contracts\Data\Network\` | Cuerpo JSON 2xx con forma estable. Webhooks Hub->Spoke. Callbacks Spoke->Hub. |
| Respuestas de exito y error especificas | `Sunnyface\Contracts\Data\Spoke\Responses\` | `ApiErrorResponseDTO`, envelopes widget/funnel, listados. |
| Requests / payloads de entrada | `Sunnyface\Contracts\Data\Spoke\` | Requests y payloads polimorficos en `...\Payloads\`. |
| Configuracion por tipo de agente | `Sunnyface\Contracts\Data\Agent\` | Configs tipados: `TalkerConfigData`, `ExtractorConfigData`, etc. |
| Resultados de procesamiento | `Sunnyface\Contracts\Data\Classifier\`, `...\Extractor\`, etc. | DTOs de ejecucion interna y output. |
| Motor cognitivo (pipeline) | `Sunnyface\Contracts\Data\Llm\` | `CognitiveContextDTO` (maquina de estados), `AiMessageData`, `WorkerResultDTO`. |
| Gobernanza y metricas | `Sunnyface\Contracts\Data\Governance\`, `...\Metrics\` | `AgentInsightData`, `MonthlyBillingSummaryData`. |
| Ingesta de documentos (Vault) | `Sunnyface\Contracts\Data\Vault\` | DTOs de entrada para ingestion. |

### DTOs de Callback (Spoke -> Hub)

| DTO | Namespace | Proposito |
|-----|-----------|-----------|
| `ExtractionCallbackAckDTO` | `Sunnyface\Contracts\Data\Network\` | ACK del Hub al callback de extraccion del Spoke |

## 3. trace_id: El Cable de Trazabilidad

Todo intercambio Hub <-> Spoke debe portar un `trace_id` para correlacion end-to-end.

### Hub -> Spoke (Webhooks)

El Hub puede enviar el trace_id via:
- Header `X-Trace-Id`
- Campo `trace_id` en el body JSON

El Spoke (`SatelliteTransit`) los lee en ese orden de prioridad. Si ninguno esta presente, genera `sat-{ULID}`.

### Spoke -> Hub (Callbacks)

El Spoke incluye el `trace_id` en el body del callback:
```json
{
  "trace_id": "ext-01JXYZ...",
  "tenant_id": "...",
  "status": "completed|flagged",
  ...
}
```

### Telemetria

Cada transicion (pipe o job) escribe a Redis Streams en la conexion `telemetry`:
```
XADD cognitive_trace:{trace_id} * pipe NombreDelPipe elapsed_ms 12.345 status ok
```

Consultable: `XRANGE cognitive_trace:{trace_id} - +`

## 4. Errores: `ApiErrorResponseDTO`

El Hub suele responder errores con cuerpo JSON:

```json
{ "error": "Mensaje legible" }
```

Al hidratar **desde el Spoke**:

```php
$error = ApiErrorResponseDTO::from([
    'error' => (string) ($payload['error'] ?? 'Unknown error'),
    'httpStatus' => $response->status(),
]);
```

La regla: **tipar el error igual que el exito**.

## 5. `_hub_error` (solo Spoke, nunca Hub)

- **`_hub_error` no lo envia el Hub.** Es un marcador que puede añadir el `HubCommunicationService` del Spoke cuando hay timeout, red, 500 sin cuerpo parseable, etc.
- Si detectas `_hub_error`, **no** intentes hidratar un DTO de negocio.

## 6. Como responde el Hub (referencia)

Los DTOs extienden `Spatie\LaravelData\Data` e implementan `Responsable`. Los controladores retornan el DTO directamente y Laravel invoca `toResponse()`:

```php
// Controlador del Hub
public function index(SpokeTenantIdRequest $request): VaultListResponseDTO|ApiErrorResponseDTO
{
    return $this->listVaultsAction->execute($request->tenant());
}
```

## 7. Enums y fechas

- Los **enums** se serializan como su `value` (string); `::from()` los reconstruye.
- Fechas en DTOs de red van como **string** para estabilidad entre procesos.

## 8. Procesamiento en el Spoke: Pipeline, no Servicio

El Spoke ya no usa servicios monoliticos para procesamiento. Todo pasa por pipelines deterministicos con telemetria:

| Flujo | Pipeline | Pipes |
|-------|----------|-------|
| Webhook inbound | `InboundPayloadPipeline` | InitializeTelemetry -> HydrateEnvelope -> SanitizePii -> DetermineIntent |
| Extraccion documento | `DocumentExtractionPipeline` | VerifyQuota -> ExecuteVision -> Normalize -> KOR -> BTW -> Shadow -> Persist -> Callback |
| Intent texto (chat) | `RouteTextIntentPipeline` | SanitizePrompt -> AssembleTriage -> ExecuteLLM -> HydrateIntent -> ResolveLocally |
| Calculo fiscal NL | `CalculateNlProvisionPipeline` | ExtractProfile -> Box1 -> Rates -> Box3 -> Credits -> ZVW -> Aggregate |

Los jobs legacy (`ProcessInboundPayload`, `ExtractDataWithAI`, `RunAntivirusAudit`) usan `CognitiveTraceJobMiddleware` para escribir a la misma traza Redis.
