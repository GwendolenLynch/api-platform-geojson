<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\Attribute\ApiComponent;

#[ApiComponent(
    type: 'array',
    description: 'A GeoJSON object MAY have a member named "bbox" to include information on the coordinate range for its Geometries, Features, or FeatureCollections.

The value of the bbox member MUST be an array of length 2*n where n is the number of dimensions represented in the contained geometries, with all axes of the most southwesterly point followed by all axes of the more northeasterly point.

The axes order of a bbox follows the axes order of geometries.
',
    items: [
        'type' => 'number',
        'format' => 'float',
    ],
    minItems: 4,
    maxItems: 6,
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-5',
    ],
    example: [100.1, 101.2, 102.3, 103.4],
)]
final class BoundingBox implements \JsonSerializable
{
    private ?Coordinates $westSouth;

    private ?Coordinates $eastNorth;

    public function __construct(Coordinates $westSouth = null, Coordinates $eastNorth = null)
    {
        $this->westSouth = $westSouth;
        $this->eastNorth = $eastNorth;
    }

    public static function fromJson(array $json): self
    {
        $count = \count($json);
        if ($count === 4) {
            return new self(new Coordinates($json[0], $json[1]), new Coordinates($json[2], $json[3]));
        }
        if ($count === 6) {
            return new self(new Coordinates($json[0], $json[1], $json[2]), new Coordinates($json[3], $json[4], $json[5]));
        }

        throw new \DomainException(sprintf('A bounding box must have either 4 (2D) or 6 (3D) elements, %s provided', $count));
    }

    /** @internal */
    public function setWestSouth(Coordinates $westSouth): self
    {
        $this->westSouth = $westSouth;

        return $this;
    }

    /** @internal */
    public function setEastNorth(Coordinates $eastNorth): self
    {
        $this->eastNorth = $eastNorth;

        return $this;
    }

    public function getWest(): float
    {
        return $this->westSouth->getLongitude();
    }

    public function getSouth(): float
    {
        return $this->westSouth->getLatitude();
    }

    public function getSouthwestElevation(): ?float
    {
        return $this->westSouth->getElevation();
    }

    public function getEast(): float
    {
        return $this->eastNorth->getLongitude();
    }

    public function getNorth(): float
    {
        return $this->eastNorth->getLatitude();
    }

    public function getNorthEastElevation(): ?float
    {
        return $this->eastNorth->getElevation();
    }

    public function jsonSerialize(): array
    {
        return [
            ...$this->westSouth?->jsonSerialize() ?? [],
            ...$this->eastNorth?->jsonSerialize() ?? [],
        ];
    }
}
