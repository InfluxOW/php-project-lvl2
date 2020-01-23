<?php

namespace Differ\Ast;

function genDiffAst($beforeData, $afterData)
{   
    // getting unique keys from both data arrays
    $keys = array_unique(array_merge(array_keys($beforeData), array_keys($afterData)));

    $result = array_reduce($keys, function ($acc, $key) use ($beforeData, $afterData) {
        $beforeValue = $beforeData[$key] ?? null;
        $afterValue = $afterData[$key] ?? null;

        // value removed
        if (!array_key_exists($key, $afterData)) {
            $acc[] = ['type' => 'removed', 'key' => $key, 'beforeValue' => $beforeValue];
            return $acc;
        }
        // value added
        if (!array_key_exists($key, $beforeData)) {
            $acc[] = ['type' => 'added', 'key' => $key, 'afterValue' => $afterValue];
            return $acc;
        }
        // value has children
        if (is_array($beforeValue) && is_array($afterValue)) {
            $children = genDiffAst($beforeValue, $afterValue);
            $acc[] = ['type' => 'nested', 'key' => $key, 'beforeValue' => $beforeValue,
            'afterValue' => $afterValue, 'children' => $children];
            return $acc;
        }
        // value unchanged
        if ($beforeValue === $afterValue) {
            $acc[] = ['type' => 'unchanged', 'key' => $key, 'beforeValue' => $beforeValue, 'afterValue' => $afterValue];
            return $acc;
        }
        // value changed
        if (array_key_exists($key, $beforeData) && array_key_exists($key, $afterData) && $beforeValue !== $afterValue) {
            $acc[] = ['type' => 'changed', 'key' => $key, 'beforeValue' => $beforeValue, 'afterValue' => $afterValue];
            return $acc;
        }
    }, []);

    return $result;
}
