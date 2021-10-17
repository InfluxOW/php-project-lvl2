<?php

namespace Differ;

use Differ\Exceptions\ComparisonException;
use Differ\Parsers\Parser;
use Differ\Renderers\PlainAstRenderer;
use Differ\Renderers\Renderer;
use Differ\Utils\FileUtils;
use Differ\Utils\PathUtils;
use Differ\Exceptions\DifferException;

class DiffMaker
{
    /**
     * @throws DifferException
     */
    public static function genDiff(string $filepathBefore, string $filepathAfter, string $format = PlainAstRenderer::NAME): string
    {
        $dataBefore = FileUtils::get($filepathBefore);
        $dataAfter = FileUtils::get($filepathAfter);

        $formatBefore = PathUtils::getExtension($filepathBefore);
        $formatAfter = PathUtils::getExtension($filepathAfter);

        if ($formatBefore !== $formatAfter) {
            throw new ComparisonException('Cannot compare files of two different formats.');
        }

        $parsedBefore = Parser::parse($formatBefore, $dataBefore);
        $parsedAfter = Parser::parse($formatAfter, $dataAfter);

        $ast = Ast::genDiff($parsedBefore, $parsedAfter);

        return Renderer::render($format, $ast);
    }
}
