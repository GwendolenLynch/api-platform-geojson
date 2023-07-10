<?php

declare(strict_types=1);

namespace Camelot\GeoJSON;

use Camelot\GeoJSON\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class GeoJsonBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new Compiler\SchemaFactoryPass());
        $container->addCompilerPass(new Compiler\OpenApiNormalizerPass());
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $services = $container->services();
        $services->defaults()
            ->autoconfigure()
            ->autowire()
        ;

        $services->set(OpenApi\SchemaFactory::class);

        $services->set(OpenApi\RefBuilder::class);
        $services->alias(OpenApi\RefBuilderInterface::class, OpenApi\RefBuilder::class);

        $services->set(Serializer\RefNormalizer::class);

        $services->set(Serializer\GeoJsonDenormalizer::class)
            ->tag('serializer.denormalizer', ['priority' => 64])
        ;
    }
}
