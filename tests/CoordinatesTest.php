<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversClass(Coordinates::class)]
final class CoordinatesTest extends TestCase
{
    public static function providerCoordinates(): iterable
    {
        yield '1 DP' => [0.0, 52.2, 0.1, [0.0, 52.2, 0.1]];
        yield '5 DP' => [0.00001, 52.22222, 0.11111, [0.00001, 52.22222, 0.11111]];
        yield 'No elevation' => [0.00001, 52.22222, null, [0.00001, 52.22222]];
    }

    #[DataProvider('providerCoordinates')]
    public function testGetLongitude(float $longitude, float $latitude, ?float $elevation): void
    {
        $coordinates = new Coordinates($longitude, $latitude, $elevation);

        self::assertSame($longitude, $coordinates->getLongitude());
    }

    #[DataProvider('providerCoordinates')]
    public function testGetLatitude(float $longitude, float $latitude, ?float $elevation): void
    {
        $coordinates = new Coordinates($longitude, $latitude, $elevation);

        self::assertSame($latitude, $coordinates->getLatitude());
    }

    #[DataProvider('providerCoordinates')]
    public function testGetElevation(float $longitude, float $latitude, ?float $elevation): void
    {
        $coordinates = new Coordinates($longitude, $latitude, $elevation);

        self::assertSame($elevation, $coordinates->getElevation());
    }

    #[DataProvider('providerCoordinates')]
    public function testJsonSerialize(float $longitude, float $latitude, ?float $elevation, array $expected): void
    {
        $coordinates = new Coordinates($longitude, $latitude, $elevation);

        self::assertSame($expected, $coordinates->jsonSerialize());
    }

    public static function providerJson(): iterable
    {
        yield 'LineString' => [Fixtures::readJSON('geometry/LineString.json')];
        yield 'MultiLineStrings' => [Fixtures::readJSON('geometry/MultiLineString.json')];
        yield 'MultiPoint' => [Fixtures::readJSON('geometry/MultiPoint.json')];
        yield 'MultiPolygon' => [Fixtures::readJSON('geometry/MultiPolygon.json')];
        yield 'MultiPolygon string' => [Fixtures::readFile('geometry/MultiPolygon.json')];
        yield 'Point' => [Fixtures::readJSON('geometry/Point.json')];
        yield 'Polygon-no-holes' => [Fixtures::readJSON('geometry/Polygon-no-holes.json')];
        yield 'Polygon-with-holes' => [Fixtures::readJSON('geometry/Polygon-with-holes.json')];
    }

    #[DataProvider('providerJson')]
    public function testFromGeoJson(array|string $json): void
    {
        $coordinates = Coordinates::fromGeoJSON($json);
        if (\is_string($json)) {
            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        self::assertSame($json['coordinates'], json_decode(json_encode($coordinates, JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION), true, 512, JSON_THROW_ON_ERROR));
    }

    public function testFromGeoJsonThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessageMatches('#GeoJSON does not have a \"coordinates\" property#');

        Coordinates::fromGeoJSON([1.1, 2.2, 3.3]);
    }
}
