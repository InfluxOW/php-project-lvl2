<?php

namespace Differ\Utils;

use Differ\Exceptions\IncorrectFileException;

use function Docopt\dump;

class FileUtils
{
    /**
     * @throws IncorrectFileException
     */
    public static function get(string $path): string
    {
        if (is_file($path)) {
            $file = file_get_contents($path);

            if (is_string($file)) {
                return $file;
            }
        }

        throw new IncorrectFileException($path);
    }
}
