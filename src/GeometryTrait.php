<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

trait GeometryTrait
{
    private string $type = self::TYPE;

    private ?BoundingBox $bbox = null;

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
}
