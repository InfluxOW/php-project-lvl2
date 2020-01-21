<?php

namespace Differ\Renderers\Plain;

function isBool($value)
{
    return is_bool($value) ? ($value === true ? "true" : "false") : $value;
}
