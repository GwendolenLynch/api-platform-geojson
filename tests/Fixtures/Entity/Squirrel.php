<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Fixtures\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Camelot\GeoJSON;
use Camelot\GeoJSON\Feature;
use Camelot\GeoJSON\Geometry;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[Get]
#[GetCollection]
#[ORM\Entity]
class Squirrel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'bbox', nullable: true)]
    private ?GeoJSON\BoundingBox $boundingBox = null;
    #[ORM\Column(type: 'coordinates', nullable: true)]
    private ?GeoJSON\Coordinates $coordinates = null;

    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?GeoJSON\GeometryCollection $geometryCollection = null;

    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Feature\FeatureCollection $featureCollection = null;
    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Feature\Feature $feature = null;

    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Geometry\LineString $lineString = null;
    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Geometry\MultiLineString $multiLineString = null;
    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Geometry\MultiPoint $multiPoint = null;
    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Geometry\MultiPolygon $multiPolygon = null;
    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Geometry\Point $point = null;
    #[ORM\Column(type: 'geojson', nullable: true)]
    private ?Geometry\Polygon $polygon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoundingBox(): ?GeoJSON\BoundingBox
    {
        return $this->boundingBox;
    }

    public function setBoundingBox(?GeoJSON\BoundingBox $boundingBox): self
    {
        $this->boundingBox = $boundingBox;

        return $this;
    }

    public function getCoordinates(): ?GeoJSON\Coordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(?GeoJSON\Coordinates $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function getGeometryCollection(): ?GeoJSON\GeometryCollection
    {
        return $this->geometryCollection;
    }

    public function setGeometryCollection(?GeoJSON\GeometryCollection $geometryCollection): self
    {
        $this->geometryCollection = $geometryCollection;

        return $this;
    }

    public function getFeatureCollection(): ?Feature\FeatureCollection
    {
        return $this->featureCollection;
    }

    public function setFeatureCollection(?Feature\FeatureCollection $featureCollection): self
    {
        $this->featureCollection = $featureCollection;

        return $this;
    }

    public function getFeature(): ?Feature\Feature
    {
        return $this->feature;
    }

    public function setFeature(?Feature\Feature $feature): self
    {
        $this->feature = $feature;

        return $this;
    }

    public function getLineString(): ?Geometry\LineString
    {
        return $this->lineString;
    }

    public function setLineString(?Geometry\LineString $lineString): self
    {
        $this->lineString = $lineString;

        return $this;
    }

    public function getMultiLineString(): ?Geometry\MultiLineString
    {
        return $this->multiLineString;
    }

    public function setMultiLineString(?Geometry\MultiLineString $multiLineString): self
    {
        $this->multiLineString = $multiLineString;

        return $this;
    }

    public function getMultiPoint(): ?Geometry\MultiPoint
    {
        return $this->multiPoint;
    }

    public function setMultiPoint(?Geometry\MultiPoint $multiPoint): self
    {
        $this->multiPoint = $multiPoint;

        return $this;
    }

    public function getMultiPolygon(): ?Geometry\MultiPolygon
    {
        return $this->multiPolygon;
    }

    public function setMultiPolygon(?Geometry\MultiPolygon $multiPolygon): self
    {
        $this->multiPolygon = $multiPolygon;

        return $this;
    }

    public function getPoint(): ?Geometry\Point
    {
        return $this->point;
    }

    public function setPoint(?Geometry\Point $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getPolygon(): ?Geometry\Polygon
    {
        return $this->polygon;
    }

    public function setPolygon(?Geometry\Polygon $polygon): self
    {
        $this->polygon = $polygon;

        return $this;
    }
}
