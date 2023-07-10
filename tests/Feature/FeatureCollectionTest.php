<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Feature;

use Camelot\GeoJSON\Feature\Feature;
use Camelot\GeoJSON\Feature\FeatureCollection;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use Camelot\GeoJSON\Tests\GeometryTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(FeatureCollection::class)]
final class FeatureCollectionTest extends GeometryTestCase
{
    public static function providerType(): iterable
    {
        yield ['FeatureCollection', Fixtures::readJSON('feature/FeatureCollection.json')];
    }

    public static function providerJson(): iterable
    {
        yield [Fixtures::readFile('feature/FeatureCollection.json')];
        yield [Fixtures::readJSON('feature/FeatureCollection.json')];
    }

    public function testGetSetAddFeatures(): void
    {
        $featureCollection = $this->getGeometry(Fixtures::readJSON('feature/FeatureCollection.json'));
        self::assertIsArray($featureCollection->getFeatures());

        $featureCollection->setFeatures([]);
        self::assertEmpty($featureCollection->getFeatures());

        $feature = Feature::fromGeoJSON(Fixtures::readJSON('feature/Feature.json'));
        $featureCollection->addFeature($feature);
        self::assertSame([$feature], $featureCollection->getFeatures());
    }

    protected function getGeometry(array|string $geoJson): FeatureCollection
    {
        return FeatureCollection::fromGeoJSON($geoJson);
    }
}
