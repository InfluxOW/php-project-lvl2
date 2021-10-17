<?php

namespace Differ\Enums;

class AstNodeType
{
    public const REMOVED = 'removed';
    public const ADDED = 'added';
    public const CHANGED = 'changed';
    public const UNCHANGED = 'unchanged';
    public const NESTED = 'nested';
}
