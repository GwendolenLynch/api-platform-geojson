<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests;

use ApiPlatform\Symfony\Bundle\ApiPlatformBundle;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Camelot\GeoJSON\GeoJsonBundle;
use Camelot\GeoJSON\Type\BoundingBoxType;
use Camelot\GeoJSON\Type\CoordinatesType;
use Camelot\GeoJSON\Type\GeoJsonType;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/** @internal */
abstract class FunctionalTestCase extends ApiTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        $env = $options['environment'] ?? $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'test';
        $debug = (bool) ($options['debug'] ?? $_ENV['APP_DEBUG'] ?? $_SERVER['APP_DEBUG'] ?? true);

        return new class($env, $debug) extends Kernel {
            use MicroKernelTrait;

            public function registerBundles(): iterable
            {
                yield new FrameworkBundle();
                yield new DoctrineBundle();
                yield new ApiPlatformBundle();
                yield new GeoJsonBundle();
            }

            protected function prepareContainer(ContainerBuilder $container): void
            {
                parent::prepareContainer($container);

                $container->prependExtensionConfig('framework', ['test' => true]);

                $container->prependExtensionConfig('doctrine', [
                    'dbal' => [
                        'url' => 'sqlite:///%kernel.project_dir%/var/data.db',
                        'types' => [
                            'geojson' => GeoJsonType::class,
                            'bbox' => BoundingBoxType::class,
                            'coordinates' => CoordinatesType::class,
                        ],
                    ],
                    'orm' => [
                        'auto_generate_proxy_classes' => true,
                        'enable_lazy_ghost_objects' => true,
                        'report_fields_where_declared' => true,
                        'validate_xml_mapping' => true,
                        'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                        'auto_mapping' => true,
                        'mappings' => [
                            'GeoJSON' => [
                                'type' => 'attribute',
                                'is_bundle' => false,
                                'dir' => '%kernel.project_dir%/tests/Fixtures/Entity',
                                'prefix' => 'Camelot\GeoJSON\Tests\Fixtures\Entity',
                                'alias' => 'GeoJSON',
                            ],
                        ],
                    ],
                ]);

                $container->prependExtensionConfig('api_platform', [
                    'formats' => [
                        'jsonld' => ['application/ld+json'],
                    ],
                    'docs_formats' => [
                        'jsonld' => ['application/ld+json'],
                        'jsonopenapi' => ['application/vnd.openapi+json'],
                    ],
                    'defaults' => [
                        'stateless' => true,
                        'cache_headers' => [
                            'vary' => ['Content-Type', 'Authorization', 'Origin'],
                        ],
                        'extra_properties' => [
                            'standard_put' => true,
                            'rfc_7807_compliant_errors' => true,
                        ],
                    ],
                    'mapping' => [
                        'paths' => [
                            '%kernel.project_dir%/tests/Fixtures/Entity',
                        ],
                    ],
                    'resource_class_directories' => [
                        '%kernel.project_dir%/tests/Fixtures/Entity',
                    ],
                    'event_listeners_backward_compatibility_layer' => false,
                    'keep_legacy_inflector' => false,
                ]);
            }

            private function configureRoutes(RoutingConfigurator $routes): void
            {
                $routes->import('.', 'api_platform')->prefix('/');
            }
        };
    }
}
