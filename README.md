# ☀️ Sunnyface AI Contracts

> **El puente telepático de tipado estricto entre el Hub y el Spoke.**

Este paquete proporciona la librería central de **Data Transfer Objects (DTOs)** y contratos compartidos para el ecosistema de IA de Sunnyface. Diseñado para sincronizar las mentes de los equipos de desarrollo más exigentes del planeta, asegurando que la comunicación en sistemas distribuidos sea impecable, robusta y libre de alucinaciones.

---

## 🚀 ¿Por qué este paquete brilla? ✨

Olvídate de los arrays asociativos crudos y de jugar a las adivinanzas. Gracias al poder de PHP 8.4 y `spatie/laravel-data` v4, este paquete ofrece:

1. **Cero validación manual en el controlador**: Cuando inyectes DTOs como `ExecuteAgentTaskRequest` en tu controlador, propiedades complejas como `$request->payload` ya serán instancias perfectas de `ConversationalPayloadDTO`, `VisionExtractorPayloadDTO` o `DocumentClassifierPayloadDTO`. ¡La librería hace el trabajo sucio por ti!
2. **Tipado estricto (Union Types)**: PHPStan y tu IDE ahora saben exactamente qué métodos y propiedades están disponibles. Se acabó el rezar para que `$payload['message'] ?? null` exista.
3. **Colecciones automáticas**: Propiedades como `$prefetched_chat_messages` se hidratan automáticamente en un array de objetos reales (ej. `ChatMessageDTO`), en lugar de dejarte con arrays anidados genéricos.

¡Es un contrato blindado y digno de presumir! 😎

---

## 📦 Instalación

Puedes instalar este paquete vía Composer en cualquier servicio satélite (Spoke) o en el Hub central:

```bash
composer require sunnyface/ai-contracts:dev-main --with-all-dependencies
```

*(Asegúrate de tener configurado el acceso al repositorio si es privado).*

---

## 💻 Uso Real (Nada de `ExampleDTO` inventados)

Aquí tienes un ejemplo de cómo se ve la magia en un controlador de tu aplicación Laravel:

```php
<?php

namespace App\Http\Controllers;

use Sunnyface\Contracts\Data\Spoke\ExecuteAgentTaskRequest;
use Sunnyface\Contracts\Data\Spoke\Payloads\ConversationalPayloadDTO;

class AgentTaskController extends Controller
{
    public function __invoke(ExecuteAgentTaskRequest $request)
    {
        // 1. $request->tenant_id ya está validado como ULID.
        
        // 2. Gracias a los Union Types, puedes hacer match directo sobre el payload:
        match (true) {
            $request->payload instanceof ConversationalPayloadDTO => $this->handleChat($request->payload),
            // ... otros payloads tipados
        };

        // 3. Las colecciones ya son objetos reales:
        foreach ($request->prefetched_chat_messages ?? [] as $message) {
            // $message es un ChatMessageDTO con autocompletado perfecto
            echo $message->role->value . ': ' . $message->content;
        }
    }
}
```

---

## 🛠 Arquitectura y Estructura

El paquete está organizado lógicamente para reflejar el dominio del sistema:

- `src/Data/Agent/`: Configuración específica de los diferentes tipos de agentes (Talker, Extractor, etc.).
- `src/Data/Network/`: Envelopes y webhooks que cruzan la frontera de red (Hub ↔ Spoke).
- `src/Data/Spoke/`: Payloads y respuestas específicas para la API pública de los satélites.
- `src/Enums/`: Enumeraciones compartidas (`TaskStatus`, `MessageRole`, `HandlerSlug`, etc.) para evitar *magic strings*.

---

## 📜 Licencia

Este proyecto es software propietario de Sunnyface. Todos los derechos reservados.

---

<div align="center">
  <i>Diseñado con ❤️, tensores al rojo vivo y cero alucinaciones por tu Genio de cabecera.</i><br>
  <b>Que el tipado estricto os acompañe en el mundo físico y eléctrico para toda la eternidad. ⚡🤖</b>
</div>
