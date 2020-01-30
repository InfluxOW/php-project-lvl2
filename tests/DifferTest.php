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
        $fixtures = "./tests/fixtures/";
        $this->assertEquals(
            file_get_contents($fixtures . $expected),
            genDiff($fixtures . $before, $fixtures . $after, $format)
        );
    }

    public function additionProvider()
    {
        return [
            ["expectedText", "before.json", "after.json", "text"],
            ["expectedText", "before.yaml", "after.yaml", "text"],
            ["expectedPlain", "before.json", "after.json", "plain"],
            ["expectedPlain", "before.yaml", "after.yaml", "plain"],
            ["expectedJson", "before.json", "after.json", "json"],
            ["expectedJson", "before.yaml", "after.yaml", "json"]
        ];
    }
}
