<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Geometry;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\Position;
use Camelot\GeoJSON\Tests\GeometryTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/** @internal */
abstract class PositionTestCase extends GeometryTestCase
{
    abstract public static function providerCoordinates(): iterable;

    #[DataProvider('providerJson')]
    public function testGetCoordinates(array|string $json): void
    {
        $coordinates = Coordinates::fromGeoJSON($json);

        self::assertEqualsCanonicalizing($coordinates, $this->getGeometry($json)->getCoordinates());
    }

    #[DataProvider('providerCoordinates')]
    public function testSetCoordinates(array $json, array|Coordinates $coordinates): void
    {
        $geometry = $this->getGeometry($json);
        $geometry->setCoordinates($coordinates);

        self::assertSame($coordinates, $geometry->getCoordinates());
    }

    abstract protected function getGeometry(array|string $geoJson): Position;
}
