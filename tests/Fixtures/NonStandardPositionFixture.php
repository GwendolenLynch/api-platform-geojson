<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Fixtures;

use ApiPlatform\Metadata\ApiProperty;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\Position;

/** @internal */
final class NonStandardPositionFixture implements Position
{
    #[ApiProperty(required: true)]
    public function getType(): string
    {
        return 'Fountain';
    }

    #[ApiProperty()]
    public function getBbox(): ?BoundingBox
    {
        return null;
    }

    #[ApiProperty(required: true)]
    public function getCoordinates(): array|Coordinates
    {
        return [];
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => 'Fountain',
            'coordinates' => [],
        ];
    }
}
