<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\Assert;
use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;

#[ApiComponent(
    description: <<<'TAG'
        Coordinates are array of linear ring coordinate arrays.

        -  A linear ring is a closed LineString with four or more positions.
        -  The first and last positions are equivalent, and they MUST contain identical values; their representation SHOULD also be identical.
        -  A linear ring is the boundary of a surface or the boundary of a hole in a surface.
        -  A linear ring MUST follow the right-hand rule with respect to the area it bounds, i.e., exterior rings are counterclockwise, and holes are clockwise.

        Though a linear ring is not explicitly represented as a GeoJSON geometry type, it leads to a canonical formulation of the Polygon geometry type definition as follows:
        -  For type "Polygon", the "coordinates" member MUST be an array of linear ring coordinate arrays.
        -  For Polygons with more than one of these rings, the first MUST be the exterior ring, and any others MUST be interior rings.  The exterior ring bounds the surface, and the interior rings (if present) bound holes within the surface.

        e.g. No holes:
        ```
        {
            "type": "Polygon",
            "coordinates": [
                [
                    [100.0, 0.0],
                    [101.0, 0.0],
                    [101.0, 1.0],
                    [100.0, 1.0],
                    [100.0, 0.0]
                ]
            ]
        }
        ```

        e.g.: With holes:
        ```
        {
            "type": "Polygon",
            "coordinates": [
                [
                    [100.0, 0.0],
                    [101.0, 0.0],
                    [101.0, 1.0],
                    [100.0, 1.0],
                    [100.0, 0.0]
                ],
                [
                    [100.8, 0.8],
                    [100.8, 0.2],
                    [100.2, 0.2],
                    [100.2, 0.8],
                    [100.8, 0.8]
                ]
            ]
        }
        ```
        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'default' => 'Polygon',
            'example' => 'Polygon',
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
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.6',
    ],
)]
final class Polygon implements Position
{
    use PositionTrait;

    public const TYPE = 'Polygon';

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
