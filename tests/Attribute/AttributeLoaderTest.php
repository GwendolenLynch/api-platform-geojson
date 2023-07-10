<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Attribute;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\Attribute\AttributeLoader;
use Camelot\GeoJSON\Resource\ResourceMap;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

/** @internal */
#[CoversClass(AttributeLoader::class)]
final class AttributeLoaderTest extends AttributeTestCase
{
    public static function providerLoad(): iterable
    {
        foreach (ResourceMap::RESOURCES as $resource => $class) {
            yield $resource => [$class];
        }
    }

    #[DataProvider('providerLoad')]
    public function testLoad(string $key): void
    {
        $loader = new AttributeLoader();
        $attributes = $loader->load(ResourceMap::RESOURCES);

        self::assertArrayHasKey($key, $attributes);
        self::assertInstanceOf(ApiComponent::class, $attributes[$key]);
    }
}
