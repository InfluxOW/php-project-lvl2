<?php

namespace Differ\Renderers;

use Differ\Enums\AstKey;
use Differ\Enums\AstNodeType;
use Differ\Exceptions\RenderingException;

class PlainAstRenderer extends AbstractAstRenderer
{
    public const NAME = 'plain';

    public static function render(array $ast, string $path = ''): string
    {
        $plainDiff = array_reduce($ast, static function ($acc, $item) use ($path) {
            $property = "{$path}{$item[AstKey::KEY]}";
            $valueBefore = array_key_exists(AstKey::VALUE_BEFORE, $item) ? self::prepareValue($item[AstKey::VALUE_BEFORE]) : null;
            $valueAfter = array_key_exists(AstKey::VALUE_AFTER, $item) ? self::prepareValue($item[AstKey::VALUE_AFTER]) : null;
            $children = $item[AstKey::CHILDREN] ?? null;

            $acc[] = match ($item[AstKey::TYPE]) {
                AstNodeType::REMOVED => sprintf('Property \'%s\' was removed.', $property),
                AstNodeType::ADDED => sprintf('Property \'%s\' was added with value \'%s\'.', $property, $valueAfter),
                AstNodeType::CHANGED => sprintf('Property \'%s\' was changed from \'%s\' to \'%s\'.', $property, $valueBefore, $valueAfter),
                AstNodeType::NESTED => self::render($children, "{$property}."),
                AstNodeType::UNCHANGED => null,
                default => throw new RenderingException('Unknown AST node type'),
            };

            return $acc;
        }, []);

        return implode(PHP_EOL, array_filter($plainDiff));
    }

    private static function prepareValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return 'complex value';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return $value;
    }
}
