<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\DependencyInjection\Compiler;

use Camelot\GeoJSON\Attribute\AttributeBuilder;
use Camelot\GeoJSON\OpenApi\SchemaFactory;
use Camelot\GeoJSON\Resource\ResourceMap;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SchemaFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        [$apiConfig] = $container->getExtensionConfig('api_platform');
        $formats = array_keys($apiConfig['formats'] ?? []);
        $attributes = (new AttributeBuilder())->build();
        $resources = [];

        foreach (ResourceMap::RESOURCES as $resource => $class) {
            $resources[$resource] = $attributes[$class];
            foreach ($formats as $format) {
                if ($format !== 'json') {
                    $resources["{$resource}.{$format}"] = $attributes[$class];
                }
            }
        }

        if ($container->hasDefinition(SchemaFactory::class)) {
            $container->getDefinition(SchemaFactory::class)
                ->setArgument('$resources', $resources)
                ->setArgument('$formats', $formats)
            ;
        }
    }
}
