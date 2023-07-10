<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Attribute;

use Camelot\GeoJSON\Attribute\ApiComponent;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Camelot\GeoJSON\Attribute\ApiComponent
 *
 * @internal
 */
final class ApiComponentTest extends TestCase
{
    public static function providerClones(): iterable
    {
        yield ['type', 'array'];
        yield ['ref', '#/components/schemas/BoundingBox'];
        yield ['description', 'An array of numbers'];
        yield ['deprecated', true];
        yield ['properties', ['type' => [], 'bbox' => []]];
        yield ['required', ['type']];
        yield ['items', ['type' => 'number']];
        yield ['minItems', 24];
        yield ['maxItems', 42];
        yield ['oneOf', ['$ref' => '#/components/schemas/BoundingBox']];
        yield ['allOf', ['$ref' => '#/components/schemas/BoundingBox']];
        yield ['anyOf', ['$ref' => '#/components/schemas/BoundingBox']];
        yield ['externalDocs', ['url' => 'https://localhost']];
        yield ['example', 'An example'];
    }

    #[DataProvider('providerClones')]
    public function testWithClones(string $property, mixed $value): void
    {
        $getter = 'get' . ucfirst($property);
        $setter = 'with' . ucfirst($property);
        $attribute = new ApiComponent(...[$property => $value]);
        $clone = $attribute->{$setter}($value);

        self::assertNotSame($attribute, $clone);
        self::assertSame($value, $clone->{$getter}());

        $clone = $attribute->{$setter}(null);
        self::assertNull($clone->{$getter}());

        $clone = $attribute->{$setter}($value);
        self::assertSame($value, $clone->{$getter}());
    }

    public function testToArray(): void
    {
        $array = [
            'type' => 'array',
            'ref' => '#/components/schemas/BoundingBox',
            'description' => 'An array of numbers',
            'deprecated' => true,
            'properties' => ['type' => [], 'bbox' => []],
            'required' => ['type'],
            'items' => ['type' => 'number'],
            'minItems' => 24,
            'maxItems' => 42,
            'oneOf' => ['$ref' => '#/components/schemas/BoundingBox'],
            'allOf' => ['$ref' => '#/components/schemas/BoundingBox'],
            'anyOf' => ['$ref' => '#/components/schemas/BoundingBox'],
            'externalDocs' => ['url' => 'https://localhost'],
            'example' => 'An example',
        ];
        $attribute = new ApiComponent(...$array);

        self::assertEqualsCanonicalizing($array, $attribute->toArray());
    }

    public function testWithMergedAttribute(): void
    {
        $attribute1 = new ApiComponent(type: 'object');
        $attribute2 = new ApiComponent(type: 'object', description: 'A description');
        $attribute3 = $attribute1->withMergedAttribute($attribute2);

        self::assertNotSame($attribute1, $attribute3);
        self::assertNotSame($attribute2, $attribute3);

        self::assertSame('object', $attribute3->getType());
        self::assertSame('A description', $attribute3->getDescription());
    }
}
