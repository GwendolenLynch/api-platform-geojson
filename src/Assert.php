<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\Feature\Feature;

/** @codeCoverageIgnore  */
final class Assert
{
    public static function assertArray(mixed $value): void
    {
        if (!\is_array($value)) {
            throw new \DomainException(sprintf('Value is not an array, %s given.', \is_object($value) ? $value::class : \gettype($value)));
        }
    }

    public static function assertInstanceOf(mixed $value, string $className): void
    {
        if (!$value instanceof $className) {
            throw new \DomainException(sprintf('Value is not an instance of %s, %s given.', $className, \is_object($value) ? $value::class : \gettype($value)));
        }
    }

    public static function assertCoordinates(mixed $coordinates): void
    {
        self::assertInstanceOf($coordinates, Coordinates::class);
    }

    public static function assertCoordinatesArray(mixed $coordinates): void
    {
        self::assertArray($coordinates);

        foreach ($coordinates as $array) {
            self::assertCoordinates($array);
        }
    }

    public static function assertCoordinatesArrayArray(mixed $coordinates): void
    {
        self::assertArray($coordinates);

        foreach ($coordinates as $array) {
            self::assertCoordinatesArray($array);
        }
    }

    public static function assertCoordinatesArrayArrayArray(mixed $coordinates): void
    {
        self::assertArray($coordinates);

        foreach ($coordinates as $array) {
            self::assertCoordinatesArrayArray($array);
        }
    }

    public static function assertFeatureArray(mixed $features): void
    {
        self::assertArray($features);

        foreach ($features as $feature) {
            self::assertInstanceOf($feature, Feature::class);
        }
    }

    public static function assertGeometryArray(mixed $geometries): void
    {
        self::assertArray($geometries);

        foreach ($geometries as $geometry) {
            self::assertInstanceOf($geometry, Geometry::class);
        }
    }
}
