<?php

namespace Differ\DiffMaker;

function genDiff($pathToFile1, $pathToFile2)
{
    $decodedFile1 = decodeJsonFile($pathToFile1);
    $decodedFile2 = decodeJsonFile($pathToFile2);

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

function decodeJsonFile($pathToFile)
{
    $file = file_get_contents($pathToFile);
    $result = json_decode($file, true);
    return $result;
}

function isBool($value)
{
    return is_bool($value) ? ($value === true ? "true" : "false") : $value;
}
