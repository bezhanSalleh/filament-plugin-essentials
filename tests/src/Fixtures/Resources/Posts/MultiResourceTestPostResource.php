<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts;

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\MultiResourceTestPlugin;

/**
 * PostResource that connects to MultiResourceTestPlugin for enhanced defaults testing
 */
class MultiResourceTestPostResource extends PostResource
{
    public static function pluginEssential(): ?MultiResourceTestPlugin
    {
        return MultiResourceTestPlugin::get();
    }
}
