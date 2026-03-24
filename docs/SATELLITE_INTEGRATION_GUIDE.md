# Guía de Integración para Satélites (Spokes)

Bienvenido a la documentación de integración de SunnyMatrix. Esta guía está diseñada para que los equipos técnicos de los satélites (Spokes) entiendan cómo interactuar con el motor cognitivo, qué tipos de agentes tienen a su disposición y cómo estructurar los datos.

## 1. Conceptos Core

SunnyMatrix funciona bajo un modelo asíncrono basado en **Tareas (Tasks)**. Vosotros (el Satélite) encoláis una tarea en el Hub, el Hub la procesa utilizando un **Agente** específico, y os devuelve el resultado a través de un **Webhook**.

### Tipos de Agentes Disponibles
Al aprovisionar un Tenant, podéis crear diferentes tipos de agentes según la necesidad:

1. **Conversacionales (`talker` / `financial-advisor`):**
   - Diseñados para interactuar con usuarios finales vía chat.
   - Tienen memoria de sesión y acceso a Bóvedas de Conocimiento (RAG).
   - Soportan "Tools Dinámicas" (pueden consultar vuestra base de datos en tiempo real).

2. **Extractores Visuales (`vision-extractor`):**
   - Diseñados para procesar documentos (PDFs, imágenes).
   - Extraen datos estructurados (ej. facturas, nóminas, tickets) forzando un esquema JSON estricto.
   - Son procesos "One-Shot" (sin memoria de chat).

3. **Clasificadores (`document-classifier`):**
   - Analizan texto crudo y lo categorizan según un árbol de decisión que vosotros defináis.

---

## 2. Tipado Estricto: El Payload de Entrada (Input Payload)

Todas las peticiones para ejecutar una tarea se envían al endpoint `POST /api/v1/spoke/agents/{id}/execute` utilizando el DTO `ExecuteAgentTaskRequest`. 

El campo `payload` de este DTO varía dependiendo del tipo de agente al que estéis llamando. A continuación se detallan las estructuras esperadas:

### A. Para Agentes Conversacionales
Si estáis enviando un mensaje programáticamente (sin usar nuestro Widget JS):
```json
{
  "message": "Hola, necesito ayuda con mi declaración de la renta.",
  "chat_session_id": "ulid_opcional_para_retomar_conversacion"
}
```
*(Nota: El historial de chat previo se envía en el parámetro `prefetched_chat_messages` del DTO principal, no dentro del payload).*

### B. Para Extractores Visuales (Documentos/Facturas)
Podéis enviar el documento mediante una URL pública o incrustado en Base64:
```json
{
  "file_url": "https://midominio.com/factura_123.pdf",
  "mime_type": "application/pdf"
}
```
*O vía Base64:*
```json
{
  "base64": "JVBERi0xLjQKJcOkw7zDtsOfCjIgMCBvYmoKPDwvTGVuZ3RoIDMgMCBSL0ZpbHRlci...",
  "mime_type": "application/pdf"
}
```

### C. Para Clasificadores de Texto
```json
{
  "content": "Texto completo del correo electrónico o documento a clasificar..."
}
```

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
- **Webhooks de Estado:** El Hub os notificará en tiempo real (a vuestro endpoint `/api/webhooks/hub`) cada vez que una tarea cambie de estado (`processing`, `completed`, `failed`).
- **Webhooks de Extracción:** Cuando un `vision-extractor` termina, recibiréis el JSON estructurado directamente en vuestro webhook para que lo guardéis en vuestra base de datos.
