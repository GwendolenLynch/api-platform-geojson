<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\Attribute\ApiComponent;

#[ApiComponent(
    description: <<<'TAG'
        GeometryCollection "geometries" array of Geometry objects.

        e.g.:
        ```
        {
            "type": "GeometryCollection",
            "geometries": [
                {
                    "type": "Point",
                    "coordinates": [100.0, 0.0]
                },
                {
                    "type": "LineString",
                    "coordinates": [
                        [101.0, 0.0],
                        [102.0, 1.0]
                    ]
                }
            ]
        }
        ```
        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'enum' => [
                'GeometryCollection',
            ],
            'readOnly' => true,
        ],
        'geometries' => [
            'type' => 'array',
            'items' => [
                'anyOf' => [
                    ['$ref' => Feature\Feature::class],
                    ['$ref' => Feature\FeatureCollection::class],
                    ['$ref' => Geometry\Point::class],
                    ['$ref' => Geometry\MultiPoint::class],
                    ['$ref' => Geometry\LineString::class],
                    ['$ref' => Geometry\MultiLineString::class],
                    ['$ref' => Geometry\Polygon::class],
                    ['$ref' => Geometry\MultiPolygon::class],
                    ['$ref' => GeometryCollection::class],
                ],
            ],
        ],
    ],
    required: [
        'geometries',
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.1.8',
    ],
)]
final class GeometryCollection implements Geometry
{
    use GeometryTrait;

    public const TYPE = 'GeometryCollection';

    /** @var Geometry[] */
    private array $geometries;

    public function __construct(array $geometries = [])
    {
        Assert::assertGeometryArray($geometries);

        $this->geometries = $geometries;
    }

    public static function fromGeoJSON(array|string $json): self
    {
        if (\is_string($json)) {
            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        }

        $type = $json['type'] ?? '';
        if ($type !== self::TYPE) {
            throw new \DomainException(sprintf('GeoJSON is not of type "%s", "%s" given', self::TYPE, $type));
        }

        $self = new self();
        $self->bbox = isset($json['bbox']) ? BoundingBox::fromJson($json['bbox']) : null;
        $self->geometries = array_map(static fn (array $geometry) => Factory::fromJson($geometry), $json['geometries']);

        return $self;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function addGeometry(Geometry $geometry): self
    {
        $this->geometries[] = $geometry;

        return $this;
    }

    public function getGeometries(): array
    {
        return $this->geometries;
    }

    public function setGeometries(array $geometries): self
    {
        Assert::assertGeometryArray($geometries);

        $this->geometries = $geometries;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => $this->type,
            'bbox' => $this->bbox,
            'geometries' => $this->geometries,
        ]);
    }
}
