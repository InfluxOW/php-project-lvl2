<?php

namespace Tests\DifferTest;

use Differ\DiffMaker;
use Differ\Renderers\JsonAstRenderer;
use Differ\Renderers\PlainAstRenderer;
use Differ\Renderers\TextAstRenderer;
use Differ\Utils\PathUtils;
use PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    /**
     * @dataProvider genDiffDataProvider
     */
    public function testGenDiffWithDataSet(string $expectedFilename, string $beforeFilename, string $afterFilename, string $format): void
    {
        /** @var string $fixturesPath */
        $fixturesPath = realpath(PathUtils::join(__DIR__, 'fixtures'));
        $this->assertStringEqualsFile(
            PathUtils::join($fixturesPath, $expectedFilename),
            DiffMaker::genDiff(PathUtils::join($fixturesPath, $beforeFilename), PathUtils::join($fixturesPath, $afterFilename), $format)
        );
    }

    public function genDiffDataProvider(): array
    {
        return [
            ['expectedText', 'before.json', 'after.json', TextAstRenderer::NAME],
            ['expectedText', 'before.yaml', 'after.yaml', TextAstRenderer::NAME],
            ['expectedPlain', 'before.json', 'after.json', PlainAstRenderer::NAME],
            ['expectedPlain', 'before.yaml', 'after.yaml', PlainAstRenderer::NAME],
            ['expectedJson', 'before.json', 'after.json', JsonAstRenderer::NAME],
            ['expectedJson', 'before.yaml', 'after.yaml', JsonAstRenderer::NAME]
        ];
    }
}
