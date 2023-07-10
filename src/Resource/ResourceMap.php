<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Resource;

use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Feature\Feature;
use Camelot\GeoJSON\Feature\FeatureCollection;
use Camelot\GeoJSON\GeoJson;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\GeometryCollection;

final class ResourceMap
{
    // In order of hierarchical dependence
    public const RESOURCES = [
        // Interfaces
        'GeoJson' => GeoJson::class,
        'Geometry' => Geometry::class,
        'Position' => Geometry\Position::class,

        // Geometry
        'Coordinates' => Coordinates::class,
        'Point' => Geometry\Point::class,
        'BoundingBox' => BoundingBox::class,
        'LineString' => Geometry\LineString::class,
        'Polygon' => Geometry\Polygon::class,
        'MultiLineString' => Geometry\MultiLineString::class,
        'MultiPoint' => Geometry\MultiPoint::class,
        'MultiPolygon' => Geometry\MultiPolygon::class,

        // GeoJSON
        'Feature' => Feature::class,
        'FeatureCollection' => FeatureCollection::class,
        'GeometryCollection' => GeometryCollection::class,
    ];
}
