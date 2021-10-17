<?php

namespace Differ\Parsers;

use Differ\Exceptions\ParsingException;
use JsonException;

class JsonParser extends AbstractParser
{
    public const NAME = 'json';

    public static function parse(string $data): array
    {
        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ParsingException($e->getMessage());
        }
    }
}
