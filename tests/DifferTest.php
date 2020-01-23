<?php

namespace Tests\DifferTest;

use PHPUnit\Framework\TestCase;
use function Differ\DiffMaker\genDiff;

class DifferTest extends TestCase
{
    public function testFlatGenDiff()
    {
        // flat diff tests
        $afterJson = "./tests/fixtures/flat/after.json";
        $beforeJson = "./tests/fixtures/flat/before.json";
        $afterYaml = "./tests/fixtures/flat/after.yaml";
        $beforeYaml = "./tests/fixtures/flat/before.yaml";
        $expectedText = "./tests/fixtures/flat/expectedText";
        $expectedPlain = "./tests/fixtures/flat/expectedPlain";
        $expectedJson = "./tests/fixtures/flat/expectedJson";
        // text format test
        $resultJsonText = genDiff($beforeJson, $afterJson, 'text');
        $resultYamlText = genDiff($beforeYaml, $afterYaml, 'text');
        $expectedText = file_get_contents($expectedText);

        $this->assertEquals($expectedText, $resultJsonText);
        $this->assertEquals($expectedText, $resultYamlText);
        // plain format test
        $resultJsonPlain = genDiff($beforeJson, $afterJson, 'plain');
        $resultYamlPlain = genDiff($beforeYaml, $afterYaml, 'plain');
        $expectedPlain = file_get_contents($expectedPlain);

        $this->assertEquals($expectedPlain, $resultJsonPlain);
        $this->assertEquals($expectedPlain, $resultYamlPlain);
        // json format test
        $resultJsonJson = genDiff($beforeJson, $afterJson, 'json');
        $resultYamlJson = genDiff($beforeYaml, $afterYaml, 'json');
        $expectedJson = file_get_contents($expectedJson);

        $this->assertEquals($expectedJson, $resultJsonJson);
        $this->assertEquals($expectedJson, $resultYamlJson);
    }

    public function testNestedGenDiff()
    {
        // nested diff tests
        $afterJson = "./tests/fixtures/nested/after.json";
        $beforeJson = "./tests/fixtures/nested/before.json";
        $afterYaml = "./tests/fixtures/nested/after.yaml";
        $beforeYaml = "./tests/fixtures/nested/before.yaml";
        $expectedText = "./tests/fixtures/nested/expectedText";
        $expectedPlain = "./tests/fixtures/nested/expectedPlain";
        $expectedJson = "./tests/fixtures/nested/expectedJson";
        // text diff test
        $resultJsonText = genDiff($beforeJson, $afterJson, 'text');
        $resultYamlText = genDiff($beforeYaml, $afterYaml, 'text');
        $expectedText = file_get_contents($expectedText);

        $this->assertEquals($expectedText, $resultJsonText);
        $this->assertEquals($expectedText, $resultYamlText);
        // plain diff test
        $resultJsonPlain = genDiff($beforeJson, $afterJson, 'plain');
        $resultYamlPlain = genDiff($beforeYaml, $afterYaml, 'plain');
        $expectedPlain = file_get_contents($expectedPlain);

        $this->assertEquals($expectedPlain, $resultJsonPlain);
        $this->assertEquals($expectedPlain, $resultYamlPlain);
        // json diff test
        $resultJsonJson = genDiff($beforeJson, $afterJson, 'json');
        $resultYamlJson = genDiff($beforeYaml, $afterYaml, 'json');
        $expectedJson = file_get_contents($expectedJson);

        $this->assertEquals($expectedJson, $resultJsonJson);
        $this->assertEquals($expectedJson, $resultYamlJson);
    }
}
