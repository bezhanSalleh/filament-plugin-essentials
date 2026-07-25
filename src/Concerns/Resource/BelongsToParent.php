<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Resource;

trait BelongsToParent
{
    use DelegatesToPlugin;

    public static function getParentResource(): ?string
    {
        return static::pluginOrParent('BelongsToParent', 'parentResource', 'getParentResource');
    }
}
