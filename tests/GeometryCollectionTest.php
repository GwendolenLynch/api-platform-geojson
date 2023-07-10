<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Geometry\LineString;
use Camelot\GeoJSON\Geometry\Point;
use Camelot\GeoJSON\GeometryCollection;
use Camelot\GeoJSON\GeometryTrait;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversClass(GeometryCollection::class)]
#[CoversClass(GeometryTrait::class)]
final class GeometryCollectionTest extends TestCase
{
    public function testGetType(): void
    {
        self::assertSame('GeometryCollection', (new GeometryCollection())->getType());
    }

    public function testGetSetGeometries(): void
    {
        $collection = new GeometryCollection();
        self::assertSame([], $collection->getGeometries());

        $point = new Point(new Coordinates(1.1, 2.2));
        $collection->setGeometries([$point]);
        self::assertSame([$point], $collection->getGeometries());
    }

    public function testAddGeometries(): void
    {
        $collection = new GeometryCollection();
        self::assertSame([], $collection->getGeometries());

        $point = new Point(new Coordinates(1.1, 2.2));
        $collection->addGeometry($point);
        self::assertSame([$point], $collection->getGeometries());
    }

    public function testJsonSerialize(): void
    {
        $json = Fixtures::readJSON('geometry/GeometryCollection.json');
        $expected = $this->encode($json);

        $collection = new GeometryCollection();
        $collection->addGeometry(new Point(new Coordinates(100.0, 0.0)));
        $collection->addGeometry(new LineString([
            new Coordinates(101.0, 1.0),
            new Coordinates(102.0, 2.0),
        ]));

        self::assertJsonStringEqualsJsonString($expected, $this->encode($collection));
    }

    /** @throws \JsonException */
    protected function encode(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION);
    }
}
