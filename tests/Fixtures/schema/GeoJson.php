<?php

declare(strict_types=1);

return [
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
];
