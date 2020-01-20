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
        $this->after = "/home/influx/Projects/php-project-lvl2/tests/fixtures/flat/after.json";
        $this->before = "/home/influx/Projects/php-project-lvl2/tests/fixtures/flat/before.json";
        $this->expected = "/home/influx/Projects/php-project-lvl2/tests/fixtures/flat/expected";
    }

    public function testGenDiff()
    {
        $result = genDiff($this->before, $this->after);
        $this->assertEquals(file_get_contents($this->expected), $result);
    }
}