<?php

namespace Differ\DiffMaker;

use function Differ\Parser\parse;

function genDiff($pathToFile1, $pathToFile2)
{
    if (!file_exists($pathToFile1) || !file_exists($pathToFile2)) {
        throw new \Exception('One or more files are not exist.');
    }

    $file1Content = file_get_contents($pathToFile1);
    $file2Content = file_get_contents($pathToFile2);

    $file1Format = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $file2Format = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    if ($file1Format !== $file2Format) {
        throw new \Exception('Cannot compare files of two different formats.');
    }

    $decodedFile1 = parse($file1Format, $file1Content);
    $decodedFile2 = parse($file2Format, $file2Content);

    $halfCompared = function () use ($decodedFile1, $decodedFile2) {
        foreach ($decodedFile1 as $key => $value) {
            if (array_key_exists($key, $decodedFile2)) {
                if ($decodedFile1[$key] === $decodedFile2[$key]) {
                    $result[] = "  $key: " . isBool($value);
                } else {
                    $result[] = "+ $key: " . isBool($value);
                    $result[] = "- $key: " . isBool($decodedFile2[$key]);
                }
            } else {
                $result[] = "+ $key: " . isBool($value);
            }
        }
        return $result;
    };

    $existOnlyInFile2 = function () use ($decodedFile1, $decodedFile2) {
        $result = [];
        $diff = array_diff_key($decodedFile2, $decodedFile1);
        foreach ($diff as $key => $value) {
            $result[] = "- $key: " . isBool($value);
        }
        return $result;
    };
    
    $compared = array_merge($halfCompared(), $existOnlyInFile2());
    $result = implode("\n", $compared);
    return "{\n{$result}\n}";
}

function isBool($value)
{
    return is_bool($value) ? ($value === true ? "true" : "false") : $value;
}
