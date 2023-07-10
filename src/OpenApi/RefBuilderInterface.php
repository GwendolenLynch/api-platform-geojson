<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\OpenApi;

interface RefBuilderInterface
{
    public function build(iterable $definition, string $format, string $version): iterable;
}
