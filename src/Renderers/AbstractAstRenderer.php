<?php

namespace Differ\Renderers;

use Differ\Exceptions\RenderingException;

abstract class AbstractAstRenderer
{
    public const NAME = null;

    /**
     * @throws RenderingException
     */
    abstract public static function render(array $ast): string;
}
