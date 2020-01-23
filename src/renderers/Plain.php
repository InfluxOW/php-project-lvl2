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
        $before = array_key_exists('valueBefore', $item) ? getValue($item['valueBefore']) : null;
        $after = array_key_exists('valueAfter', $item) ? getValue($item['valueAfter']) : null;
        
        switch ($item['type']) {
            case 'removed':
                $acc[] = "Property '{$path}{$item['key']}' was removed.";
                break;
            case 'added':
                $acc[] = "Property '{$path}{$item['key']}' was added with value '$after'.";
                break;
            case 'changed':
                $acc[] = "Property '{$path}{$item['key']}' was changed from '$before' to '$after'.";
                break;
            case 'nested':
                $acc[] = astToPlainDiff($item['children'], "{$path}{$item['key']}.");
                break;
        }
        return $acc;
    }, []);
    return implode("\n", $plainDiff);
}
