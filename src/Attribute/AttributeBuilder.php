<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Attribute;

use Camelot\GeoJSON\Resource\InheritanceResolver;
use Camelot\GeoJSON\Resource\ResourceMap;

final class AttributeBuilder
{
    public function build(): array
    {
        $loader = new AttributeLoader();
        $inheritance = new InheritanceResolver();
        $attributes = $inheritance->resolve($loader->load(ResourceMap::RESOURCES));

        return array_map(static fn (ApiComponent $attribute) => $attribute->toArray(), $attributes);
    }
}
