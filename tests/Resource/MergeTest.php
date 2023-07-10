<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Resource;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\GeoJson;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\Resource\Merge;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversClass(Merge::class)]
final class MergeTest extends TestCase
{
    public static function provideMergeSchemas(): iterable
    {
        $geoJson = self::getAttribute(GeoJson::class);
        $geometry = self::getAttribute(Geometry::class);
        $position = self::getAttribute(Geometry\Position::class);
        $polygon = self::getAttribute(Geometry\Polygon::class);

        yield 'Geometry extends GeoJSON' => [
            [$geoJson, $geometry],
            [
                'description' => <<<'TAG'
                    A Geometry object represents points, curves, and surfaces in coordinate space.

                    Every Geometry object is a GeoJSON object no matter where it occurs in a GeoJSON text.

                    -  The value of a Geometry object's "type" member MUST be one of the seven geometry types (see Section 1.4)
                    -  A GeoJSON Geometry object of any type other than "GeometryCollection" has a member with the name "coordinates"
                       - The value of the "coordinates" member is an array
                       - The structure of the elements in this array is determined by the type of geometry
                       - GeoJSON processors MAY interpret Geometry objects with empty "coordinates" arrays as null objects

                    TAG,
                'deprecated' => false,
                'properties' => [
                    'type' => [
                        'type' => 'string',
                        'enum' => [
                            'Feature',
                            'FeatureCollection',
                            'Point',
                            'MultiPoint',
                            'LineString',
                            'MultiLineString',
                            'Polygon',
                            'MultiPolygon',
                            'GeometryCollection',
                        ],
                        'readOnly' => true,
                    ],
                    'bbox' => [
                        'oneOf' => [
                            ['$ref' => BoundingBox::class],
                            ['type' => 'null'],
                        ],
                    ],
                ],
                'required' => [
                    'type',
                ],
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1',
                ],
            ],
        ];
        yield 'Position extends Geometry' => [
            [$geoJson, $geometry, $position],
            [
                'description' => <<<'TAG'
                    A position is the fundamental geometry construct.

                    The "coordinates" member of a Geometry object is composed of either:
                     -  one position in the case of a Point geometry
                     -  an array of positions in the case of a LineString or MultiPoint geometry
                     -  an array of LineString or linear ring (see Section 3.1.6) coordinates in the case of a Polygon or MultiLineString geometry, or
                     -  an array of Polygon coordinates in the case of a MultiPolygon geometry

                    A position is an array of numbers:
                     - There MUST be two or more elements
                     - The first two elements are longitude and latitude, or easting and northing, precisely in that order and using decimal numbers
                     - Altitude or elevation MAY be included as an optional third element

                    TAG,
                'deprecated' => false,
                'properties' => [
                    'type' => [
                        'type' => 'string',
                        'enum' => [
                            'Point',
                            'MultiPoint',
                            'LineString',
                            'MultiLineString',
                            'Polygon',
                            'MultiPolygon',
                        ],
                        'readOnly' => true,
                    ],
                    'bbox' => [
                        'oneOf' => [
                            ['$ref' => BoundingBox::class],
                            ['type' => 'null'],
                        ],
                    ],
                    'coordinates' => [
                        'type' => 'array',
                        'items' => [
                            'oneOf' => [
                                // Point
                                ['$ref' => Coordinates::class],

                                // MultiPoint
                                // LineString
                                [
                                    'type' => 'array',
                                    'items' => [
                                        '$ref' => Coordinates::class,
                                    ],
                                    'minItems' => 2,
                                ],

                                // Polygon or MultiLineString
                                [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'array',
                                        'items' => [
                                            '$ref' => Coordinates::class,
                                        ],
                                        'minItems' => 2,
                                    ],
                                    'minItems' => 2,
                                ],

                                // MultiPolygon
                                [
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
                                        'minItems' => 2,
                                    ],
                                    'minItems' => 2,
                                ],
                            ],
                        ],
                    ],
                ],
                'required' => [
                    'type',
                    'coordinates',
                ],
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.1',
                ],
            ],
        ];
        yield 'Polygon implements Position' => [
            [$geoJson, $geometry, $position, $polygon],
            [
                'description' => <<<'TAG'
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
                'deprecated' => false,
                'properties' => [
                    'type' => [
                        'type' => 'string',
                        'default' => 'Polygon',
                        'example' => 'Polygon',
                        'readOnly' => true,
                    ],
                    'bbox' => [
                        'oneOf' => [
                            ['$ref' => BoundingBox::class],
                            ['type' => 'null'],
                        ],
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
                'required' => [
                    'type',
                    'coordinates',
                ],
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.6',
                ],
            ],
        ];
    }

    #[DataProvider('provideMergeSchemas')]
    public function testMergeSchemas(array $hierarchy, iterable $expected): void
    {
        $result = [];
        foreach ($hierarchy as $item) {
            $result = Merge::schemas($result, $item->toArray());
        }
        self::assertSame($expected, $result);
    }

    public function testSkipsNulls(): void
    {
        $result = Merge::schemas(['type' => 'object'], ['deprecated' => null, 'description' => '']);
        self::assertEqualsCanonicalizing(['type' => 'object', 'description' => ''], $result);
    }

    private static function getAttribute(string $className): ApiComponent
    {
        $rc = new \ReflectionClass($className);
        $attributes = $rc->getAttributes(ApiComponent::class);
        if (!$attributes) {
            throw new \RuntimeException('ApiComponent attribute not found on ' . $className);
        }

        return $attributes[0]->newInstance();
    }
}
