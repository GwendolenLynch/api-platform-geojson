<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\OpenApi;

use ApiPlatform\JsonSchema\Schema;
use Camelot\GeoJSON\Coordinates;
use Camelot\GeoJSON\OpenApi\Ref;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversClass(Ref::class)]
final class RefTest extends TestCase
{
    public static function provideReferencesCases(): iterable
    {
        yield 'OpenAPI JSON' => ['#/components/schemas/Coordinates', Coordinates::class, 'json', Schema::VERSION_OPENAPI];
        yield 'JSON Schema JSON' => ['#/definitions/Coordinates', Coordinates::class, 'json', Schema::VERSION_JSON_SCHEMA];
        yield 'Swagger JSON' => ['#/definitions/Coordinates', Coordinates::class, 'json', Schema::VERSION_SWAGGER];

        yield 'OpenAPI JSON-LD' => ['#/components/schemas/Coordinates.jsonld', Coordinates::class, 'jsonld', Schema::VERSION_OPENAPI];
        yield 'JSON Schema JSON-LD' => ['#/definitions/Coordinates.jsonld', Coordinates::class, 'jsonld', Schema::VERSION_JSON_SCHEMA];
        yield 'Swagger JSON-LD' => ['#/definitions/Coordinates.jsonld', Coordinates::class, 'jsonld', Schema::VERSION_SWAGGER];

        yield 'OpenAPI JSON:API' => ['#/components/schemas/Coordinates', Coordinates::class, 'jsonapi', Schema::VERSION_OPENAPI];
        yield 'JSON Schema JSON:API' => ['#/definitions/Coordinates', Coordinates::class, 'jsonapi', Schema::VERSION_JSON_SCHEMA];
        yield 'Swagger JSON:API' => ['#/definitions/Coordinates', Coordinates::class, 'jsonapi', Schema::VERSION_SWAGGER];
    }

    /** @dataProvider provideReferencesCases */
    public function testReferences(mixed $expected, string $ref, string $format, string $version): void
    {
        self::assertSame($expected, (string) new Ref($ref, $format, $version));
    }
}
