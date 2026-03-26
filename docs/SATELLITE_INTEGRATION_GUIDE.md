# Guía de Integración para Satélites (Spokes)

Bienvenido a la documentación de integración de SunnyMatrix. Esta guía está diseñada para que los equipos técnicos de los satélites (Spokes) entiendan cómo interactuar con el motor cognitivo, qué tipos de agentes tienen a su disposición y cómo estructurar los datos.

## 1. Conceptos Core

SunnyMatrix funciona bajo un modelo asíncrono basado en **Tareas (Tasks)**. Vosotros (el Satélite) encoláis una tarea en el Hub, el Hub la procesa utilizando un **Agente** específico, y os devuelve el resultado a través de un **Webhook**.

### Tipos de Agentes Disponibles (`HandlerSlug`)

Al aprovisionar un Tenant, podéis crear diferentes tipos de agentes según la necesidad. El enum `HandlerSlug` define todos los tipos válidos:

1. **Conversacionales (`talker` / `financial-advisor` / `customs-advisor`):**
   - Diseñados para interactuar con usuarios finales vía chat.
   - Tienen memoria de sesión y acceso a Bóvedas de Conocimiento (RAG).
   - Soportan "Tools Dinámicas" (pueden consultar vuestra base de datos en tiempo real).
   - `customs-advisor` es un conversacional especializado en normativa aduanera.

2. **Traductores (`text-translator`):**
   - Traducen contenido textual entre idiomas configurados.
   - Soportan tono corporativo, palabras prohibidas y detección de idioma origen.
   - Son procesos "One-Shot" (sin memoria de chat).

3. **Extractores Visuales (`vision-extractor` / `financial-extractor`):**
   - Diseñados para procesar documentos (PDFs, imágenes).
   - Extraen datos estructurados (ej. facturas, nóminas, tickets) forzando un esquema JSON estricto.
   - `financial-extractor` es un extractor especializado en documentación financiera (facturas, recibos, notas de crédito) con `DocumentLineData` tipado.
   - Son procesos "One-Shot" (sin memoria de chat).

4. **Clasificadores (`document-classifier`):**
   - Analizan texto crudo y lo categorizan según un árbol de decisión que vosotros defináis.
   - Devuelven categoría, prioridad, resumen y score de confianza (`ClassifierOutputDTO`).

5. **Meta-Agente (`meta-agent`):**
   - Agente supervisor que analiza el rendimiento de los demás agentes del tenant.
   - Proporciona insights, blind spots y recomendaciones operativas.
   - Interfaz conversacional (chat) sobre datos de telemetría agregados.

6. **Ingesta de Bóvedas (`vault.ingest`):**
   - Agente interno para procesamiento de documentos en bóvedas de conocimiento.
   - No se expone directamente a usuarios finales.

---

## 2. Tipado Estricto: El Payload de Entrada (Input Payload)

Todas las peticiones para ejecutar una tarea se envían al endpoint `POST /api/v1/spoke/agents/{id}/execute` utilizando el DTO `ExecuteAgentTaskRequest`.

El campo `payload` de este DTO varía dependiendo del tipo de agente al que estéis llamando. Cada variante tiene su propio **DTO polimórfico** en `Sunnyface\Contracts\Data\Spoke\Payloads\`:

### A. Para Agentes Conversacionales — `ConversationalPayloadDTO`

Si estáis enviando un mensaje programáticamente (sin usar nuestro Widget JS):

```json
{
  "message": "Hola, necesito ayuda con mi declaración de la renta.",
  "chat_session_id": "ulid_opcional_para_retomar_conversacion"
}
```

*(Nota: El historial de chat previo se envía en el parámetro `prefetched_chat_messages` del DTO principal, no dentro del payload).*

### B. Para Extractores Visuales — `VisionExtractorPayloadDTO`

Podéis enviar el documento mediante una URL pública o incrustado en Base64:

```json
{
  "file_url": "https://midominio.com/factura_123.pdf",
  "mime_type": "application/pdf",
  "force_schema": "invoice"
}
```

*O vía Base64:*

```json
{
  "base64": "JVBERi0xLjQKJcOkw7zDtsOfCjIgMCBvYmoKPDwvTGVuZ3RoIDMgMCBSL0ZpbHRlci...",
  "mime_type": "application/pdf"
}
```

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| `file_url` | `string` | No* | URL pública o ruta del documento |
| `base64` | `string` | No* | Contenido codificado en Base64 |
| `mime_type` | `string` | No | Tipo MIME del documento |
| `force_schema` | `string` | No | Slug del esquema a forzar (ej. `invoice`, `receipt`, `id_card`) |

*\*Se requiere al menos `file_url` o `base64`.*

### C. Para Clasificadores de Texto — `DocumentClassifierPayloadDTO`

```json
{
  "content": "Texto completo del correo electrónico o documento a clasificar..."
}
```

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| `content` | `string` | **Si** | Texto a clasificar |
| `file_url` | `string` | No | URL del documento (alternativa al texto plano) |
| `base64` | `string` | No | Contenido codificado en Base64 (alternativa) |

---

## 3. Bóvedas de Conocimiento (Vaults)

Las bóvedas son el "cerebro" de los agentes conversacionales. Existen dos formas de usarlas:

1. **Shadow Vault (Privada):** Cada agente tiene una bóveda privada asignada por defecto. Es ideal para subir documentos exclusivos de ese usuario (ej. "Mis nóminas de 2023").
2. **Bóvedas Globales (Compartidas):** Vosotros podéis crear bóvedas a nivel de plataforma (ej. "Legislación Estatal") y enlazarlas dinámicamente a los agentes de vuestros usuarios mediante el endpoint de sincronización de bóvedas.

---

## 4. Conectividad y Add-ons

Para facilitar la automatización, SunnyMatrix ofrece interfaces de entrada y salida sin necesidad de escribir código:

### Inbound (Entrada hacia el Hub)

- **Webhooks de Ingesta:** Podéis configurar vuestros propios sistemas (ej. Zapier, Make, o vuestro backend) para disparar tareas enviando un POST directamente a la URL única del agente.
- **Email Inbound:** Cada agente Extractor tiene una dirección de email única. Si un usuario reenvía una factura a ese correo, el Hub crea la tarea automáticamente y os notifica cuando extrae los datos.

### Outbound (Salida hacia el Satélite)

- **Webhooks de Estado:** El Hub os notificará en tiempo real (a vuestro endpoint `/api/webhooks/hub`) cada vez que una tarea cambie de estado (`processing`, `completed`, `failed`). El DTO recibido será `TaskStatusWebhookDTO`.
- **Webhooks de Extracción:** Cuando un `vision-extractor` termina, recibiréis el JSON estructurado directamente en vuestro webhook para que lo guardéis en vuestra base de datos (`ExtractionHubWebhookDTO`).
- **Webhooks de Tools Dinámicas:** Cuando un agente conversacional necesita datos en tiempo real de vuestro sistema, el Hub envía una petición **síncrona** a vuestro endpoint `/api/webhooks/hub/tools`. Debéis exponer esta ruta protegida con verificación HMAC (`X-Hub-Signature`).

---

## 5. Tools Dinámicas (Spoke Tool Execution)

Los agentes conversacionales pueden invocar "tools" definidas por el Satélite para consultar datos en tiempo real (ej. saldo de un cliente, facturas pendientes). El flujo es:

1. El Hub envía un `POST` síncrono a `{spoke_url}/api/webhooks/hub/tools` con un `SpokeToolExecutionRequestDTO`.
2. El Spoke identifica el `tool_name` y ejecuta la lógica de negocio correspondiente.
3. El Spoke responde con un `SpokeToolExecutionResponseDTO` que incluye `success`, `data` (resultado serializado) y opcionalmente `error_message`.

```php
// Ejemplo de Action en el Spoke
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

Las tools disponibles se definen mediante `SpokeToolDefinitionDTO` al configurar el agente.
