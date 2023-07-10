<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Serializer;

use Camelot\GeoJSON\OpenApi\Ref;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class RefNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    public function normalize(mixed $object, ?string $format = null, array $context = []): null|array|\ArrayObject|bool|float|int|string
    {
        return (string) $object;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Ref;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Ref::class => true,
        ];
    }
}
