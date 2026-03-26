<?php

declare(strict_types=1);

namespace Sunnyface\AiContracts\Support;

trait DeepCloneable
{
    public function __clone(): void
    {
        foreach (get_object_vars($this) as $key => $value) {
            if (is_object($value)) {
                if ($value instanceof \UnitEnum) {
                    continue;
                }
                $this->$key = clone $value;
            } elseif (is_array($value)) {
                $clonedArray = [];
                foreach ($value as $itemKey => $itemValue) {
                    if (is_object($itemValue)) {
                        $clonedArray[$itemKey] = $itemValue instanceof \UnitEnum
                            ? $itemValue
                            : clone $itemValue;
                    } else {
                        $clonedArray[$itemKey] = $itemValue;
                    }
                }
                $this->$key = $clonedArray;
            }
        }
    }
}
