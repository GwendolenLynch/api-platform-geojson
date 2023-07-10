<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\DependencyInjection\Compiler;

use Camelot\GeoJSON\Serializer\RefNormalizer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class OpenApiNormalizerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('api_platform.openapi.normalizer')) {
            return;
        }

        $normalizer = $container->getDefinition('api_platform.openapi.normalizer');
        $args = $normalizer->getArguments();
        $serializer = $container->getDefinition((string) $args[0]);
        $args = $serializer->getArguments();

        $args[0] = array_merge([new Reference(RefNormalizer::class)], $args[0]);

        $serializer->setArguments($args);
    }
}
