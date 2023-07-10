<?php

declare(strict_types=1);

return [
    '$schema' => 'http://json-schema.org/draft-07/schema#',
    'definitions' => [
        'GeoJson' => [
            '$ref' => '#/components/schemas/GeoJson',
            'components' => [
                'schemas' => [
                    'GeoJson' => [
                        'description' => 'A GeoJSON object represents a Geometry, Feature, or collection of Features:
  -  A GeoJSON object is a JSON object.
  -  A GeoJSON object has a member with the name "type".  The value of the member MUST be one of the GeoJSON types.
  -  A GeoJSON object MAY have a "bbox" member, the value of which MUST be a bounding box array (see Section 5).
  -  A GeoJSON object MAY have other members (see Section 6).
',
                        'deprecated' => false,
                        'properties' => [
                            'type' => [
                                'type' => 'string',
                                'enum' => [
                                    'Feature',
                                    'FeatureCollection',
                                ],
                                'readOnly' => true,
                            ],
                        ],
                        'required' => [
                            'type',
                        ],
                        'externalDocs' => [
                            'url' => 'https://tools.ietf.org/html/rfc7946#section-3',
                        ],
                    ],
                ],
            ],
        ],
        'Geometry' => [
            '$ref' => '#/components/schemas/Geometry',
            'components' => [
                'schemas' => [
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
        ],
        'Position' => [
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
        ],
        'Coordinates' => [
            '$ref' => '#/components/schemas/Coordinates',
            'components' => [
                'schemas' => [
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
        ],
        'Point' => [
            '$ref' => '#/components/schemas/Point',
            'components' => [
                'schemas' => [
                    'Point' => [
                        'description' => 'The "coordinates" member is a single position.

e.g.:
```
{
    "type": "Point",
    "coordinates": [0.000, 0.000, 0.0]
}
```',
                        'deprecated' => false,
                        'properties' => [
                            'type' => [
                                'type' => 'string',
                                'default' => 'Point',
                                'example' => 'Point',
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
                                '$ref' => '#/components/schemas/Coordinates',
                            ],
                        ],
                        'required' => [
                            'type',
                            'coordinates',
                        ],
                        'externalDocs' => [
                            'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.2',
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
                ],
            ],
        ],
        'BoundingBox' => [
            '$ref' => '#/components/schemas/BoundingBox',
            'components' => [
                'schemas' => [
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
        ],
        'LineString' => [
            '$ref' => '#/components/schemas/LineString',
            'components' => [
                'schemas' => [
                    'LineString' => [
                        'description' => 'The "coordinates" member is an array of two or more positions.

e.g.:
```
{
    "type": "LineString",
    "coordinates": [
        [0.000, 0.000, 0.0],
        [0.000, 0.000, 0.0]
    ]
}
```',
                        'deprecated' => false,
                        'properties' => [
                            'type' => [
                                'type' => 'string',
                                'default' => 'LineString',
                                'example' => 'LineString',
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
                                    '$ref' => '#/components/schemas/Coordinates',
                                ],
                                'minItems' => 2,
                            ],
                        ],
                        'required' => [
                            'type',
                            'coordinates',
                        ],
                        'externalDocs' => [
                            'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.4',
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
        ],
        'Polygon' => [
            '$ref' => '#/components/schemas/Polygon',
            'components' => [
                'schemas' => [
                    'Polygon' => [
                        'description' => 'Coordinates are array of linear ring coordinate arrays.

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
```',
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
                                        '$ref' => '#/components/schemas/Coordinates',
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
        ],
        'MultiLineString' => [
            '$ref' => '#/components/schemas/MultiLineString',
            'components' => [
                'schemas' => [
                    'MultiLineString' => [
                        'description' => 'The "coordinates" member is an array of LineString coordinate arrays. e.g.:
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
```',
                        'deprecated' => false,
                        'properties' => [
                            'type' => [
                                'type' => 'string',
                                'default' => 'MultiLineString',
                                'example' => 'MultiLineString',
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
                                        '$ref' => '#/components/schemas/Coordinates',
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
                            'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.5',
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
        ],
        'MultiPoint' => [
            '$ref' => '#/components/schemas/MultiPoint',
            'components' => [
                'schemas' => [
                    'MultiPoint' => [
                        'description' => 'The "coordinates" member is an array of positions. e.g.:
```
{
    "type": "MultiPoint",
    "coordinates": [
        [0.000, 0.000, 0.0],
        [0.000, 0.000, 0.0]
    ]
}
```',
                        'deprecated' => false,
                        'properties' => [
                            'type' => [
                                'type' => 'string',
                                'default' => 'MultiPoint',
                                'example' => 'MultiPoint',
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
                                    '$ref' => '#/components/schemas/Coordinates',
                                ],
                            ],
                        ],
                        'required' => [
                            'type',
                            'coordinates',
                        ],
                        'externalDocs' => [
                            'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.3',
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
        ],
        'MultiPolygon' => [
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
        ],
        'Feature' => [
            '$ref' => '#/components/schemas/Feature',
            'components' => [
                'schemas' => [
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
        ],
        'FeatureCollection' => [
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
        ],
        'GeometryCollection' => [
            '$ref' => '#/components/schemas/GeometryCollection',
            'components' => [
                'schemas' => [
                    'GeometryCollection' => [
                        'description' => 'GeometryCollection "geometries" array of Geometry objects.

e.g.:
```
{
    "type": "GeometryCollection",
    "geometries": [
        {
            "type": "Point",
            "coordinates": [100.0, 0.0]
        },
        {
            "type": "LineString",
            "coordinates": [
                [101.0, 0.0],
                [102.0, 1.0]
            ]
        }
    ]
}
```',
                        'deprecated' => false,
                        'properties' => [
                            'type' => [
                                'type' => 'string',
                                'enum' => [
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
                            'geometries' => [
                                'type' => 'array',
                                'items' => [
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
                                    ],
                                ],
                            ],
                        ],
                        'required' => [
                            'type',
                            'geometries',
                        ],
                        'externalDocs' => [
                            'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.8',
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
        ],
    ],
];
