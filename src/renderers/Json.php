<?php

namespace Differ\Renderers\Json;

function astToJsonDiff($ast)
{
    return json_encode($ast, JSON_PRETTY_PRINT);
}
