<?php

namespace Differ\DiffMaker;

use function Differ\Parser\parse;
use function Differ\AST\genDiffAST;
use function Differ\Renderers\Json;

function genDiff($before, $after, $format)
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

    $ast = genDiffAST($beforeParsed, $afterParsed);

    switch ($format) {
        case 'json':
            return astToJson($ast);
        case 'text':
            return astToText($ast);
        default:
            return astToPlainDiff($ast);
    }
}


