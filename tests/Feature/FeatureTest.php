<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Feature;

use Camelot\GeoJSON\Feature\Feature;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use Camelot\GeoJSON\Tests\GeometryTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

/** @internal */
#[CoversClass(Feature::class)]
final class FeatureTest extends GeometryTestCase
{
    public static function providerType(): iterable
    {
        yield ['Feature', Fixtures::readJSON('feature/Feature.json')];
    }

    public static function providerJson(): iterable
    {
        yield [Fixtures::readFile('feature/Feature.json')];
        yield [Fixtures::readJSON('feature/Feature.json')];
    }

    public static function providerPosition(): iterable
    {
        $json = Fixtures::readJSON('feature/Feature.json');

        yield [$json, Geometry\LineString::fromGeoJSON(Fixtures::readJSON('geometry/LineString.json'))];
        yield [$json, Geometry\MultiLineString::fromGeoJSON(Fixtures::readJSON('geometry/MultiLineString.json'))];
        yield [$json, Geometry\MultiPoint::fromGeoJSON(Fixtures::readJSON('geometry/MultiPoint.json'))];
        yield [$json, Geometry\MultiPolygon::fromGeoJSON(Fixtures::readJSON('geometry/MultiPolygon.json'))];
        yield [$json, Geometry\Point::fromGeoJSON(Fixtures::readJSON('geometry/Point.json'))];
        yield [$json, Geometry\Polygon::fromGeoJSON(Fixtures::readJSON('geometry/Polygon-no-holes.json'))];
    }

    #[DataProvider('providerPosition')]
    public function testGetSetGeometry(array $json, Geometry $geometry): void
    {
        $feature = $this->getGeometry($json);
        $feature->setGeometry($geometry);

        self::assertSame($geometry, $feature->getGeometry());
    }

    public function testGetSetAddProperties(): void
    {
        $feature = $this->getGeometry(Fixtures::readJSON('feature/Feature.json'));
        self::assertIsArray($feature->getProperties());

        $feature->setProperties(null);
        self::assertNull($feature->getProperties());

        $feature->addProperty(['foo' => 'bar']);
        self::assertSame([['foo' => 'bar']], $feature->getProperties());
    }

    protected function getGeometry(array|string $geoJson): Feature
    {
        return Feature::fromGeoJSON($geoJson);
    }
}
