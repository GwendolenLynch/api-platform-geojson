<?php

declare(strict_types=1);

return [
    '$ref' => '#/components/schemas/Position',
    'components' => [
        'schemas' => [
            'Position' => [
                'description' => 'A position is the fundamental geometry construct.

The "coordinates" member of a Geometry object is composed of either:
 -  one position in the case of a Point geometry
 -  an array of positions in the case of a LineString or MultiPoint geometry
 -  an array of LineString or linear ring (see Section 3.1.6) coordinates in the case of a Polygon or MultiLineString geometry, or
 -  an array of Polygon coordinates in the case of a MultiPolygon geometry

A position is an array of numbers:
 - There MUST be two or more elements
 - The first two elements are longitude and latitude, or easting and northing, precisely in that order and using decimal numbers
 - Altitude or elevation MAY be included as an optional third element
',
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
                            [
                                '$ref' => '#/components/schemas/BoundingBox',
                            ],
                            [
                                'type' => 'null',
                            ],
                        ],
                    ],
                    'coordinates' => [
                        'type' => 'array',
                        'items' => [
                            'oneOf' => [
                                [
                                    '$ref' => '#/components/schemas/Coordinates',
                                ],
                                [
                                    'type' => 'array',
                                    'items' => [
                                        '$ref' => '#/components/schemas/Coordinates',
                                    ],
                                    'minItems' => 2,
                                ],
                                [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'array',
                                        'items' => [
                                            '$ref' => '#/components/schemas/Coordinates',
                                        ],
                                        'minItems' => 2,
                                    ],
                                    'minItems' => 2,
                                ],
                                [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'array',
                                            'items' => [
                                                '$ref' => '#/components/schemas/Coordinates',
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
            'BoundingBox' => [
                'type' => 'array',
                'description' => 'A GeoJSON object MAY have a member named "bbox" to include information on the coordinate range for its Geometries, Features, or FeatureCollections.

The value of the bbox member MUST be an array of length 2*n where n is the number of dimensions represented in the contained geometries, with all axes of the most southwesterly point followed by all axes of the more northeasterly point.

The axes order of a bbox follows the axes order of geometries.
',
                'deprecated' => false,
                'items' => [
                    'type' => 'number',
                    'format' => 'float',
                ],
                'minItems' => 4,
                'maxItems' => 6,
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-5',
                ],
                'example' => [
                    100.1,
                    101.2,
                    102.3,
                    103.4,
                ],
            ],
            'Coordinates' => [
                'type' => 'array',
                'description' => 'Array of coordinates in the format [longitude, latitude, elevation]',
                'deprecated' => false,
                'items' => [
                    'type' => 'number',
                    'format' => 'float',
                ],
                'minItems' => 2,
                'maxItems' => 3,
                'example' => [
                    100.1,
                    1.2,
                ],
            ],
        ],
    ],
];
