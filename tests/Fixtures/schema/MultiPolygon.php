<?php

declare(strict_types=1);

return [
    '$ref' => '#/components/schemas/MultiPolygon',
    'components' => [
        'schemas' => [
            'MultiPolygon' => [
                'description' => 'Coordinates are array of Polygon coordinate arrays. e.g.:
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
```',
                'deprecated' => false,
                'properties' => [
                    'type' => [
                        'type' => 'string',
                        'default' => 'MultiPolygon',
                        'example' => 'MultiPolygon',
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
                            'type' => 'array',
                            'items' => [
                                'type' => 'array',
                                'items' => [
                                    '$ref' => '#/components/schemas/Coordinates',
                                ],
                                'minItems' => 2,
                            ],
                        ],
                        'minItems' => 2,
                    ],
                ],
                'required' => [
                    'type',
                    'coordinates',
                ],
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.7',
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
