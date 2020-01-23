<?php

namespace Differ\DiffMaker;

use function Differ\Parser\parse;
use function Differ\AST\genDiffAst;
use function Differ\Renderers\Json\astToJsonDiff;
use function Differ\Renderers\Text\astToTextDiff;
use function Differ\Renderers\Plain\astToPlainDiff;

function genDiff($before, $after, $format = 'plain')
{
    if (!file_exists($before) || !file_exists($after)) {
        throw new \Exception('One or more files are not exist.');
    }

    $dataBefore = file_get_contents($before);
    $dataAfter = file_get_contents($after);

    $formatBefore = pathinfo($before, PATHINFO_EXTENSION);
    $formatAfter = pathinfo($after, PATHINFO_EXTENSION);

    if ($formatBefore !== $formatAfter) {
        throw new \Exception('Cannot compare files of two different formats.');
    }

    $parsedBefore = parse($formatBefore, $dataBefore);
    $parsedAfter = parse($formatAfter, $dataAfter);

    $ast = genDiffAst($parsedBefore, $parsedAfter);

    switch ($format) {
        case 'json':
            return astToJsonDiff($ast);
        case 'text':
            return astToTextDiff($ast);
        case 'plain':
            return astToPlainDiff($ast);
    }
}
