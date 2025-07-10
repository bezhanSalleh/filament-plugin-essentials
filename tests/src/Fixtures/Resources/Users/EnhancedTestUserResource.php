<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedDefaultsTestPlugin;
use Filament\Resources\Resource;

/**
 * UserResource for testing enhanced resource-specific defaults
 */
class EnhancedTestUserResource extends Resource
{
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = User::class;

    public static function pluginEssential(): ?EnhancedDefaultsTestPlugin
    {
        return EnhancedDefaultsTestPlugin::get();
    }
}
