<?php

namespace Tests\DifferTest;

use PHPUnit\Framework\TestCase;
use function Differ\DiffMaker\genDiff;

class DifferTest extends TestCase
{
    public $afterJson;
    public $beforeJson;
    public $afterYaml;
    public $beforeYaml;
    public $expected;

    public function setUp(): void
    {
        $this->afterJson = "./tests/fixtures/flat/after.json";
        $this->beforeJson = "./tests/fixtures/flat/before.json";
        $this->afterYaml = "./tests/fixtures/flat/after.yaml";
        $this->beforeYaml = "./tests/fixtures/flat/before.yaml";
        $this->expected = "./tests/fixtures/flat/expected";
    }

    public function testGenDiffWork()
    {
        $resultJson = genDiff($this->beforeJson, $this->afterJson);
        // $resultYaml = genDiff($this->beforeYaml, $this->afterYaml);
        $expected = file_get_contents($this->expected);

        $this->assertEquals($expected, $resultJson);
        // $this->assertEquals($expected, $resultYaml);
    }
}
