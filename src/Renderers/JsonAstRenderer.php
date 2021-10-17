<?php

namespace Differ\Renderers;

use Differ\Exceptions\RenderingException;
use JsonException;

class JsonAstRenderer extends AbstractAstRenderer
{
    public const NAME = 'json';

    public static function render(array $ast): string
    {
        try {
            return json_encode($ast, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        } catch (JsonException $e) {
            throw new RenderingException($e->getMessage());
        }
    }
}
