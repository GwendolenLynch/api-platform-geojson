<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Type;

use Camelot\GeoJSON\BoundingBox;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

final class BoundingBoxType extends JsonType
{
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return BoundingBox::fromJson(parent::convertToPHPValue($value, $platform));
    }
}
