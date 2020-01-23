<?php

namespace Differ\DiffMaker;

use function Differ\Parser\parse;
use function Differ\AST\genDiffAst;
use function Differ\Renderers\Json\astToJson;
use function Differ\Renderers\Text\astToText;
use function Differ\Renderers\Plain\astToPlain;

function genDiff($before, $after, $format = 'plain')
{
    if (!file_exists($before) || !file_exists($after)) {
        throw new \Exception('One or more files are not exist.');
    }

    $beforeData = file_get_contents($before);
    $afterData = file_get_contents($after);

    $beforeFormat = pathinfo($before, PATHINFO_EXTENSION);
    $afterFormat = pathinfo($after, PATHINFO_EXTENSION);

    if ($beforeFormat !== $afterFormat) {
        throw new \Exception('Cannot compare files of two different formats.');
    }

    $beforeParsed = parse($beforeFormat, $beforeData);
    $afterParsed = parse($afterFormat, $afterData);

    $ast = genDiffAst($beforeParsed, $afterParsed);

    switch ($format) {
        case 'json':
            return astToJson($ast);
        case 'text':
            return astToText($ast);
        case 'plain':
            return astToPlain($ast);
    }
}
