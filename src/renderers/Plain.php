<?php

namespace Differ\Renderers\Plain;

use function Differ\Renderers\Text\isBool;

function getValue($value)
{
    if (is_array($value)) {
        return 'complex value';
    }
    return isBool($value);
}

function astToPlainDiff($ast, $path = '')
{
    $plainDiff = array_reduce($ast, function ($acc, $item) use ($path) {
        switch ($item['type']) {
            case 'removed':
                $acc[] = "Property '{$path}{$item['key']}' was removed.";
                break;
            case 'added':
                $acc[] = "Property '{$path}{$item['key']}' was added with value '" .
                getValue($item['valueAfter']) . "'.";
                break;
            case 'changed':
                $acc[] = "Property '{$path}{$item['key']}' was changed from '" . getValue($item['valueBefore']) .
                "' to '" . getValue($item['valueAfter']) . "'.";
                break;
            case 'nested':
                $acc[] = astToPlainDiff($item['children'], "{$path}{$item['key']}.");
                break;
        }
        return $acc;
    }, []);
    return implode("\n", $plainDiff);
}
