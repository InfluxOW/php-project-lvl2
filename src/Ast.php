<?php

namespace Differ;

use Differ\Enums\AstKey;
use Differ\Enums\AstNodeType;

class Ast
{
    public static function genDiff(array $beforeData, array $afterData): array
    {
        $keys = array_unique(array_merge(array_keys($beforeData), array_keys($afterData)));

        return array_reduce($keys, static function ($acc, $key) use ($beforeData, $afterData): array {
            $valueBefore = $beforeData[$key] ?? null;
            $valueAfter = $afterData[$key] ?? null;

            if (!array_key_exists($key, $afterData)) {
                $acc[] = [AstKey::TYPE => AstNodeType::REMOVED, AstKey::KEY => $key, AstKey::VALUE_BEFORE => $valueBefore];
                return $acc;
            }

            if (!array_key_exists($key, $beforeData)) {
                $acc[] = [AstKey::TYPE => AstNodeType::ADDED, AstKey::KEY => $key, AstKey::VALUE_AFTER => $valueAfter];
                return $acc;
            }

            if (is_array($valueBefore) && is_array($valueAfter)) {
                $children = self::genDiff($valueBefore, $valueAfter);
                $acc[] = [
                    AstKey::TYPE => AstNodeType::NESTED,
                    AstKey::KEY => $key,
                    AstKey::VALUE_BEFORE => $valueBefore,
                    AstKey::VALUE_AFTER => $valueAfter,
                    AstKey::CHILDREN => $children
                ];
                return $acc;
            }

            if ($valueBefore === $valueAfter) {
                $acc[] = [AstKey::TYPE => AstNodeType::UNCHANGED, AstKey::KEY => $key, AstKey::VALUE_BEFORE => $valueBefore, AstKey::VALUE_AFTER => $valueAfter];
                return $acc;
            }

            $acc[] = [AstKey::TYPE => AstNodeType::CHANGED, AstKey::KEY => $key, AstKey::VALUE_BEFORE => $valueBefore, AstKey::VALUE_AFTER => $valueAfter];
            return $acc;
        }, []);
    }
}
