<?php

namespace Differ\Parsers;

use Differ\Exceptions\ParsingException;

abstract class AbstractParser
{
    public const NAME = null;

    /**
     * @throws ParsingException
     */
    abstract public static function parse(string $data): array;
}
