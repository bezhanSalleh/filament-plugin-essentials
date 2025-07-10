<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\LegacyStructureTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use Filament\Resources\Resource;

/**
 * UserResource for testing legacy flat structure defaults
 */
class LegacyTestUserResource extends Resource
{
    use HasLabels;
    use HasNavigation;
    use HasGlobalSearch;

    protected static ?string $model = User::class;

    public static function pluginEssential(): ?LegacyStructureTestPlugin
    {
        return LegacyStructureTestPlugin::get();
    }
}
