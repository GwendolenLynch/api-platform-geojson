<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Geometry;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\MultiPolygon;
use Camelot\GeoJSON\Geometry\PositionTrait;
use Camelot\GeoJSON\GeometryTrait;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(MultiPolygon::class)]
#[CoversClass(GeometryTrait::class)]
#[CoversClass(PositionTrait::class)]
final class MultiPolygonTest extends PositionTestCase
{
    public static function providerType(): iterable
    {
        yield ['MultiPolygon', Fixtures::readJSON('geometry/MultiPolygon.json')];
    }

    public static function providerCoordinates(): iterable
    {
        yield [Fixtures::readJSON('geometry/MultiPolygon.json'), [[[new Coordinates(0.42, 42.777, 0.525)]]]];
    }

    public static function providerJson(): iterable
    {
        yield [Fixtures::readJSON('geometry/MultiPolygon.json')];
    }

    protected function getGeometry(array|string $geoJson): MultiPolygon
    {
        return MultiPolygon::fromGeoJSON($geoJson);
    }
}
