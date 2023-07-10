<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\Assert;
use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;

#[ApiComponent(
    description: <<<'TAG'
        The "coordinates" member is an array of positions. e.g.:
        ```
        {
            "type": "MultiPoint",
            "coordinates": [
                [0.000, 0.000, 0.0],
                [0.000, 0.000, 0.0]
            ]
        }
        ```
        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'default' => 'MultiPoint',
            'example' => 'MultiPoint',
            'readOnly' => true,
        ],
        'coordinates' => [
            'type' => 'array',
            'items' => [
                '$ref' => Coordinates::class,
            ],
        ],
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.3',
    ],
)]
final class MultiPoint implements Position
{
    use PositionTrait;

    public const TYPE = 'MultiPoint';

    public function __construct(array $coordinates, ?BoundingBox $bbox = null)
    {
        Assert::assertCoordinatesArray($coordinates);

        $this->bbox = $bbox;
        $this->coordinates = $coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        Assert::assertCoordinatesArray($coordinates);

        $this->coordinates = $coordinates;

        return $this;
    }
}
