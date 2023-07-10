<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\Attribute\ApiComponent;

#[ApiComponent(
    description: <<<'TAG'
        A Geometry object represents points, curves, and surfaces in coordinate space.

        Every Geometry object is a GeoJSON object no matter where it occurs in a GeoJSON text.

        -  The value of a Geometry object's "type" member MUST be one of the seven geometry types (see Section 1.4)
        -  A GeoJSON Geometry object of any type other than "GeometryCollection" has a member with the name "coordinates"
           - The value of the "coordinates" member is an array
           - The structure of the elements in this array is determined by the type of geometry
           - GeoJSON processors MAY interpret Geometry objects with empty "coordinates" arrays as null objects

        TAG,
    properties: [
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
    required: [
        'type',
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1',
    ],
)]
interface Geometry extends GeoJson, \JsonSerializable
{
    public function getBbox(): ?BoundingBox;
}
