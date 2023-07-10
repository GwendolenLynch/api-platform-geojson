<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use Camelot\GeoJSON\BoundingBox;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversClass(BoundingBox::class)]
final class BoundingBoxTest extends TestCase
{
    public static function providerJSON(): iterable
    {
        yield '2D' => [[100.0, 0.0, 105.0, 1.0]];
        yield '3D' => [[100.0, 0.0, -100.0, 105.0, 1.0, 0.0]];
    }

    #[DataProvider('providerJSON')]
    public function testFromJSON(array $coordinates): void
    {
        self::assertSame($coordinates, BoundingBox::fromJson($coordinates)->jsonSerialize());
    }

    public static function providerInvalidJSON(): iterable
    {
        yield 'None' => [[]];
        yield 'One' => [[1.1]];
        yield 'Two' => [[1.1, 2.2]];
        yield 'Three' => [[1.1, 2.2, 3.3]];
        yield 'Five' => [[1.1, 2.2, 3.3, 4.4, 5.5]];
        yield 'Seven' => [[1.1, 2.2, 3.3, 4.4, 5.5, 6.6, 7.7]];
    }

    #[DataProvider('providerInvalidJSON')]
    public function testFromJSONThrowException(array $json): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('A bounding box must have either 4 (2D) or 6 (3D) elements');

        BoundingBox::fromJson($json);
    }

    #[DataProvider('providerJSON')]
    public function testGetWest(array $coordinates): void
    {
        $expected = $coordinates[0];

        self::assertSame($expected, BoundingBox::fromJson($coordinates)->getWest());
    }

    #[DataProvider('providerJSON')]
    public function testGetSouth(array $coordinates): void
    {
        $expected = $coordinates[1];

        self::assertSame($expected, BoundingBox::fromJson($coordinates)->getSouth());
    }

    #[DataProvider('providerJSON')]
    public function testSouthwestElevation(array $coordinates): void
    {
        $expected = \count($coordinates) === 4 ? null : $coordinates[2];

        self::assertSame($expected, BoundingBox::fromJson($coordinates)->getSouthwestElevation());
    }

    #[DataProvider('providerJSON')]
    public function testGetEast(array $coordinates): void
    {
        $expected = \count($coordinates) === 4 ? $coordinates[2] : $coordinates[3];

        self::assertSame($expected, BoundingBox::fromJson($coordinates)->getEast());
    }

    #[DataProvider('providerJSON')]
    public function testGetNorth(array $coordinates): void
    {
        $expected = \count($coordinates) === 4 ? $coordinates[3] : $coordinates[4];

        self::assertSame($expected, BoundingBox::fromJson($coordinates)->getNorth());
    }

    #[DataProvider('providerJSON')]
    public function testNorthEastElevation(array $coordinates): void
    {
        $expected = \count($coordinates) === 4 ? null : $coordinates[5];

        self::assertSame($expected, BoundingBox::fromJson($coordinates)->getNorthEastElevation());
    }
}
