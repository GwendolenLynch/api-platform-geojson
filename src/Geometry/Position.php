<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry;

#[ApiComponent(
    description: <<<'TAG'
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
    properties: [
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
        'coordinates' => [
            'type' => 'array',
            'items' => [
                'oneOf' => [
                    // Point
                    [
                        '$ref' => Coordinates::class,
                    ],

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
    required: [
        'type',
        'coordinates',
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.1',
    ],
)]
interface Position extends Geometry
{
    /** @return Coordinates|Coordinates[]|Coordinates[][]|Coordinates[][][] */
    public function getCoordinates(): array|Coordinates;
}
