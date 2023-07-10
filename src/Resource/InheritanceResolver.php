<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Resource;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class InheritanceResolver
{
    public function resolve(array $attributes): array
    {
        $container = new ContainerBuilder();
        $resolved = new \ArrayObject($attributes);

        $interfaces = array_filter(
            $attributes,
            static fn (string $className) => $container->getReflectionClass($className)?->isInterface(),
            ARRAY_FILTER_USE_KEY,
        );

        $concretes = array_filter(
            $attributes,
            static fn (string $className) => !$container->getReflectionClass($className)?->isInterface(),
            ARRAY_FILTER_USE_KEY,
        );

        $this->mergeParents($container, $interfaces, $resolved);
        $this->mergeParents($container, $concretes, $resolved);

        return $resolved->getArrayCopy();
    }

    private function mergeParents(ContainerBuilder $container, array $subset, \ArrayObject $attributes): void
    {
        foreach ($subset as $className => $attribute) {
            /** @var \ReflectionClass $class - method throws an exception if not found */
            $class = $container->getReflectionClass($className);
            foreach ($class->getInterfaceNames() as $interfaceName) {
                if (!($attributes[$interfaceName] ?? false)) {
                    continue;
                }
                /** @var ApiComponent $interface */
                $interface = $attributes[$interfaceName];
                $className = $class->getName();
                $attributes[$className] = $interface->withMergedAttribute($attributes[$className]);
            }
        }
    }
}
