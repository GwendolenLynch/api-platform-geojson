<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Geometry;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\Polygon;
use Camelot\GeoJSON\Geometry\PositionTrait;
use Camelot\GeoJSON\GeometryTrait;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(Polygon::class)]
#[CoversClass(GeometryTrait::class)]
#[CoversClass(PositionTrait::class)]
final class PolygonTest extends PositionTestCase
{
    public static function providerType(): iterable
    {
        yield ['Polygon', Fixtures::readJSON('geometry/Polygon-no-holes.json')];
    }

    public static function providerCoordinates(): iterable
    {
        yield [Fixtures::readJSON('geometry/Polygon-no-holes.json'), [[new Coordinates(0.42, 42.777, 0.525)]]];
    }

    public static function providerJson(): iterable
    {
        yield 'No holes' => [Fixtures::readJSON('geometry/Polygon-no-holes.json')];
        yield 'With holes' => [Fixtures::readJSON('geometry/Polygon-with-holes.json')];
    }

    protected function getGeometry(array|string $geoJson): Polygon
    {
        return Polygon::fromGeoJSON($geoJson);
    }
}
