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
                    $result[] = "  $key: $value";
                } else {
                    $result[] = "+ $key: $value";
                    $result[] = "- $key: $decodedFile2[$key]";
                }
            } else {
                $result[] = "+ $key: $value";
            }
        }
        return $result;
    };

    $existOnlyInFile2 = function () use ($decodedFile1, $decodedFile2) {
        $result = [];
        $diff = array_diff_key($decodedFile2, $decodedFile1);
        foreach ($diff as $key => $value) {
            $result[] = "- $key: $value";
        }
        return $result;
    };
    
    $compared = array_merge($halfCompared(), $existOnlyInFile2());
    return implode("\n", $compared);
}

function decodeJsonFile($pathToFile)
{
    $file = file_get_contents($pathToFile);
    $result = json_decode($file, true);
    asort($result);
    return $result;
}
