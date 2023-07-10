<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Serializer;

use Camelot\GeoJSON\BoundingBox;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\Factory;
use Camelot\GeoJSON\GeoJson;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class GeoJsonDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED = 'GEOJSON_ATTRIBUTE_DENORMALIZER_ALREADY_CALLED';

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $context[self::ALREADY_CALLED] = true;

        if ($type === BoundingBox::class) {
            return BoundingBox::fromJson($data);
        }

        if ($type === Coordinates::class) {
            return Coordinates::fromJson($data);
        }

        if (is_a($type, GeoJson::class, true)) {
            return Factory::fromJson($data);
        }

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        // Make sure we're not called twice
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $type === BoundingBox::class || $type === Coordinates::class || is_a($type, GeoJson::class, true);
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->denormalizer->getSupportedTypes($format);
    }
}
