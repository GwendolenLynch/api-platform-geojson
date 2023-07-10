<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\Geometry\LineString;
use Camelot\GeoJSON\Geometry\MultiLineString;
use Camelot\GeoJSON\Geometry\MultiPoint;
use Camelot\GeoJSON\Geometry\MultiPolygon;
use Camelot\GeoJSON\Geometry\Point;
use Camelot\GeoJSON\Geometry\Polygon;

final class Factory
{
    public static function fromJson(null|array|string $json): Geometry
    {
        if (\is_string($json)) {
            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        return match ($json['type'] ?? null) {
            'Feature' => Feature\Feature::fromGeoJSON($json),
            'FeatureCollection' => Feature\FeatureCollection::fromGeoJSON($json),
            'GeometryCollection' => GeometryCollection::fromGeoJSON($json),
            'LineString' => LineString::fromGeoJSON($json),
            'MultiLineString' => MultiLineString::fromGeoJSON($json),
            'MultiPoint' => MultiPoint::fromGeoJSON($json),
            'MultiPolygon' => MultiPolygon::fromGeoJSON($json),
            'Point' => Point::fromGeoJSON($json),
            'Polygon' => Polygon::fromGeoJSON($json),

            default => throw new \RuntimeException(sprintf('Unknown type: "%s"', $json['type'] ?? 'Not given'))
        };
    }
}
