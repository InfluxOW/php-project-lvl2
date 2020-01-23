<?php

namespace Differ\Renderers\Json;

function astToJson($ast)
{
    return json_encode($ast, JSON_PRETTY_PRINT);
}
