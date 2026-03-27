<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Data\Network;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

/**
 * Patrón Envelope para webhooks unificados Hub → Spoke.
 *
 * Separa el enrutamiento (X-Sunnyface-Event header) de los datos (body).
 * Permite un único endpoint polimórfico por satélite que enruta
 * internamente según el evento recibido.
 *
 * @see \Sunnyface\Contracts\Enums\WebhookEvent
 */
final class HubWebhookEnvelopeDTO extends Data
{
    public function __construct(
        public readonly string $event = '',
        /** @var array<string, mixed> */
        public readonly array $payload = [],
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            event: (string) $request->header('X-Sunnyface-Event', ''),
            payload: $request->all(),
        );
    }
}
