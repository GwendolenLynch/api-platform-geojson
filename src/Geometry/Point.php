<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;

#[ApiComponent(
    description: <<<'TAG'
        The "coordinates" member is a single position.

        e.g.:
        ```
        {
            "type": "Point",
            "coordinates": [0.000, 0.000, 0.0]
        }
        ```
        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'default' => 'Point',
            'example' => 'Point',
            'readOnly' => true,
        ],
        'coordinates' => [
            'type' => 'array',
            '$ref' => Coordinates::class,
        ],
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.2',
    ],
)]
final class Point implements Position
{
    use PositionTrait;

    public const TYPE = 'Point';

    public function __construct(Coordinates $coordinates, ?BoundingBox $bbox = null)
    {
        $this->coordinates = $coordinates;
        $this->bbox = $bbox;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(Coordinates $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }
}
