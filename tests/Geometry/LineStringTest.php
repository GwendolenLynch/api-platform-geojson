<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Geometry;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\LineString;
use Camelot\GeoJSON\Geometry\PositionTrait;
use Camelot\GeoJSON\GeometryTrait;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(LineString::class)]
#[CoversClass(GeometryTrait::class)]
#[CoversClass(PositionTrait::class)]
final class LineStringTest extends PositionTestCase
{
    public static function providerType(): iterable
    {
        yield ['LineString', Fixtures::readJSON('geometry/LineString.json')];
    }

    public static function providerCoordinates(): iterable
    {
        yield [Fixtures::readJSON('geometry/LineString.json'), [new Coordinates(0.42, 42.777, 0.525)]];
    }

    public static function providerJson(): iterable
    {
        yield [Fixtures::readJSON('geometry/LineString.json')];
    }

    protected function getGeometry(array|string $geoJson): LineString
    {
        return LineString::fromGeoJSON($geoJson);
    }
}
