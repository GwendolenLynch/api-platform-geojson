<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\Assert;
use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;

#[ApiComponent(
    description: <<<'TAG'
        The "coordinates" member is an array of LineString coordinate arrays. e.g.:
        ```
        {
            "type": "MultiLineString",
            "coordinates": [
                [
                    [0.000, 0.000, 0.0],
                    [0.000, 0.000, 0.0]
                ],
                [
                    [0.000, 0.000, 0.0],
                    [0.000, 0.000, 0.0]
                ]
            ]
        }
        ```
        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'default' => 'MultiLineString',
            'example' => 'MultiLineString',
            'readOnly' => true,
        ],
        'coordinates' => [
            'type' => 'array',
            'items' => [
                'type' => 'array',
                'items' => [
                    '$ref' => Coordinates::class,
                ],
                'minItems' => 2,
            ],
        ],
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.5',
    ],
)]
final class MultiLineString implements Position
{
    use PositionTrait;

    public const TYPE = 'MultiLineString';

    public function __construct(array $coordinates, ?BoundingBox $bbox = null)
    {
        Assert::assertCoordinatesArrayArray($coordinates);

        $this->bbox = $bbox;
        $this->coordinates = $coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        Assert::assertCoordinatesArrayArray($coordinates);

        $this->coordinates = $coordinates;

        return $this;
    }
}
