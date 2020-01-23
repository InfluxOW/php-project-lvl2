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

function astToPlain($ast, $path = '')
{
    $plainDiff = array_reduce($ast, function ($acc, $item) use ($path) {
        $before = array_key_exists('beforeValue', $item) ? getValue($item['beforeValue']) : null;
        $after = array_key_exists('afterValue', $item) ? getValue($item['afterValue']) : null;
        
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
                $acc[] = astToPlain($item['children'], "{$path}{$item['key']}.");
                break;
        }
        return $acc;
    }, []);
    return implode("\n", $plainDiff);
}
