<?php

namespace Tests\DifferTest;

use PHPUnit\Framework\TestCase;
use function Differ\DiffMaker\genDiff;

class DifferTest extends TestCase
{
    public function testPlainTextGenDiff()
    {
        $afterJson = "./tests/fixtures/flat/after.json";
        $beforeJson = "./tests/fixtures/flat/before.json";
        $afterYaml = "./tests/fixtures/flat/after.yaml";
        $beforeYaml = "./tests/fixtures/flat/before.yaml";
        $expected = "./tests/fixtures/flat/expected";

        $resultJson = genDiff($beforeJson, $afterJson, 'text');
        $resultYaml = genDiff($beforeYaml, $afterYaml, 'text');
        $expected = file_get_contents($expected);

        $this->assertEquals($expected, $resultJson);
        $this->assertEquals($expected, $resultYaml);
    }

    public function testNestedTextGenDiff()
    {
        $afterJson = "./tests/fixtures/nested/after.json";
        $beforeJson = "./tests/fixtures/nested/before.json";
        $afterYaml = "./tests/fixtures/nested/after.yaml";
        $beforeYaml = "./tests/fixtures/nested/before.yaml";
        $expected = "./tests/fixtures/nested/expected";

        $resultJson = genDiff($beforeJson, $afterJson, 'text');
        $resultYaml = genDiff($beforeYaml, $afterYaml, 'text');
        $expected = file_get_contents($expected);

        $this->assertEquals($expected, $resultJson);
        $this->assertEquals($expected, $resultYaml);
    }
}
