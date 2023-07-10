<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Geometry;

use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\GeometryTrait;

trait PositionTrait
{
    use GeometryTrait;

    private array|Coordinates $coordinates;

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @throws \DomainException when GeoJSON type is incorrect
     * @throws \JsonException   when JSON is invalid
     */
    public static function fromGeoJSON(array|string $json): self
    {
        if (\is_string($json)) {
            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        $type = $json['type'] ?? '';
        if ($type !== self::TYPE) {
            throw new \DomainException(sprintf('GeoJSON is not of type "%s", "%s" given', self::TYPE, $type));
        }
        $boundingBox = ($json['bbox'] ?? false) ? BoundingBox::fromJson($json['bbox']) : null;

        return new self(Coordinates::fromGeoJSON($json), $boundingBox);
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => $this->type,
            'bbox' => $this->bbox,
            'coordinates' => $this->coordinates,
        ]);
    }
}
