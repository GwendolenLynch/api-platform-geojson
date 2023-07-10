<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Type;

use Camelot\GeoJSON\Coordinates;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

final class CoordinatesType extends JsonType
{
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return Coordinates::fromJson(parent::convertToPHPValue($value, $platform));
    }
}
