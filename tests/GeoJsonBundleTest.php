<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use Camelot\GeoJSON\DependencyInjection\Compiler\SchemaFactoryPass;
use Camelot\GeoJSON\GeoJsonBundle;
use Camelot\GeoJSON\OpenApi\SchemaFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;

/** @internal */
#[CoversClass(GeoJsonBundle::class)]
final class GeoJsonBundleTest extends FunctionalTestCase
{
    public function testBuild(): void
    {
        $container = new ContainerBuilder();
        $bundle = new GeoJsonBundle();
        $bundle->build($container);

        $passes = $container->getCompilerPassConfig()->getBeforeOptimizationPasses();
        $passes = array_filter($passes, static fn (CompilerPassInterface $pass) => $pass::class === SchemaFactoryPass::class);

        self::assertCount(1, $passes);
    }

    public function testLoadExtension(): void
    {
        // Force the container to rebuild during test runs
        $fs = new Filesystem();
        $fs->remove(__DIR__ . '/../var/cache/test');

        self::assertInstanceOf(SchemaFactory::class, self::getContainer()->get(SchemaFactory::class));
    }
}
