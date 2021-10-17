<?php

namespace Differ\Parsers;

use Differ\Exceptions\ParsingException;

class Parser
{
    /**
     * @throws ParsingException
     */
    public static function parse(string $format, string $data): array
    {
        return match ($format) {
            JsonParser::NAME => JsonParser::parse($data),
            YamlParser::NAME => YamlParser::parse($data),
            default => throw new ParsingException('Invalid parser'),
        };
    }
}
