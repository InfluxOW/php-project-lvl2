<?php

namespace Differ\DiffMaker;

use PHPUnit\Framework\TestCase;

require_once "./src/DiffMaker.php";

class DifferTest extends TestCase
{
    public $after;
    public $before;
    public $expected;

    public function setUp(): void
    {
        $this->after = "./tests/fixtures/flat/after.json";
        $this->before = "./tests/fixtures/flat/before.json";
        $this->expected = "./tests/fixtures/flat/expected";
    }

    public function testGenDiff()
    {
        $result = genDiff($this->before, $this->after);
        $expected = file_get_contents($this->expected);
        $this->assertEquals($expected, $result);
    }
}