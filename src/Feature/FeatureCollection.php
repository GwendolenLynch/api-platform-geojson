<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Feature;

use Camelot\GeoJSON\Assert;
use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Geometry;

#[ApiComponent(
    description: <<<'TAG'
        GeoJSON 'FeatureCollection' object.

        A FeatureCollection object has a member with the name "features".

        The value of "features" is a JSON array.

        Each element of the array is a Feature object.

        It is possible for this array to be empty.

        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'enum' => [
                'FeatureCollection',
            ],
            'readOnly' => true,
        ],
        'features' => [
            'anyOf' => [
                [
                    'type' => 'array',
                    'items' => [
                        '$ref' => '#/components/schemas/Feature',
                    ],
                ],
                ['type' => 'null'],
            ],
        ],
    ],
    required: [
        'type',
        'features',
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.3',
    ],
)]
final class FeatureCollection implements Geometry
{
    public const TYPE = 'FeatureCollection';

    private string $type = self::TYPE;

    private ?BoundingBox $bbox;

    /** @var Feature[] */
    private array $features;

    public function __construct(array $features, ?BoundingBox $bbox = null)
    {
        Assert::assertFeatureArray($features);

        $this->bbox = $bbox;
        $this->features = $features;
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

        $features = [];
        foreach ($json['features'] as $feature) {
            $features[] = Feature::fromGeoJSON($feature);
        }
        $boundingBox = ($json['bbox'] ?? false) ? BoundingBox::fromJson($json['bbox']) : null;

        return new self($features, $boundingBox);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getBbox(): ?BoundingBox
    {
        return $this->bbox;
    }

    public function setBbox(?BoundingBox $bbox): self
    {
        $this->bbox = $bbox;

        return $this;
    }

    public function getFeatures(): array
    {
        return $this->features;
    }

    public function setFeatures(array $features): self
    {
        Assert::assertFeatureArray($features);

        $this->features = $features;

        return $this;
    }

    public function addFeature(Feature $feature): self
    {
        $this->features[] = $feature;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => $this->type,
            'bbox' => $this->bbox,
            'features' => array_map(static fn (Feature $f) => $f->jsonSerialize(), $this->features),
        ]);
    }
}
