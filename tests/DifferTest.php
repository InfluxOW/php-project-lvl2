<?php

namespace Tests\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\DiffMaker\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */

    public function testGenDiffWithDataSet($expected, $before, $after, $format)
    {
         $this->assertEquals(file_get_contents($expected), genDiff($before, $after, $format));
    }

    public function additionProvider()
    {
        return [
            ["./tests/fixtures/expectedText", "./tests/fixtures/before.json", "./tests/fixtures/after.json", "text"],
            ["./tests/fixtures/expectedText", "./tests/fixtures/before.yaml", "./tests/fixtures/after.yaml", "text"],
            ["./tests/fixtures/expectedPlain", "./tests/fixtures/before.json", "./tests/fixtures/after.json", "plain"],
            ["./tests/fixtures/expectedPlain", "./tests/fixtures/before.yaml", "./tests/fixtures/after.yaml", "plain"],
            ["./tests/fixtures/expectedJson", "./tests/fixtures/before.json", "./tests/fixtures/after.json", "json"],
            ["./tests/fixtures/expectedJson", "./tests/fixtures/before.yaml", "./tests/fixtures/after.yaml", "json"]
        ];
    }
}
