<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

class YamlParser extends AbstractParser
{
    public const NAME = 'yaml';

    public static function parse(string $data): array
    {
        return Yaml::parse($data);
    }
}
