<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\OpenApi;

use ApiPlatform\JsonSchema\Schema;
use Camelot\GeoJSON\Attribute\AttributeBuilder;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\GeometryCollection;
use Camelot\GeoJSON\OpenApi\RefBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversClass(RefBuilder::class)]
final class RefBuilderTest extends TestCase
{
    public static function provideBuildDefinitions(): iterable
    {
        $attributes = (new AttributeBuilder())->build();

        yield 'Geometry - JSON - OpenAPI' => [
            [
                'type' => [
                    'type' => 'string',
                    'enum' => ['Feature', 'FeatureCollection', 'Point', 'MultiPoint', 'LineString', 'MultiLineString', 'Polygon', 'MultiPolygon', 'GeometryCollection'],
                    'readOnly' => true,
                ],
                'bbox' => [
                    'oneOf' => [
                        ['$ref' => '#/components/schemas/BoundingBox'],
                        ['type' => 'null'],
                    ],
                ],
            ],
            $attributes[Geometry::class],
            'json',
            Schema::VERSION_OPENAPI,
        ];

        yield 'Geometry - JSON-LD - JSON Schema' => [
            [
                'type' => [
                    'type' => 'string',
                    'enum' => ['Feature', 'FeatureCollection', 'Point', 'MultiPoint', 'LineString', 'MultiLineString', 'Polygon', 'MultiPolygon', 'GeometryCollection'],
                    'readOnly' => true,
                ],
                'bbox' => [
                    'oneOf' => [
                        ['$ref' => '#/definitions/BoundingBox.jsonld'],
                        ['type' => 'null'],
                    ],
                ],
            ],
            $attributes[Geometry::class],
            'jsonld',
            Schema::VERSION_JSON_SCHEMA,
        ];

        yield 'GeometryCollection - JSON - OpenAPI' => [
            [
                'type' => [
                    'type' => 'string',
                    'enum' => ['GeometryCollection'],
                    'readOnly' => true,
                ],
                'bbox' => [
                    'oneOf' => [
                        ['$ref' => '#/components/schemas/BoundingBox'],
                        ['type' => 'null'],
                    ],
                ],
                'geometries' => [
                    'type' => 'array',
                    'items' => [
                        'anyOf' => [
                            ['$ref' => '#/components/schemas/Feature'],
                            ['$ref' => '#/components/schemas/FeatureCollection'],
                            ['$ref' => '#/components/schemas/Point'],
                            ['$ref' => '#/components/schemas/MultiPoint'],
                            ['$ref' => '#/components/schemas/LineString'],
                            ['$ref' => '#/components/schemas/MultiLineString'],
                            ['$ref' => '#/components/schemas/Polygon'],
                            ['$ref' => '#/components/schemas/MultiPolygon'],
                            ['$ref' => '#/components/schemas/GeometryCollection'],
                        ],
                    ],
                ],
            ],
            $attributes[GeometryCollection::class],
            'json',
            Schema::VERSION_OPENAPI,
        ];

        yield 'GeometryCollection - JSON-LD - JSON Schema' => [
            [
                'type' => [
                    'type' => 'string',
                    'enum' => ['GeometryCollection'],
                    'readOnly' => true,
                ],
                'bbox' => [
                    'oneOf' => [
                        ['$ref' => '#/definitions/BoundingBox.jsonld'],
                        ['type' => 'null'],
                    ],
                ],
                'geometries' => [
                    'type' => 'array',
                    'items' => [
                        'anyOf' => [
                            ['$ref' => '#/definitions/Feature.jsonld'],
                            ['$ref' => '#/definitions/FeatureCollection.jsonld'],
                            ['$ref' => '#/definitions/Point.jsonld'],
                            ['$ref' => '#/definitions/MultiPoint.jsonld'],
                            ['$ref' => '#/definitions/LineString.jsonld'],
                            ['$ref' => '#/definitions/MultiLineString.jsonld'],
                            ['$ref' => '#/definitions/Polygon.jsonld'],
                            ['$ref' => '#/definitions/MultiPolygon.jsonld'],
                            ['$ref' => '#/definitions/GeometryCollection.jsonld'],
                        ],
                    ],
                ],
            ],
            $attributes[GeometryCollection::class],
            'jsonld',
            Schema::VERSION_JSON_SCHEMA,
        ];
    }

    #[DataProvider('provideBuildDefinitions')]
    public function testBuild(array $expected, iterable $definition, string $format, string $version): void
    {
        $builder = new RefBuilder();
        $result = $builder->build($definition, $format, $version);
        $properties = json_decode(json_encode($result['properties']), true);

        self::assertSame($expected, $properties);
    }
}
