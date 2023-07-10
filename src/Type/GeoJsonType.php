<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Type;

use Camelot\GeoJSON\Factory;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

final class GeoJsonType extends JsonType
{
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return Factory::fromJson(parent::convertToPHPValue($value, $platform));
    }
}
