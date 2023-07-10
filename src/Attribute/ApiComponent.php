<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Attribute;

use Camelot\GeoJSON\Resource\Merge;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class ApiComponent
{
    public function __construct(
        private ?string $type = null,
        private ?string $ref = null,
        private ?string $description = null,
        private ?bool $deprecated = false,
        private ?array $properties = null,
        private ?array $required = null,
        private ?array $items = null,
        private ?int $minItems = null,
        private ?int $maxItems = null,
        private ?array $oneOf = null,
        private ?array $allOf = null,
        private ?array $anyOf = null,
        private ?array $externalDocs = null,
        private null|array|string $example = null,
    ) {}

    public function withMergedAttribute(self $component): self
    {
        $self = new self();
        foreach (Merge::schemas($this->toArray(), $component->toArray()) as $property => $value) {
            $self->{$property} = $value;
        }

        return $self;
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), static fn ($v) => $v !== null);
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function withType(?string $type): self
    {
        $self = clone $this;
        $self->type = $type;

        return $self;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function withRef(?string $ref): self
    {
        $self = clone $this;
        $self->ref = $ref;

        return $self;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self->description = $description;

        return $self;
    }

    public function getDeprecated(): ?bool
    {
        return $this->deprecated;
    }

    public function withDeprecated(?bool $deprecated): self
    {
        $self = clone $this;
        $self->deprecated = $deprecated;

        return $self;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function withProperties(?array $properties): self
    {
        $self = clone $this;
        $self->properties = $properties;

        return $self;
    }

    public function getRequired(): ?array
    {
        return $this->required;
    }

    public function withRequired(?array $required): self
    {
        $self = clone $this;
        $self->required = $required;

        return $self;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function withItems(?array $items): self
    {
        $self = clone $this;
        $self->items = $items;

        return $self;
    }

    public function getMinItems(): ?int
    {
        return $this->minItems;
    }

    public function withMinItems(?int $minItems): self
    {
        $self = clone $this;
        $self->minItems = $minItems;

        return $self;
    }

    public function getMaxItems(): ?int
    {
        return $this->maxItems;
    }

    public function withMaxItems(?int $maxItems): self
    {
        $self = clone $this;
        $self->maxItems = $maxItems;

        return $self;
    }

    public function getOneOf(): ?array
    {
        return $this->oneOf;
    }

    public function withOneOf(?array $oneOf): self
    {
        $self = clone $this;
        $self->oneOf = $oneOf;

        return $self;
    }

    public function getAllOf(): ?array
    {
        return $this->allOf;
    }

    public function withAllOf(?array $allOf): self
    {
        $self = clone $this;
        $self->allOf = $allOf;

        return $self;
    }

    public function getAnyOf(): ?array
    {
        return $this->anyOf;
    }

    public function withAnyOf(?array $anyOf): self
    {
        $self = clone $this;
        $self->anyOf = $anyOf;

        return $self;
    }

    public function getExternalDocs(): ?array
    {
        return $this->externalDocs;
    }

    public function withExternalDocs(?array $externalDocs): self
    {
        $self = clone $this;
        $self->externalDocs = $externalDocs;

        return $self;
    }

    public function getExample(): null|array|string
    {
        return $this->example;
    }

    public function withExample(null|array|string $example): self
    {
        $self = clone $this;
        $self->example = $example;

        return $self;
    }
}
