<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
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

    public static function getEssentialsPlugin(): ?EnhancedDefaultsTestPlugin
    {
        return EnhancedDefaultsTestPlugin::get();
    }
}
