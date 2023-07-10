<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Resource;

use Camelot\GeoJSON\Attribute\ApiComponent;
use Camelot\GeoJSON\Attribute\AttributeLoader;
use Camelot\GeoJSON\Geometry;
use Camelot\GeoJSON\Geometry\Position;
use Camelot\GeoJSON\Resource\InheritanceResolver;
use Camelot\GeoJSON\Resource\ResourceMap;
use Camelot\GeoJSON\Tests\Attribute\AttributeTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

/** @internal */
#[CoversClass(InheritanceResolver::class)]
final class InheritanceResolverTest extends AttributeTestCase
{
    public static function provideResolveCases(): iterable
    {
        yield 'Geometry' => [Geometry::class, ['type', 'bbox'], ['type']];
        yield 'Position' => [Position::class, ['type', 'bbox', 'coordinates'], ['type', 'coordinates']];
    }

    /** @dataProvider provideResolveCases */
    public function testResolve(string $key, array $propertyKeys, array $required): void
    {
        $loader = new AttributeLoader();
        $inheritance = new InheritanceResolver();
        $attributes = $inheritance->resolve($loader->load(ResourceMap::RESOURCES));
        /** @var ApiComponent $attribute */
        $attribute = $attributes[$key];

        self::assertEqualsCanonicalizing($required, $attribute->getRequired());
        self::assertEqualsCanonicalizing($propertyKeys, array_keys($attribute->getProperties()));
    }
}
