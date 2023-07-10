<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Geometry;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\MultiPoint;
use Camelot\GeoJSON\Geometry\PositionTrait;
use Camelot\GeoJSON\GeometryTrait;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(MultiPoint::class)]
#[CoversClass(GeometryTrait::class)]
#[CoversClass(PositionTrait::class)]
final class MultiPointTest extends PositionTestCase
{
    public static function providerType(): iterable
    {
        yield ['MultiPoint', Fixtures::readJSON('geometry/MultiPoint.json')];
    }

    public static function providerCoordinates(): iterable
    {
        yield [Fixtures::readJSON('geometry/MultiPoint.json'), [new Coordinates(0.42, 42.777, 0.525)]];
    }

    public static function providerJson(): iterable
    {
        yield [Fixtures::readJSON('geometry/MultiPoint.json')];
    }

    protected function getGeometry(array|string $geoJson): MultiPoint
    {
        return MultiPoint::fromGeoJSON($geoJson);
    }
}
