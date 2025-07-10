<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\GlobalDefaultsOnlyTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use Filament\Resources\Resource;

/**
 * UserResource for testing global defaults only (no resource-specific defaults)
 */
class GlobalDefaultsOnlyTestUserResource extends Resource
{
    use HasLabels;
    use HasNavigation;
    use HasGlobalSearch;

    protected static ?string $model = User::class;

    public static function pluginEssential(): ?GlobalDefaultsOnlyTestPlugin
    {
        return GlobalDefaultsOnlyTestPlugin::get();
    }
}
