<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\DependencyInjection;

use Camelot\GeoJSON\DependencyInjection\Compiler\SchemaFactoryPass;
use Camelot\GeoJSON\OpenApi\SchemaFactory;
use Camelot\GeoJSON\Resource\ResourceMap;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/** @internal */
#[CoversClass(SchemaFactoryPass::class)]
final class SchemaFactoryPassTest extends TestCase
{
    public function testProcess(): void
    {
        $container = new ContainerBuilder();
        $container->setDefinition(SchemaFactory::class, (new Definition(SchemaFactory::class))->setAutoconfigured(true)->setAutowired(true));

        $pass = new SchemaFactoryPass();
        $pass->process($container);

        self::assertTrue($container->hasDefinition(SchemaFactory::class));

        $definition = $container->getDefinition(SchemaFactory::class);
        $argument = $definition->getArgument('$resources');

        self::assertCount(14, $argument);
        foreach (ResourceMap::RESOURCES as $resource => $class) {
            self::assertArrayHasKey($resource, $argument);
        }
    }
}
