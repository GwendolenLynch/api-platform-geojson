<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Resource;

final class Merge
{
    public static function schemas(array|\ArrayObject $parent, array|\ArrayObject $child): array
    {
        $merged = \is_array($parent) ? $parent : $parent->getArrayCopy();
        foreach ($child as $property => $value) {
            if ($value === null) {
                continue;
            }

            if (!is_iterable($value)) {
                $merged[$property] = $value;

                continue;
            }

            if (($parent[$property] ?? null) === null) {
                $merged[$property] = $value;

                continue;
            }

            $merge = array_merge($parent[$property], $value);
            $merged[$property] = array_is_list($merge) ? array_values(array_unique($merge)) : $merge;
        }

        return $merged;
    }
}
