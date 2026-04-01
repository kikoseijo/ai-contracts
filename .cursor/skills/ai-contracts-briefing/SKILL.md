---
name: ai-contracts-briefing
description: Briefing obligatorio del paquete sunnyface/ai-contracts. Activa SIEMPRE que toques DTOs, webhooks, comunicación Hub-Spoke, o el namespace Sunnyface\Contracts. Contiene reglas irrompibles y dónde leer los contratos reales en vendor/.
---

# BRIEFING OPERATIVO: sunnyface/ai-contracts

Estás en un proyecto **consumidor** del paquete `sunnyface/ai-contracts` — el **Single Source of Truth** de toda la comunicación Hub↔Spoke. Lee esto antes de escribir código relacionado con DTOs o webhooks.

---

## 0. ARQUITECTO DEL PAQUETE

El propietario es **Kiko**. Ningún agente tiene autorización para modificar el paquete. Si detectas un problema, **reporta el archivo y la línea exacta, y espera instrucciones**.

---

## 1. REGLA ABSOLUTA: vendor/ ES SOLO LECTURA

```text
PROHIBIDO crear, editar o eliminar archivos en vendor/sunnyface/ai-contracts/
```

Sin excepciones. El código correcto vive en `app/` y `tests/` del proyecto actual.

---

## 2. DÓNDE ESTÁN LOS CONTRATOS (vendor/)

Antes de usar un DTO, **lee su firma directamente en vendor/**. El código es la verdad, no ningún documento.

```text
vendor/sunnyface/ai-contracts/src/
├── Data/
│   ├── Network/         ← Webhooks Hub→Spoke (entrantes al Spoke)
│   ├── Spoke/           ← Requests Spoke→Hub (salientes del Spoke)
│   │   └── Responses/   ← Responses que el Hub devuelve
│   ├── Agent/           ← Config de agentes
│   ├── Llm/             ← Mensajes, citas, contexto cognitivo
│   ├── Governance/      ← Insights de gobernanza
│   ├── Metrics/         ← Métricas de uso
│   ├── Vault/           ← Entidades de vault
│   ├── Extractor/       ← Config de extractores
│   ├── Classifier/      ← Config de clasificadores
│   ├── FinancialExtraction/ ← Extracción financiera
│   └── Translator/      ← Traducción
└── Enums/               ← Todos los enums del sistema
```

---

## 3. REGLAS C.O.R.E. (IRROMPIBLES)

### Controlador: una línea

```php
public function handle(SomeHubWebhookDTO $dto, ProcessAction $action): ResponseDTO
{
    return $action->execute($dto);
}
```

- DTO inyectado directamente — Spatie valida, HTTP 422 automático si falla.
- Action inyectada por el container.
- Retorno de DTO (`Responsable`) — nunca `response()->json()`.

### Colecciones: arrays nativos tipados via DocBlock

```php
// CORRECTO
/** @var array<int, AgentSummaryData>|null */
public readonly ?array $agents = null;

// PROHIBIDO — Spatie Data v4 no usa DataCollectionOf en este paquete
#[DataCollectionOf(AgentSummaryData::class)]
public readonly ?DataCollection $agents = null;
```

### Actions son agnósticas al HTTP

Solo reciben DTOs o primitivos. Nunca usan `request()`, `response()`, `redirect()`. Si algo falla, lanzan excepciones de dominio. El handler de excepciones de Laravel traduce a HTTP.

### Firma HMAC de webhooks Hub→Spoke

Header: `X-Sunnyface-Signature` (HMAC-SHA256 con `hash_equals()`).

---

## 4. PROTOCOLO PARA CAMBIOS EN EL PAQUETE

Si el trabajo requiere un DTO nuevo, campo adicional, o enum nuevo:

1. **Detente.**
2. Describe exactamente qué necesitas y por qué.
3. Reporta a Kiko — él hace el cambio y publica la versión.
4. Ejecutas `composer update sunnyface/ai-contracts` y continúas.

**No improvises contratos.** Un DTO incorrecto rompe Hub y todos los Spokes.

---

## 5. SKILL COMPLEMENTARIO

Para anti-patrones detectados, async, Livewire + Spatie Data, y `HubCommunicationService`:

```text
/perfect-agent-guide
```
