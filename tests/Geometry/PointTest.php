<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Geometry;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\Point;
use Camelot\GeoJSON\Geometry\PositionTrait;
use Camelot\GeoJSON\GeometryTrait;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(Point::class)]
#[CoversClass(GeometryTrait::class)]
#[CoversClass(PositionTrait::class)]
final class PointTest extends PositionTestCase
{
    public static function providerType(): iterable
    {
        yield ['Point', Fixtures::readJSON('geometry/Point.json')];
    }

    public static function providerCoordinates(): iterable
    {
        yield [Fixtures::readJSON('geometry/Point.json'), new Coordinates(0.42, 42.777, 0.525)];
    }

    public static function providerJson(): iterable
    {
        yield [Fixtures::readFile('geometry/Point.json')];
        yield [Fixtures::readJSON('geometry/Point.json')];
    }

    protected function getGeometry(array|string $geoJson): Point
    {
        return Point::fromGeoJSON($geoJson);
    }
}
