<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\OpenApi;

use ApiPlatform\JsonSchema\Schema;
use ApiPlatform\JsonSchema\SchemaFactoryInterface;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsDecorator('api_platform.json_schema.schema_factory', onInvalid: ContainerInterface::IGNORE_ON_INVALID_REFERENCE)]
final class SchemaFactory implements SchemaFactoryInterface
{
    public function __construct(
        private SchemaFactoryInterface $inner,
        private RefBuilderInterface $refBuilder,
        private iterable $resources,
        private iterable $formats,
    ) {}

    public function buildSchema(string $className, string $format = 'json', string $type = Schema::TYPE_OUTPUT, ?Operation $operation = null, ?Schema $schema = null, ?array $serializerContext = null, bool $forceCollection = false): Schema
    {
        $schema = $this->inner->buildSchema($className, $format, $type, $operation, $schema, $serializerContext, $forceCollection);

        return $this->overwriteGeoJsonComponents($format, $schema);
    }

    private function overwriteGeoJsonComponents(string $format, Schema $schema): Schema
    {
        $definitions = $schema->getDefinitions();
        $version = $schema->getVersion();

        foreach ($definitions as $name => $definition) {
            if (!isset($this->resources[$name])) {
                continue;
            }

            if ($this->nameMatchesFormat($name, $format)) {
                $resource = $this->refBuilder->build($this->resources[$name], $format, $version);
                $definitions[$name]->exchangeArray($resource);
            }
        }

        $schema->setDefinitions($definitions);

        return $schema;
    }

    private function nameMatchesFormat(string $name, string $format): bool
    {
        $regex = '/\.(' . implode('|', $this->formats) . ')$/';
        $baseName = preg_replace($regex, '', $name);

        return ($format === 'json' && $name === $baseName) || $name === "$baseName.$format";
    }
}
