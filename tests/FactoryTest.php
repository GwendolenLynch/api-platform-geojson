<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use Camelot\GeoJSON\Factory;
use Camelot\GeoJSON\Geometry\LineString;
use Camelot\GeoJSON\Geometry\MultiLineString;
use Camelot\GeoJSON\Geometry\MultiPoint;
use Camelot\GeoJSON\Geometry\MultiPolygon;
use Camelot\GeoJSON\Geometry\Point;
use Camelot\GeoJSON\Geometry\Polygon;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Camelot\GeoJSON\Factory
 *
 * @internal
 */
final class FactoryTest extends TestCase
{
    public static function providerFromJson(): iterable
    {
        yield 'LineString' => [LineString::class, Fixtures::readFile('geometry/LineString.json')];
        yield 'MultiLineString' => [MultiLineString::class, Fixtures::readFile('geometry/MultiLineString.json')];
        yield 'MultiPoint' => [MultiPoint::class, Fixtures::readFile('geometry/MultiPoint.json')];
        yield 'MultiPolygon' => [MultiPolygon::class, Fixtures::readFile('geometry/MultiPolygon.json')];
        yield 'Point' => [Point::class, Fixtures::readFile('geometry/Point.json')];
        yield 'Polygon no holes' => [Polygon::class, Fixtures::readFile('geometry/Polygon-no-holes.json')];
        yield 'Polygon with holes' => [Polygon::class, Fixtures::readFile('geometry/Polygon-with-holes.json')];
    }

    #[DataProvider('providerFromJson')]
    public function testFromJson(mixed $expected, string $json): void
    {
        self::assertInstanceOf($expected, Factory::fromJson($json));
    }

    public static function providerFromJsonArray(): iterable
    {
        yield 'LineString' => [LineString::class, Fixtures::readJSON('geometry/LineString.json')];
        yield 'MultiLineString' => [MultiLineString::class, Fixtures::readJSON('geometry/MultiLineString.json')];
        yield 'MultiPoint' => [MultiPoint::class, Fixtures::readJSON('geometry/MultiPoint.json')];
        yield 'MultiPolygon' => [MultiPolygon::class, Fixtures::readJSON('geometry/MultiPolygon.json')];
        yield 'Point' => [Point::class, Fixtures::readJSON('geometry/Point.json')];
        yield 'Polygon no holes' => [Polygon::class, Fixtures::readJSON('geometry/Polygon-no-holes.json')];
        yield 'Polygon with holes' => [Polygon::class, Fixtures::readJSON('geometry/Polygon-with-holes.json')];
    }

    #[DataProvider('providerFromJsonArray')]
    public function testFromJsonArray(mixed $expected, array $json): void
    {
        self::assertInstanceOf($expected, Factory::fromJson($json));
    }
}
