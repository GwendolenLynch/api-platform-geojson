<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\Attribute\ApiComponent;

#[ApiComponent(
    type: 'array',
    description: 'Array of coordinates in the format [longitude, latitude, elevation]',
    items: [
        'type' => 'number',
        'format' => 'float',
    ],
    minItems: 2,
    maxItems: 3,
    example: [100.1, 1.2],
)]
final class Coordinates implements \JsonSerializable
{
    public function __construct(
        private float $longitude,
        private float $latitude,
        private ?float $elevation = null
    ) {}

    public static function fromJson(array|string $json): self
    {
        if (\is_string($json)) {
            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        if (!self::isScalarCoordinates($json)) {
            throw new \DomainException('JSON is not a valid 2 or 3 value array.');
        }
        return new self($json[0], $json[1], $json[2] ?? null);
    }

    /**
     * @throws \DomainException when GeoJSON type is incorrect
     * @throws \JsonException   when JSON is invalid
     *
     * @return Coordinates|Coordinates[]|Coordinates[][]|Coordinates[][][]|Coordinates[][][][]
     */
    public static function fromGeoJSON(array|string $json): array|self
    {
        if (\is_string($json)) {
            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        if (!isset($json['coordinates'])) {
            throw new \DomainException(sprintf('GeoJSON does not have a "coordinates" property.%s%s', PHP_EOL, json_encode($json, JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION)));
        }
        $coords = $json['coordinates'];

        if (self::isScalarCoordinates($coords)) {
            return new self($coords[0], $coords[1], $coords[2] ?? null);
        }

        $set = [];
        foreach ($coords as $item) {
            if ($item) {
                $set[] = self::buildMultidimensionalSet($item);
            }
        }

        return $set;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getElevation(): ?float
    {
        return $this->elevation;
    }

    public function jsonSerialize(): array
    {
        $json = [$this->longitude, $this->latitude];
        if ($this->elevation !== null) {
            $json[] = $this->elevation;
        }

        return $json;
    }

    private static function isScalarCoordinates(array $array): bool
    {
        if ((\count($array) === 2) || (\count($array) === 3)) {
            return is_numeric($array[0]) && is_numeric($array[1]) && is_numeric($array[2] ?? 0);
        }

        return false;
    }

    private static function buildMultidimensionalSet(array $json): array|self
    {
        if (self::isScalarCoordinates($json)) {
            return self::fromJson($json);
        }

        $set = [];
        foreach ($json as $item) {
            $set[] = self::buildMultidimensionalSet($item);
        }

        return $set;
    }
}
