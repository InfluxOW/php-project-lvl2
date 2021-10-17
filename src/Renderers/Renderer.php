<?php

namespace Differ\Renderers;

use Differ\Exceptions\RenderingException;

class Renderer
{
    /**
     * @throws RenderingException
     */
    public static function render(string $format, array $ast): string
    {
        return match ($format) {
            JsonAstRenderer::NAME => JsonAstRenderer::render($ast),
            PlainAstRenderer::NAME => PlainAstRenderer::render($ast),
            TextAstRenderer::NAME => TextAstRenderer::render($ast),
            default => throw new RenderingException('Invalid renderer'),
        };
    }
}
