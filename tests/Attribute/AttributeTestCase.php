<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Attribute;

use Camelot\GeoJSON\Attribute\ApiComponent;
use PHPUnit\Framework\TestCase;

abstract class AttributeTestCase extends TestCase
{
    public static function assertAttributeMatches(ApiComponent|array $expected, ApiComponent $attribute): void
    {
        $expected = \is_array($expected) ? $expected : self::castAttributeToArray($expected);
        $attribute = self::castAttributeToArray($attribute);

        self::assertEqualsCanonicalizing($expected, $attribute);
    }

    private static function castAttributeToArray(ApiComponent $attribute): array
    {
        $array = [];
        $rc = new \ReflectionClass($attribute);
        foreach ($rc->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($attribute);
        }

        return $array;
    }
}
