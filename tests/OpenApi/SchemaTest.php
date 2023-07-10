<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\OpenApi;

use Camelot\GeoJSON\Tests\Fixtures\Entity\Squirrel;
use Camelot\GeoJSON\Tests\FunctionalTestCase;

/**
 * @internal
 */
final class SchemaTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testGetCollection(): void
    {
        self::createClient()->request('GET', '/squirrels');

        self::assertResponseIsSuccessful();
        self::assertMatchesResourceCollectionJsonSchema(Squirrel::class);
    }

    public function testGetItem(): void
    {
        self::createClient()->request('GET', '/squirrels/1');

        self::assertResponseIsSuccessful();
        self::assertMatchesResourceItemJsonSchema(Squirrel::class);
    }
}
