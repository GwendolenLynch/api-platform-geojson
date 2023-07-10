<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\OpenApi;

final class RefBuilder implements RefBuilderInterface
{
    public function build(iterable $definition, string $format, string $version): iterable
    {
        foreach ($definition as $key => $value) {
            if (is_iterable($value)) {
                $definition[$key] = $this->build($value, $format, $version);

                continue;
            }

            if ($key === '$ref' && !$value instanceof Ref) {
                $definition[$key] = new Ref($value, $format, $version);
            }
        }

        return $definition;
    }
}
