<?php

namespace Differ\Renderers\Text;

function isBool($value)
{
    return is_bool($value) ? ($value === true ? "true" : "false") : $value;
}

function getValue($value, $indent, $depth)
{
    if (is_array($value)) {
        return toString($value, $depth + 2)  . "{$indent}  }";
    }
    return isBool($value);
}

function toString($children, $depth)
{
    $indent = str_repeat('  ', $depth);
    $keys = array_keys($children);

    $result = array_map(function ($key) use ($children, $depth, $indent) {
        if (is_array($children[$key])) {
            return toString($children[$key], $depth + 2);
        }
        return "{$indent}  {$key}: {$children[$key]}";
    }, $keys);

    return "{\n" . implode("\n", $result) . "\n";
}

function genTextDiff($ast, $depth = 1)
{
    $indent = str_repeat('  ', $depth);
    $textDiff = array_map(function ($item) use ($indent, $depth) {
        switch ($item['type']) {
            case 'removed':
                return "{$indent}- {$item['key']}: " . getValue($item['valueBefore'], $indent, $depth);
            case 'added':
                return "{$indent}+ {$item['key']}: " . getValue($item['valueAfter'], $indent, $depth);
            case 'unchanged':
                return "{$indent}  {$item['key']}: " . getValue($item['valueBefore'], $indent, $depth);
            case 'changed':
                return "{$indent}+ {$item['key']}: " . getValue($item['valueAfter'], $indent, $depth) . "\n" .
                "{$indent}- {$item['key']}: " . getValue($item['valueBefore'], $indent, $depth);
            case 'nested':
                $children = genTextDiff($item['children'], $depth + 2);
                return "{$indent}  {$item['key']}: {" . "\n{$children}\n" . "{$indent}  }";
        }
    }, $ast);
    return implode("\n", $textDiff);
}

function astToTextDiff($ast)
{
    return "{\n" . genTextDiff($ast) . "\n}";
}
