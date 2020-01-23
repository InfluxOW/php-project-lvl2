<?php

namespace Differ\Ast;

function genDiffAst($beforeData, $afterData)
{
    // getting unique keys from both data arrays
    $keys = array_unique(array_merge(array_keys($beforeData), array_keys($afterData)));

    $result = array_reduce($keys, function ($acc, $key) use ($beforeData, $afterData) {
        $valueBefore = $beforeData[$key] ?? null;
        $valueAfter = $afterData[$key] ?? null;

        // value removed
        if (!array_key_exists($key, $afterData)) {
            $acc[] = ['type' => 'removed', 'key' => $key, 'valueBefore' => $valueBefore];
            return $acc;
        }
        // value added
        if (!array_key_exists($key, $beforeData)) {
            $acc[] = ['type' => 'added', 'key' => $key, 'valueAfter' => $valueAfter];
            return $acc;
        }
        // value has children
        if (is_array($valueBefore) && is_array($valueAfter)) {
            $children = genDiffAst($valueBefore, $valueAfter);
            $acc[] = ['type' => 'nested', 'key' => $key, 'valueBefore' => $valueBefore,
            'valueAfter' => $valueAfter, 'children' => $children];
            return $acc;
        }
        // value unchanged
        if ($valueBefore === $valueAfter) {
            $acc[] = ['type' => 'unchanged', 'key' => $key, 'valueBefore' => $valueBefore, 'valueAfter' => $valueAfter];
            return $acc;
        }
        // value changed
        if (array_key_exists($key, $beforeData) && array_key_exists($key, $afterData) && $valueBefore !== $valueAfter) {
            $acc[] = ['type' => 'changed', 'key' => $key, 'valueBefore' => $valueBefore, 'valueAfter' => $valueAfter];
            return $acc;
        }
    }, []);

    return $result;
}
