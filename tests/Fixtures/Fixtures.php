<?php

declare(strict_types=1);

namespace Camelot\GeoJSON\Tests\Fixtures;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

/** @internal */
final class Fixtures
{
    public static function getPathname(string $relativePathname): string
    {
        $fs = new Filesystem();
        $path = Path::join(__DIR__, $relativePathname);
        if (!$fs->exists($path)) {
            throw new \InvalidArgumentException(sprintf('Fixture file %s does not exist', $relativePathname));
        }

        return $path;
    }

    public static function readFile(string $relativePathname): string
    {
        return file_get_contents(self::getPathname($relativePathname));
    }

    public static function readJSON(string $relativePathname): array
    {
        return json_decode(self::readFile($relativePathname), true, 512, JSON_THROW_ON_ERROR);
    }
}
