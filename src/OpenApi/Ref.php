<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\OpenApi;

use ApiPlatform\JsonSchema\Schema;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class Ref implements NormalizableInterface, \Stringable, \JsonSerializable
{
    public function __construct(
        private string $ref,
        private string $format,
        private string $version,
    ) {
        if (class_exists($ref)) {
            $this->ref = (new \ReflectionClass($this->ref))->getShortName();
        } else {
            $this->ref = preg_replace('/#\/(components\/schemas|definitions)\//', '', $this->ref);
        }
    }

    public function __toString(): string
    {
        return sprintf(
            '#/%s/%s%s',
            $this->version === Schema::VERSION_OPENAPI ? 'components/schemas' : 'definitions',
            $this->ref,
            $this->format === 'json' ? '' : ".{$this->format}"
        );
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function normalize(NormalizerInterface $normalizer, ?string $format = null, array $context = []): null|array|\ArrayObject|bool|float|int|string
    {
        return (string) $this;
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
