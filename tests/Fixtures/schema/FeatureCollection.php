<?php

declare(strict_types=1);

return [
    '$ref' => '#/components/schemas/FeatureCollection',
    'components' => [
        'schemas' => [
            'FeatureCollection' => [
                'description' => 'GeoJSON \'FeatureCollection\' object.

A FeatureCollection object has a member with the name "features".

The value of "features" is a JSON array.

Each element of the array is a Feature object.

It is possible for this array to be empty.
',
                'deprecated' => false,
                'properties' => [
                    'type' => [
                        'type' => 'string',
                        'enum' => [
                            'FeatureCollection',
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
                    'features' => [
                        'anyOf' => [
                            [
                                'type' => 'array',
                                'items' => [
                                    '$ref' => '#/components/schemas/Feature',
                                ],
                            ],
                            [
                                'type' => 'null',
                            ],
                        ],
                    ],
                ],
                'required' => [
                    'type',
                    'features',
                ],
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-3.3',
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
            'Feature' => [
                'description' => 'A Feature object represents a spatially bounded thing.  Every Feature
object is a GeoJSON object no matter where it occurs in a GeoJSON
text.

- A Feature object has a "type" member with the value "Feature".
- A Feature object has a member with the name "geometry".  The value
  of the geometry member SHALL be either a Geometry object as defined
  above or, in the case that the Feature is unlocated, a JSON null value.
- A Feature object has a member with the name "properties".  The
  value of the properties member is an object (any JSON object or a
  JSON null value).
- If a Feature has a commonly used identifier, that identifier
  SHOULD be included as a member of the Feature object with the name
  "id", and the value of this member is either a JSON string or number.
',
                'deprecated' => false,
                'properties' => [
                    'type' => [
                        'type' => 'string',
                        'enum' => [
                            'Feature',
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
                    'geometry' => [
                        'anyOf' => [
                            [
                                '$ref' => '#/components/schemas/Feature',
                            ],
                            [
                                '$ref' => '#/components/schemas/FeatureCollection',
                            ],
                            [
                                '$ref' => '#/components/schemas/Point',
                            ],
                            [
                                '$ref' => '#/components/schemas/MultiPoint',
                            ],
                            [
                                '$ref' => '#/components/schemas/LineString',
                            ],
                            [
                                '$ref' => '#/components/schemas/MultiLineString',
                            ],
                            [
                                '$ref' => '#/components/schemas/Polygon',
                            ],
                            [
                                '$ref' => '#/components/schemas/MultiPolygon',
                            ],
                            [
                                '$ref' => '#/components/schemas/GeometryCollection',
                            ],
                            [
                                'type' => 'null',
                            ],
                        ],
                    ],
                    'properties' => [
                        'type' => 'object',
                        'additionalProperties' => true,
                        'description' => 'A JSON object.',
                        'example' => '
            {
              "foo": "bar",
              "baz": false,
            }
            ',
                    ],
                ],
                'required' => [
                    'type',
                    'geometry',
                ],
                'externalDocs' => [
                    'url' => 'https://tools.ietf.org/html/rfc7946#section-3.2',
                ],
            ],
            'Geometry' => [
                'description' => 'A Geometry object represents points, curves, and surfaces in coordinate space.

Every Geometry object is a GeoJSON object no matter where it occurs in a GeoJSON text.

-  The value of a Geometry object\'s "type" member MUST be one of the seven geometry types (see Section 1.4)
-  A GeoJSON Geometry object of any type other than "GeometryCollection" has a member with the name "coordinates"
   - The value of the "coordinates" member is an array
   - The structure of the elements in this array is determined by the type of geometry
   - GeoJSON processors MAY interpret Geometry objects with empty "coordinates" arrays as null objects
',
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
                            [
                                '$ref' => '#/components/schemas/BoundingBox',
                            ],
                            [
                                'type' => 'null',
                            ],
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
        ],
    ],
];
