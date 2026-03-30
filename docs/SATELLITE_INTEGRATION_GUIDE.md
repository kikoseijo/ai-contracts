# Guia de Integracion para Satelites (Spokes)

Documentacion de integracion de SunnyMatrix. Esta guia esta diseñada para que los equipos tecnicos de los satelites (Spokes) entiendan como interactuar con el motor cognitivo, que tipos de agentes tienen a su disposicion y como estructurar los datos.

## 1. Conceptos Core

SunnyMatrix funciona bajo un modelo asincrono basado en **Tareas (Tasks)**. Vosotros (el Satelite) encolais una tarea en el Hub, el Hub la procesa utilizando un **Agente** especifico, y os devuelve el resultado a traves de un **Webhook**.

### Arquitectura del Satelite: Pipelines Deterministicos

El Satelite implementa una arquitectura de **Pipelines puros** basada en `Illuminate\Pipeline\Pipeline`. Todo el procesamiento pasa por cadenas de Pipes con telemetria distribuida en Redis.

#### Infraestructura base

| Clase | Namespace | Rol |
|-------|-----------|-----|
| `SatellitePipeline` | `App\Pipelines\` | Extiende `Pipeline`. Cada pipe se mide con `hrtime()` via `RecordSatelliteTransition` |
| `PipelineTransit` | `App\Pipelines\Contracts\` | Interfaz comun: `traceId(): string`, `workspaceId(): ?string` |
| `RecordSatelliteTransition` | `App\Pipes\Middleware\` | Escribe `XADD` a Redis `telemetry` en clave `cognitive_trace:{trace_id}` |

#### Pipelines disponibles

| Pipeline | Transit DTO | Proposito |
|----------|-------------|-----------|
| `InboundPayloadPipeline` | `SatelliteTransit` | Procesa webhooks del Hub (hidrata envelope, sanitiza PII, determina intent) |
| `RouteTextIntentPipeline` | `TextIntentTransit` | Enruta mensajes de chat (HUB vs LOCAL) via LLM rapido |
| `CalculateNlProvisionPipeline` | `NlTaxTransit` | Calculo fiscal NL: Box1 + Box3 + Credits + ZVW |
| `DocumentExtractionPipeline` | `ExtractionTransit` | Extraccion Vision AI + Antivirus Contable NL + Callback al Hub |

#### Telemetria

Cada transicion (pipe o job) escribe a Redis Streams:
```
XRANGE cognitive_trace:{trace_id} - +
```

Campos por entrada: `pipe`, `fqcn`, `elapsed_ms`, `status` (ok/fatal), `workspace_id`, `timestamp`, `error` (si fatal).

Conexion Redis dedicada: `telemetry` (database 2, sin prefix).

### Tipos de Agentes Disponibles (`HandlerSlug`)

Al aprovisionar un Tenant, podeis crear diferentes tipos de agentes segun la necesidad. El enum `HandlerSlug` define todos los tipos validos:

1. **Conversacionales (`talker` / `financial-advisor` / `customs-advisor`):**
   - Diseñados para interactuar con usuarios finales via chat.
   - Tienen memoria de sesion y acceso a Bovedas de Conocimiento (RAG).
   - Soportan "Tools Dinamicas" (pueden consultar vuestra base de datos en tiempo real).
   - `customs-advisor` es un conversacional especializado en normativa aduanera.

2. **Traductores (`text-translator`):**
   - Traducen contenido textual entre idiomas configurados.
   - Son procesos "One-Shot" (sin memoria de chat).

3. **Extractores Visuales (`vision-extractor` / `financial-extractor`):**
   - Diseñados para procesar documentos (PDFs, imagenes).
   - Extraen datos estructurados (ej. facturas, nominas, tickets) forzando un esquema JSON estricto.
   - `financial-extractor` es un extractor especializado en documentacion financiera.
   - Son procesos "One-Shot" (sin memoria de chat).

4. **Clasificadores (`document-classifier`):**
   - Analizan texto crudo y lo categorizan segun un arbol de decision que vosotros definais.
   - Devuelven categoria, prioridad, resumen y score de confianza (`ClassifierOutputDTO`).

5. **Meta-Agente (`meta-agent`):**
   - Agente supervisor que analiza el rendimiento de los demas agentes del tenant.
   - Proporciona insights, blind spots y recomendaciones operativas.

6. **Ingesta de Bovedas (`vault.ingest`):**
   - Agente interno para procesamiento de documentos en bovedas de conocimiento.
   - No se expone directamente a usuarios finales.

---

## 2. Tipado Estricto: El Payload de Entrada (Input Payload)

Todas las peticiones para ejecutar una tarea se envian al endpoint `POST /api/v1/spoke/agents/{id}/execute` utilizando el DTO `ExecuteAgentTaskRequest`.

El campo `payload` de este DTO varia dependiendo del tipo de agente al que esteis llamando. Cada variante tiene su propio **DTO polimorfco** en `Sunnyface\Contracts\Data\Spoke\Payloads\`:

### A. Para Agentes Conversacionales — `ConversationalPayloadDTO`

```json
{
  "message": "Hola, necesito ayuda con mi declaracion de la renta.",
  "chat_session_id": "ulid_opcional_para_retomar_conversacion"
}
```

*(Nota: El historial de chat previo se envia en el parametro `prefetched_chat_messages` del DTO principal, no dentro del payload).*

### B. Para Extractores Visuales — `VisionExtractorPayloadDTO`

```json
{
  "file_url": "https://midominio.com/factura_123.pdf",
  "mime_type": "application/pdf",
  "force_schema": "invoice"
}
```

| Campo | Tipo | Requerido | Descripcion |
|-------|------|-----------|-------------|
| `file_url` | `string` | No* | URL publica o ruta del documento |
| `base64` | `string` | No* | Contenido codificado en Base64 |
| `mime_type` | `string` | No | Tipo MIME del documento |
| `force_schema` | `string` | No | Slug del esquema a forzar (ej. `invoice`, `receipt`, `id_card`) |

*\*Se requiere al menos `file_url` o `base64`.*

### C. Para Clasificadores de Texto — `DocumentClassifierPayloadDTO`

```json
{
  "content": "Texto completo del correo electronico o documento a clasificar..."
}
```

---

## 3. Bovedas de Conocimiento (Vaults)

Las bovedas son el "cerebro" de los agentes conversacionales. Existen dos formas de usarlas:

1. **Shadow Vault (Privada):** Cada agente tiene una boveda privada asignada por defecto.
2. **Bovedas Globales (Compartidas):** Se pueden crear bovedas a nivel de plataforma y enlazarlas dinamicamente a los agentes mediante el endpoint de sincronizacion de bovedas.

---

## 4. Conectividad y Add-ons

### Inbound (Entrada hacia el Hub)

- **Webhooks de Ingesta:** Podeis configurar vuestros propios sistemas para disparar tareas enviando un POST directamente a la URL unica del agente.
- **Email Inbound:** Cada agente Extractor tiene una direccion de email unica. Si un usuario reenvia una factura a ese correo, el Hub crea la tarea automaticamente.

### Outbound (Salida hacia el Satelite)

El Spoke debe exponer **solo dos endpoints** para recibir comunicaciones del Hub:

| Endpoint | Tipo | Proposito |
|----------|------|-----------|
| `POST /api/webhooks/hub` | Asincrono | Todos los eventos de negocio (tareas, extracciones, cuota, governance, etc.) |
| `POST /api/webhooks/hub/tools` | Sincrono | Ejecucion de tools dinamicas durante conversacion |

Ambos endpoints deben verificar la firma HMAC con la cabecera `X-Sunnyface-Signature`.

El Hub identifica cada evento con la cabecera `X-Sunnyface-Event`. El Spoke lo procesa a traves del `InboundPayloadPipeline`:

```
Request -> [VerifyHubSignature middleware HTTP]
  -> InitializeSatelliteTelemetryPipe
  -> HydrateEnvelopePipe
  -> SanitizePiiPipe
  -> DetermineIntentPipe -> despacha al handler correcto
```

Cada paso se traza en Redis via `XADD cognitive_trace:{trace_id}`.

#### Resolucion del trace_id

El `SatelliteTransit` extrae el `trace_id` en orden de prioridad:
1. Header `X-Trace-Id`
2. Campo `trace_id` en el body JSON
3. Genera `sat-{ULID}` automaticamente

#### Mapa de Eventos (`X-Sunnyface-Event`)

| Evento | DTO esperado (`Sunnyface\Contracts\Data\Network\`) | Descripcion |
|--------|-----------------------------------------------------|-------------|
| `task.status_changed` | `TaskStatusWebhookDTO` | Cambio de estado de tarea (`processing`, `completed`, `failed`) |
| `extraction.completed` | `ExtractionHubWebhookDTO` | Extraccion exitosa con datos estructurados |
| `extraction.failed` | `ExtractionHubWebhookDTO` | Extraccion fallida con mensaje de error |
| `vault.document.status_changed` | `VaultDocumentWebhookDTO` | Cambio de estado de documento en boveda |
| `schema.discovered` | `SchemaDiscoveredWebhookDTO` | Nuevo esquema descubierto por inspector |
| `usage.reported` | `UsageWebhookDTO` | Telemetria de consumo de IA por tenant |
| `quota.updated` | `QuotaUpdatedWebhookDTO` | Cambio de cuota tras consumo de tarea |
| `billing.quota_sync` | `QuotaUpdatedWebhookDTO` | Reconciliacion periodica de saldo de tokens |
| `governance.insight_generated` | `GovernanceInsightWebhookDTO` | Insight de auditoria AIOps |

### Callback Satelite -> Hub (Extraction)

Cuando el `DocumentExtractionPipeline` completa el procesamiento local, el ultimo pipe (`DispatchCallbackToHubPipe`) envia un POST al Hub:

```
POST /api/v1/spoke/extraction/callback
```

Payload:
```json
{
  "trace_id": "ext-01JXYZ...",
  "tenant_id": "hub-tenant-uuid",
  "document_id": "local-document-uuid",
  "status": "completed|flagged",
  "extracted_data": { "base_amount": 100.0, "tax_amount": 21.0, ... },
  "validation_errors": [],
  "audit_risk_note": null
}
```

Respuesta esperada: `ExtractionCallbackAckDTO` (`Sunnyface\Contracts\Data\Network\`).

---

## 5. Tools Dinamicas (Spoke Tool Execution)

Los agentes conversacionales pueden invocar "tools" definidas por el Satelite para consultar datos en tiempo real (ej. saldo de un cliente, facturas pendientes). El flujo es:

1. El Hub envia un `POST` sincrono a `{spoke_url}/api/webhooks/hub/tools` con un `SpokeToolExecutionRequestDTO`.
2. El Spoke identifica el `tool_name` y ejecuta la logica de negocio correspondiente.
3. El Spoke responde con un `SpokeToolExecutionResponseDTO` que incluye `success`, `data` y opcionalmente `error_message`.

```php
public function execute(SpokeToolExecutionRequestDTO $request): SpokeToolExecutionResponseDTO
{
    return match ($request->tool_name) {
        'consultar_resumen_fiscal' => $this->taxEngine->getSummary($request->parameters),
        default => new SpokeToolExecutionResponseDTO(
            success: false,
            data: [],
            error_message: "Tool '{$request->tool_name}' no registrada.",
        ),
    };
}
```

---

## 6. Pipeline de Extraccion de Documentos

El flujo completo de extraccion en el Satelite:

```
[Upload] -> ProcessInboundPayload (Job + CognitiveTraceJobMiddleware)
               |
         ExtractDataWithAI (Job + CognitiveTraceJobMiddleware)
               |
         DocumentExtractionPipeline:
           VerifyTenantQuotaPipe          -> verifica tokens del owner
           ExecuteVisionExtractionPipe    -> delega al Hub o simula
           NormalizeExtractedDataPipe     -> JSON crudo -> payload tipado
           ApplyKorExemptionPipe          -> NL: KOR si YTD <= 20k
           ValidateBtwCuadraturaPipe      -> NL: base+tax=total, rates 0/9/21%
           RunShadowInspectorPipe         -> NL: scrutiny keywords, ledger, confianza
           PersistExtractionResultPipe    -> Document + PendingValidation
           DispatchCallbackToHubPipe      -> POST callback con trace_id
```

Los jobs legacy (`ProcessInboundPayload`, `ExtractDataWithAI`, `RunAntivirusAudit`) tienen `CognitiveTraceJobMiddleware` que escribe a la misma traza Redis que los pipes del pipeline.

## 7. Motor Fiscal NL (Pipeline)

El calculo de provision fiscal para ZZP (autonomos holandeses) se ejecuta via pipeline:

```
CalculateNlProvisionPipeline:
  ExtractZzpProfilePipe       -> extrae perfil desde Documents + tax_settings
  CalculateBox1BasePipe        -> zelfstandigenaftrek, startersaftrek, MKB 13.33%
  ApplyBox1RatesPipe           -> tramos 36.97% / 49.50%
  CalculateBox3TaxPipe         -> patrimonio: 57k exento, 4% ficticio, 36% tax
  CalculateTaxCreditsPipe      -> algemene heffingskorting + arbeidskorting
  CalculateZvwPipe             -> 5.32% sobre profit (cap 71.628)
  AggregateTotalTaxPipe        -> max(0, box1+box3-credits) + zvw
```

Accesible via `TaxEngineService::getAnnualProvision()` o directamente:
```php
$transit = App::make(CalculateNlProvisionPipeline::class)
    ->calculateForProfile($workspace, $profile, $year);
$transit->totalProvision; // float
```
