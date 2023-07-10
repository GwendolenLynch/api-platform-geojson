<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\Assert;
use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;

#[ApiComponent(
    description: <<<'TAG'
        Coordinates are array of Polygon coordinate arrays. e.g.:
        ```
        {
            "type": "MultiPolygon",
            "coordinates": [
                [
                    [
                        [102.0, 2.0],
                        [103.0, 2.0],
                        [103.0, 3.0],
                        [102.0, 3.0],
                        [102.0, 2.0]
                    ]
                ],
                [
                    [
                        [100.0, 0.0],
                        [101.0, 0.0],
                        [101.0, 1.0],
                        [100.0, 1.0],
                        [100.0, 0.0]
                    ],
                    [
                        [100.2, 0.2],
                        [100.2, 0.8],
                        [100.8, 0.8],
                        [100.8, 0.2],
                        [100.2, 0.2]
                    ]
                ]
            ]
        }
        ```
        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'default' => 'MultiPolygon',
            'example' => 'MultiPolygon',
            'readOnly' => true,
        ],
        'coordinates' => [
            'type' => 'array',
            'items' => [
                'type' => 'array',
                'items' => [
                    'type' => 'array',
                    'items' => [
                        '$ref' => Coordinates::class,
                    ],
                    'minItems' => 2,
                ],
            ],
            'minItems' => 2,
        ],
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.7',
    ],
)]
final class MultiPolygon implements Position
{
    use PositionTrait;

    public const TYPE = 'MultiPolygon';

    public function __construct(array $coordinates, ?BoundingBox $bbox = null)
    {
        Assert::assertCoordinatesArrayArrayArray($coordinates);

        $this->bbox = $bbox;
        $this->coordinates = $coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        Assert::assertCoordinatesArrayArrayArray($coordinates);

        $this->coordinates = $coordinates;

        return $this;
    }
}
