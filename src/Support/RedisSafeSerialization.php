<?php

declare(strict_types=1);

namespace Sunnyface\AiContracts\Support;

/**
 * Convierte objetos a arrays puros vía JSON para evitar Eloquent, Closures u otros
 * no serializables en colas / Redis.
 */
final class RedisSafeSerialization
{
    public static function sanitize(mixed $value): mixed
    {
        if (is_object($value)) {
            $json = json_encode($value);

            return $json === false ? null : json_decode($json, true);
        }

        if (is_array($value)) {
            $out = [];
            foreach ($value as $k => $v) {
                $out[$k] = self::sanitize($v);
            }

            return $out;
        }

        return $value;
    }
}
