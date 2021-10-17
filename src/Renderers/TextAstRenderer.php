<?php

namespace Differ\Renderers;

use Differ\Enums\AstKey;
use Differ\Enums\AstNodeType;
use Differ\Exceptions\RenderingException;

class TextAstRenderer extends AbstractAstRenderer
{
    public const NAME = 'text';

    /**
     * @throws RenderingException
     */
    private static function genTextDiff(array $ast, int $depth = 1): string
    {
        $indent = str_repeat('  ', $depth);
        $textDiff = array_map(static function ($item) use ($indent, $depth): string {
            $property = $item[AstKey::KEY];
            $valueBefore = array_key_exists(AstKey::VALUE_BEFORE, $item) ? static::prepareValue($item[AstKey::VALUE_BEFORE], $indent, $depth) : null;
            $valueAfter = array_key_exists(AstKey::VALUE_AFTER, $item) ? static::prepareValue($item[AstKey::VALUE_AFTER], $indent, $depth) : null;
            $children = $item[AstKey::CHILDREN] ?? null;

            return match ($item[AstKey::TYPE]) {
                AstNodeType::REMOVED => sprintf('%s- %s: %s', $indent, $property, $valueBefore),
                AstNodeType::ADDED => sprintf('%s+ %s: %s', $indent, $property, $valueAfter),
                AstNodeType::UNCHANGED => sprintf('%s  %s: %s', $indent, $property, $valueBefore),
                AstNodeType::CHANGED => sprintf('%s+ %s: %s', $indent, $property, $valueAfter) . PHP_EOL . sprintf('%s- %s: %s', $indent, $property, $valueBefore),
                AstNodeType::NESTED => sprintf('%s  %s: {%s%s  }', $indent, $property, PHP_EOL . self::genTextDiff($children, $depth + 2) . PHP_EOL, $indent),
                default => throw new RenderingException('Invalid AST node type'),
            };
        }, $ast);

        return implode(PHP_EOL, $textDiff);
    }

    private static function prepareValue(mixed $value, string $indent, int $depth): mixed
    {
        if (is_array($value)) {
            return self::toString($value, $depth + 2) . "{$indent}  }";
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return $value;
    }

    private static function toString(array $children, int $depth): string
    {
        $indent = str_repeat('  ', $depth);
        $keys = array_keys($children);

        $result = array_map(static function ($key) use ($children, $depth, $indent): string {
            if (is_array($children[$key])) {
                return self::toString($children[$key], $depth + 2);
            }
            return "{$indent}  {$key}: {$children[$key]}";
        }, $keys);

        return '{' . PHP_EOL . implode(PHP_EOL, $result) . PHP_EOL;
    }

    public static function render(array $ast): string
    {
        return '{' . PHP_EOL . self::genTextDiff($ast) . PHP_EOL . '}';
    }
}
