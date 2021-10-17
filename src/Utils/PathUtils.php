<?php

namespace Differ\Utils;

class PathUtils
{
    public static function getExtension(string $filepath): string
    {
        return pathinfo($filepath, PATHINFO_EXTENSION);
    }

    /**
     * @param string ...$parts
     */
    public static function join(...$parts): string
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}
