# Matriz Hub → rutas compartidas con Spoke / S2S

**Estado:** inventario de `routes/api.php` (Hub). Los DTOs viven en `sunnyface/ai-contracts` salvo indicación (`App\Data\...`).

**Convenciones:** muchos endpoints devuelven `ApiErrorResponseDTO` en 404/422 además del DTO de éxito indicado. El **404 por tenant inexistente** lo responde el middleware `hydrate.spoke.tenant` (`ApiErrorResponseDTO('Tenant not found.', 404)`), no las Actions.

**Firmas PHP (Hub):** los controladores en `app/Http/Controllers/Api/` declaran **uniones explícitas** (`SuccessDTO|ApiErrorResponseDTO`) en lugar de `Responsable`, para que Claudia/Spoke vean el contrato en el IDE. La lógica de negocio vive en `App\Actions\Spoke\*` invocada desde el controlador.

**Tenant en Spoke:** grupo de rutas `middleware(['satellite', 'hydrate.spoke.tenant'])`. Lee `tenant_id` desde query, body o cabecera `X-Tenant-Id`; omite hidratación en `POST /provision-tenant` y si falta `tenant_id` (el FormRequest correspondiente puede devolver 422).

---

## Middleware `satellite` + `hydrate.spoke.tenant` — `prefix: v1/spoke`

| Método | Ruta | Controlador | Entrada (request / Data) | Respuesta principal (éxito) |
|--------|------|-------------|---------------------------|------------------------------|
| POST | `/provision-tenant` | `ProvisionTenantController` | `ProvisionTenantRequest` | `ProvisionTenantResponseDTO` |
| GET | `/vaults` | `VaultController@index` | `SpokeTenantIdRequest` (query/body `tenant_id`) | `VaultListResponseDTO` |
| POST | `/vaults` | `VaultController@store` | `CreateVaultRequest` → `toDTO()` | `VaultCreatedResponseDTO` |
| DELETE | `/vaults/{id}` | `VaultController@destroy` | `SpokeTenantIdRequest` | `NoContentResponseDTO` |
| GET | `/vaults/{id}/documents` | `VaultController@documents` | `SpokeTenantIdRequest` | `VaultDocumentsResponseDTO` |
| GET | `/vaults/{id}/metrics` | `VaultController@metrics` | `SpokeTenantIdRequest` | `VaultVectorMetricsResponseDTO` |
| POST | `/vaults/{vault_id}/documents` | `VaultDocumentController@store` | `UploadDocumentRequest` | `VaultDocumentQueuedResponseDTO` ⚠️ ver nota |
| DELETE | `/vaults/{vault_id}/documents/{doc_id}` | `VaultDocumentController@destroy` | `SpokeTenantIdRequest` | `NoContentResponseDTO` |
| POST | `/vaults/{vault_id}/documents/{doc_id}/reindex` | `VaultDocumentController@reindex` | `SpokeTenantIdRequest` | `VaultDocumentQueuedResponseDTO` |
| POST | `/knowledge/ingest` | `KnowledgeController@ingest` | `IngestKnowledgeRequest` | `KnowledgeIngestQueuedResponseDTO` |

> ⚠️ **Flujo correcto para ingesta con `task_id` garantizado (Rag/Classification):**
> 1. `POST /vaults/{vault_id}/documents` → crea el `VaultDocument`, devuelve `document_id`. El campo `task_id` puede ser `null` para tipos Audio/Video/Extraction.
> 2. `POST /knowledge/ingest` con `{ vault_document_id }` → encola el procesamiento, devuelve `task_id` **siempre presente** para hacer polling.
>
> **No uses el paso 1 para obtener `task_id`.** Usa `/knowledge/ingest` si necesitas rastrear el estado del procesamiento.
| POST | `/agents/magic-draft` | `MagicDraftController` | `MagicDraftRequest` | `MagicDraftCreatedResponseDTO` |
| GET | `/agents` | `AgentController@index` | `SpokeTenantIdRequest` | `AgentListResponseDTO` |
| POST | `/agents` | `AgentController@store` | `CreateAgentRequest` | `AgentCreatedResponseDTO` |
| GET | `/agents/{id}` | `AgentController@show` | `SpokeTenantIdRequest` | `AgentShowResponseDTO` |
| PUT | `/agents/{id}` | `AgentController@update` | `UpdateAgentRequest` | `AgentUpdatedResponseDTO` |
| DELETE | `/agents/{id}` | `AgentController@destroy` | `tenant_id` (body/query) | `204 No Content` |
| PUT | `/agents/{id}/toggle` | `AgentController@toggle` | `ToggleAgentRequest` | `AgentToggledResponseDTO` |
| PUT | `/agents/{id}/extractor-config` | `AgentController@updateExtractorConfig` | `UpdateExtractorConfigRequest` | `AgentExtractorConfigResponseDTO` |
| PUT | `/agents/{id}/config` | `AgentController@updateConfig` | `UpdateAgentConfigRequestDTO` (`Network\`) | `AgentConfigUpdatedResponseDTO` |
| PUT | `/agents/{id}/vaults/sync` | `AgentController@syncVaults` | `SyncAgentVaultsRequest` | `AgentUpdatedResponseDTO` |
| POST | `/agents/{id}/approve-inspector-schema` | `AgentController@approveInspectorSchema` | `ApproveInspectorSchemaRequest` | `AgentExtractorConfigResponseDTO` |
| POST | `/agents/{id}/execute` | `ExecuteAgentTaskController@store` | `ExecuteAgentTaskRequest` | `TaskCreatedResponseDTO` (`Network\`, tarea worker) |
| GET | `/agents/{tenant_agent_id}/chat-history` | `ChatHistoryController@show` | `SpokeTenantIdRequest` | `ChatHistoryResponseDTO` |
| GET | `/connections` | `ConnectionsController@show` | `SpokeTenantIdRequest` | `ConnectionsResponseDTO` |
| GET | `/blind-spots` | `BlindSpotsController@show` | `SpokeTenantIdRequest` | `BlindSpotsResponseDTO` |
| GET | `/disk-usage` | `DiskUsageController@show` | `SpokeTenantIdRequest` | `DiskUsageResponseDTO` |
| GET | `/quota` | `QuotaController@show` | `SpokeTenantIdRequest` | `QuotaResponseDTO` |
| POST | `/quota/top-up` | `QuotaController@topUp` | `TopUpQuotaRequest` | `QuotaTopUpResponseDTO` |
| GET | `/schemas` | `SchemaController@index` | `SchemaIndexRequest` | `SchemaListResponseDTO` |
| GET | `/tasks/status` | `TaskStatusController@index` | `ids` (query, comma-separated ULIDs) | `BulkTaskStatusResponseDTO` |
| GET | `/meta-agent/insight` | `InsightController@show` | `SpokeTenantIdRequest` | `InsightResponseDTO` |
| POST | `/meta-agent/chat` | `MetaAgentController@chat` | `MetaAgentChatRequest` | `MetaAgentReplyResponseDTO` |

---

## `auth:sanctum` + tenant API — `prefix: v1/hub`

| Método | Ruta | Controlador | Entrada | Respuesta principal |
|--------|------|-------------|---------|---------------------|
| POST | `/tasks` | `TaskIngestionController` | `IngestAgentTaskRequest` | `TaskCreatedResponseDTO` |
| POST | `/agents/{tenant_agent_id}/execute` | `AgentGatewayController@handle` | `string $tenant_agent_id` (sin Form Request dedicado) | `TaskCreatedResponseDTO \| ApiErrorResponseDTO` |
| POST | `/vault/ingest/text` | `VaultIngestionController@ingestPost` | `HubIngestTextData` (`App\Data\Vault\`) | `VaultDocumentQueuedResponseDTO` |
| POST | `/vault/ingest/file` | `VaultIngestionController@ingestFile` | `HubIngestFileData` (`App\Data\Vault\`) | `VaultDocumentQueuedResponseDTO` |

---

## Widget (público) — `prefix: v1/widget`

| Método | Ruta | Controlador | Entrada | Respuesta principal |
|--------|------|-------------|---------|---------------------|
| GET | `/{tenant_agent_id}/embed.js` | `WidgetApiController@embedScript` | — | `Response` (JS) |
| POST | `/{tenant_agent_id}/chat` | `WidgetApiController@sendMessage` | `WidgetSendMessageRequest` | `WidgetChatEnqueuedResponseDTO` / `WidgetRateLimitedResponseDTO` |
| GET | `/task/{task_id}/status` | `WidgetApiController@checkStatus` | — | `WidgetTaskStatusResponseDTO` |

---

## Funnel (sin prefijo satélite)

| Método | Ruta | Controlador | Entrada | Respuesta principal |
|--------|------|-------------|---------|---------------------|
| POST | `/v1/funnel/{tenant_agent_id}/intake` | `ContactFunnelController@handle` | `ContactFunnelRequest` | `ContactFunnelQueuedResponseDTO` |
| GET | `/v1/funnel/tasks/{task_id}/status` | `ContactFunnelController@checkStatus` | — | `ContactFunnelStatusResponseDTO` |

---

## Webhooks inbound — `prefix: v1/webhooks`

| Método | Ruta | Controlador | Entrada | Respuesta |
|--------|------|-------------|---------|-----------|
| POST | `/email` | `VaultIngestionController@ingestEmail` | `InboundEmailPayloadDTO` (`App\Data\Vault\`) | `NoContentResponseDTO` (204) |

---

## Webhooks salientes Hub → Spoke (Endpoint Genérico)

Todos los webhooks asíncronos se envían a **`POST {spoke_url}/api/webhooks/hub`**. El Spoke enruta internamente por la cabecera `X-Sunnyface-Event`.

| `X-Sunnyface-Event` | DTO (`Sunnyface\Contracts\Data\Network\`) | Descripción |
|----------------------|-------------------------------------------|-------------|
| `task.status_changed` | `TaskStatusWebhookDTO` | Cambio de estado de tarea (`processing`, `completed`, `failed`) |
| `extraction.completed` | `ExtractionHubWebhookDTO` | Extracción exitosa con datos estructurados |
| `extraction.failed` | `ExtractionHubWebhookDTO` | Extracción fallida con mensaje de error |
| `vault.document.status_changed` | `VaultDocumentWebhookDTO` | Cambio de estado de documento en bóveda |
| `vault.document.status_changed` | `VaultDocumentIndexedWebhookDTO` | Confirmación de documento indexado |
| `schema.discovered` | `SchemaDiscoveredWebhookDTO` | Nuevo esquema descubierto por inspector |
| `usage.reported` | `UsageWebhookDTO` | Telemetría de consumo de IA por tenant |
| `quota.updated` | `QuotaUpdatedWebhookDTO` | Cambio de cuota tras consumo |
| `billing.quota_sync` | `QuotaUpdatedWebhookDTO` | Reconciliación periódica de saldo |
| `governance.insight_generated` | `GovernanceInsightWebhookDTO` | Insight de auditoría AIOps |

**Nota:** `HubWebhookDTO`, `SunnyGestorWebhookDTO` y `TenantTaskCompletedWebhookDTO` siguen disponibles como DTOs internos para casos específicos de integración.

---

## Callbacks Spoke → Hub (Asíncrono)

El Spoke envía callbacks al Hub cuando completa procesamiento local. Cada callback incluye el `trace_id` para correlación.

| Metodo | Ruta (en el Hub) | DTO Entrada (`Network\`) | DTO Respuesta (`Network\`) |
|--------|------------------|--------------------------|----------------------------|
| POST | `/api/v1/spoke/extraction/callback` | `SpokeExtractionCallbackDTO` | `ExtractionCallbackAckDTO` |

El Spoke construye `SpokeExtractionCallbackDTO` (tipado, del paquete `ai-contracts`) y lo envia via `HubCommunicationService::post($callback, ExtractionCallbackAckDTO::class)`. Cero arrays manuales. Si el callback falla, el error se registra en telemetria pero no bloquea el flujo.

---

## Tools Dinámicas (Síncrono) — Excepción al Endpoint Genérico

Las tools dinámicas son la **única excepción** al endpoint genérico: se envían a `POST {spoke_url}/api/webhooks/hub/tools` de forma **síncrona** (el Hub espera respuesta).

| Método | Ruta (en el Spoke) | Entrada | Respuesta |
|--------|---------------------|---------|-----------|
| POST | `/api/webhooks/hub/tools` | `SpokeToolExecutionRequestDTO` | `SpokeToolExecutionResponseDTO` |

Ambos endpoints (`/api/webhooks/hub` y `/api/webhooks/hub/tools`) deben estar protegidos por verificación de firma HMAC (`X-Sunnyface-Signature`).

---

## Procesamiento Spoke: Arquitectura Pipeline

El Spoke ya no usa servicios monolíticos. Todo procesamiento pasa por pipelines deterministas con telemetría distribuida en Redis.

### Pipeline Inbound (Webhook Hub → Spoke)

```
Request → [VerifyHubSignature middleware HTTP]
  → InitializeSatelliteTelemetryPipe
  → HydrateEnvelopePipe
  → SanitizePiiPipe
  → DetermineIntentPipe → despacha al handler correcto
```

### Pipeline Extracción (Documento → Hub callback)

```
ExtractDataWithAI (Job + CognitiveTraceJobMiddleware)
  → DocumentExtractionPipeline:
    VerifyTenantQuotaPipe
    ExecuteVisionExtractionPipe
    NormalizeExtractedDataPipe
    ApplyKorExemptionPipe (NL)
    ValidateBtwCuadraturaPipe (NL)
    RunShadowInspectorPipe (NL)
    PersistExtractionResultPipe
    DispatchCallbackToHubPipe → POST /api/v1/spoke/extraction/callback
```

Nota: el PUT de `UpdateSpokeAgentConfigAction` requiere enviar siempre `name`, `greeting`, `custom_instructions` y `vault_ids` (no soporta partial update). `spoke_tools` sigue siendo opcional.
