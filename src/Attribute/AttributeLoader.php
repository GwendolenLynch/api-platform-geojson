<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Attribute;

use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AttributeLoader
{
    public function load(array $classNames): array
    {
        $attributes = [];
        foreach ($classNames as $className) {
            $attributes[$className] = $this->getAttribute($className);
        }

        return array_filter($attributes);
    }

    private function getAttribute(string $className): ?ApiComponent
    {
        $container = new ContainerBuilder();
        /** @var \ReflectionClass $class - method throws a ReflectionException if not found */
        $class = $container->getReflectionClass($className);
        $attributes = $class->getAttributes(ApiComponent::class);

        return array_shift($attributes)?->newInstance();
    }
}
