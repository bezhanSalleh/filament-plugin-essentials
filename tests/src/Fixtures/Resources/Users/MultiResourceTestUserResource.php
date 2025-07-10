<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\MultiResourceTestPlugin;

/**
 * UserResource that connects to MultiResourceTestPlugin for enhanced defaults testing
 */
class MultiResourceTestUserResource extends UserResource
{
    public static function pluginEssential(): ?EssentialPlugin
    {
        return MultiResourceTestPlugin::get();
    }
}
