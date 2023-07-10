<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\Tests\Fixtures\NonStandardPositionFixture;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** @internal */
abstract class GeometryTestCase extends TestCase
{
    abstract public static function providerType(): iterable;

    abstract public static function providerJson(): iterable;

    #[DataProvider('providerType')]
    public function testGetType(string $type, array $json): void
    {
        self::assertSame($type, $this->getGeometry($json)->getType());
    }

    public function testInvalidTypeThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessageMatches('#GeoJSON is not of type \"\w+\", \"Fountain\" given#');

        $this->getGeometry((new NonStandardPositionFixture())->jsonSerialize());
    }

    #[DataProvider('providerJson')]
    public function testGetSetBbox(array|string $json): void
    {
        $boundingBox = new BoundingBox(new Coordinates(1, 2, 3), new Coordinates(4, 5, 6));
        $geometry = $this->getGeometry($json);
        $geometry->setBbox($boundingBox);

        self::assertSame($boundingBox, $geometry->getBbox());
    }

    #[DataProvider('providerJson')]
    public function testJsonSerialize(array|string $json): void
    {
        $expected = \is_string($json) ? $json : $this->encode($json);

        self::assertJsonStringEqualsJsonString($expected, $this->encode($this->getGeometry($json)));
    }

    abstract protected function getGeometry(array|string $geoJson): Geometry;

    /** @throws \JsonException */
    protected function encode(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION);
    }
}
