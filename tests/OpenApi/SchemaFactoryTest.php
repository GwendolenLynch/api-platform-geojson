<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\OpenApi;

use ApiPlatform\JsonSchema\Schema;
use Camelot\GeoJSON\OpenApi\Ref;
use Camelot\GeoJSON\OpenApi\SchemaFactory;
use Camelot\GeoJSON\Resource\ResourceMap;
use Camelot\GeoJSON\Tests\Fixtures\Fixtures;
use Camelot\GeoJSON\Tests\FunctionalTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

/** @internal */
#[CoversClass(SchemaFactory::class)]
final class SchemaFactoryTest extends FunctionalTestCase
{
    public static function providerBuildSchema(): iterable
    {
        foreach (ResourceMap::RESOURCES as $resource => $class) {
            yield $resource => [$class, include Fixtures::getPathname("schema/{$resource}.php")];
        }
    }

    #[DataProvider('providerBuildSchema')]
    public function testBuildSchema(string $class, array $expected): void
    {
        $container = self::getContainer();
        $schemaFactory = $container->get('api_platform.json_schema.schema_factory');
        $schema = $schemaFactory->buildSchema($class, schema: new Schema(Schema::VERSION_OPENAPI))->getArrayCopy();
        $schema = json_decode(json_encode($schema), true);

        self::assertEqualsCanonicalizing($expected, $schema);
    }

    public function testBuildSchemas(): void
    {
        $container = self::getContainer();
        $schemaFactory = $container->get('api_platform.json_schema.schema_factory');
        $schemas = new Schema();
        foreach (ResourceMap::RESOURCES as $resource => $class) {
            $schema = $schemaFactory->buildSchema($class, schema: new Schema(Schema::VERSION_OPENAPI));
            $schema = \is_array($schema) ? new \ArrayObject($schema) : $schema;
            if ($schemas->getVersion() === Schema::VERSION_OPENAPI) {
                $schemas['components']['schemas'][$resource] = $schema;
            } else {
                $schemas['definitions'][$resource] = $schema;
            }
        }
        $schemas = json_decode(json_encode($schemas), true);
        $expected = require Fixtures::getPathname('schema/All.php');

        self::assertEqualsCanonicalizing($expected, $schemas);
    }

    public function testBuildSchemasMultipleFormats(): void
    {
        $container = self::getContainer();
        $schemaFactory = $container->get('api_platform.json_schema.schema_factory');
        $schemas = new Schema('openapi');

        foreach (ResourceMap::RESOURCES as $class) {
            $schema = new Schema('openapi');
            $schema->setDefinitions($schemas);

            foreach (['json', 'jsonld'] as $format) {
                $operationOutputSchema = $schemaFactory->buildSchema($class, $format, Schema::TYPE_OUTPUT, null, $schema);
                $operationOutputSchemas[$format] = $operationOutputSchema;
            }
        }

        $refJsonLd = $schemas['MultiPolygon.jsonld']['properties']['bbox']['oneOf'][0]['$ref'] ?? null;
        self::assertInstanceOf(Ref::class, $refJsonLd);
        self::assertSame('jsonld', $refJsonLd->getFormat());

        $refJson = $schemas['MultiPolygon']['properties']['bbox']['oneOf'][0]['$ref'] ?? null;
        self::assertInstanceOf(Ref::class, $refJson);
        self::assertSame('json', $refJson->getFormat());
    }
}
