<?php

namespace Tests\DifferTest;

use PHPUnit\Framework\TestCase;
use function Differ\DiffMaker\genDiff;

class DifferTest extends TestCase
{
    public function testFlatGenDiff()
    {
        $afterJson = "./tests/fixtures/flat/after.json";
        $beforeJson = "./tests/fixtures/flat/before.json";
        $afterYaml = "./tests/fixtures/flat/after.yaml";
        $beforeYaml = "./tests/fixtures/flat/before.yaml";
        $expectedText = "./tests/fixtures/flat/expectedText";
        $expectedPlain = "./tests/fixtures/flat/expectedPlain";

        $resultJsonText = genDiff($beforeJson, $afterJson, 'text');
        $resultYamlText = genDiff($beforeYaml, $afterYaml, 'text');
        $expectedText = file_get_contents($expectedText);
        $this->assertEquals($expectedText, $resultJsonText);
        $this->assertEquals($expectedText, $resultYamlText);

        $resultJsonPlain = genDiff($beforeJson, $afterJson, 'plain');
        $resultYamlPlain = genDiff($beforeYaml, $afterYaml, 'plain');
        $expectedPlain = file_get_contents($expectedPlain);
        $this->assertEquals($expectedPlain, $resultJsonPlain);
        $this->assertEquals($expectedPlain, $resultJsonPlain);
    }

    public function testNestedGenDiff()
    {
        $afterJson = "./tests/fixtures/nested/after.json";
        $beforeJson = "./tests/fixtures/nested/before.json";
        $afterYaml = "./tests/fixtures/nested/after.yaml";
        $beforeYaml = "./tests/fixtures/nested/before.yaml";
        $expectedText = "./tests/fixtures/nested/expectedText";
        $expectedPlain = "./tests/fixtures/nested/expectedPlain";

        $resultJsonText = genDiff($beforeJson, $afterJson, 'text');
        $resultYamlText = genDiff($beforeYaml, $afterYaml, 'text');
        $expectedText = file_get_contents($expectedText);

        $this->assertEquals($expectedText, $resultJsonText);
        $this->assertEquals($expectedText, $resultYamlText);

        $resultJsonPlain = genDiff($beforeJson, $afterJson, 'plain');
        $resultYamlPlain = genDiff($beforeYaml, $afterYaml, 'plain');
        $expectedPlain = file_get_contents($expectedPlain);

        $this->assertEquals($expectedPlain, $resultJsonPlain);
        $this->assertEquals($expectedPlain, $resultYamlPlain);
    }
}
