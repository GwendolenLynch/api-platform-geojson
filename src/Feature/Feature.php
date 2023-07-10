<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Feature;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\Geometry\LineString;
use Camelot\GeoJSON\Geometry\MultiLineString;
use Camelot\GeoJSON\Geometry\MultiPoint;
use Camelot\GeoJSON\Geometry\MultiPolygon;
use Camelot\GeoJSON\Geometry\Point;
use Camelot\GeoJSON\Geometry\Polygon;

#[ApiComponent(
    description: <<<'TAG'
        A Feature object represents a spatially bounded thing.  Every Feature
        object is a GeoJSON object no matter where it occurs in a GeoJSON
        text.

        - A Feature object has a "type" member with the value "Feature".
        - A Feature object has a member with the name "geometry".  The value
          of the geometry member SHALL be either a Geometry object as defined
          above or, in the case that the Feature is unlocated, a JSON null value.
        - A Feature object has a member with the name "properties".  The
          value of the properties member is an object (any JSON object or a
          JSON null value).
        - If a Feature has a commonly used identifier, that identifier
          SHOULD be included as a member of the Feature object with the name
          "id", and the value of this member is either a JSON string or number.

        TAG,
    properties: [
        'type' => [
            'type' => 'string',
            'enum' => [
                'Feature',
            ],
            'readOnly' => true,
        ],
        'geometry' => [
            'anyOf' => [
                ['$ref' => '#/components/schemas/Feature'],
                ['$ref' => '#/components/schemas/FeatureCollection'],
                ['$ref' => '#/components/schemas/Point'],
                ['$ref' => '#/components/schemas/MultiPoint'],
                ['$ref' => '#/components/schemas/LineString'],
                ['$ref' => '#/components/schemas/MultiLineString'],
                ['$ref' => '#/components/schemas/Polygon'],
                ['$ref' => '#/components/schemas/MultiPolygon'],
                ['$ref' => '#/components/schemas/GeometryCollection'],
                ['type' => 'null'],
            ],
        ],
        'properties' => [
            'type' => 'object',
            'additionalProperties' => true,
            'description' => 'A JSON object.',
            'example' => '
            {
              "foo": "bar",
              "baz": false,
            }
            ',
        ],
    ],
    required: [
        'type',
        'geometry',
    ],
    externalDocs: [
        'url' => 'https://tools.ietf.org/html/rfc7946#section-3.2',
    ],
)]
final class Feature implements Geometry
{
    public const TYPE = 'Feature';

    private string $type = self::TYPE;

    private ?BoundingBox $bbox;

    private ?Geometry $geometry;

    private ?array $properties;

    public function __construct(?Geometry $geometry, ?BoundingBox $bbox = null, ?array $properties = null)
    {
        $this->bbox = $bbox;
        $this->geometry = $geometry;
        $this->properties = $properties;
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

        $geometry = match ($json['geometry']['type']) {
            'LineString' => LineString::fromGeoJSON($json['geometry']),
            'MultiLineString' => MultiLineString::fromGeoJSON($json['geometry']),
            'MultiPoint' => MultiPoint::fromGeoJSON($json['geometry']),
            'MultiPolygon' => MultiPolygon::fromGeoJSON($json['geometry']),
            'Point' => Point::fromGeoJSON($json['geometry']),
            'Polygon' => Polygon::fromGeoJSON($json['geometry']),
            default => throw new \DomainException(sprintf('Unknown Geometry type: %s', $json['geometry']['type'])),
        };
        $boundingBox = ($json['bbox'] ?? false) ? BoundingBox::fromJson($json['bbox']) : null;

        return new self($geometry, $boundingBox, $json['properties'] ?? null);
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

    public function getGeometry(): ?Geometry
    {
        return $this->geometry;
    }

    public function setGeometry(?Geometry $geometry): self
    {
        $this->geometry = $geometry;

        return $this;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function setProperties(?array $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function addProperty(array $property): self
    {
        $this->properties[] = $property;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'type' => $this->type,
            'bbox' => $this->bbox,
            'geometry' => $this->geometry,
            'properties' => $this->properties,
        ];

        return array_filter($json);
    }
}
