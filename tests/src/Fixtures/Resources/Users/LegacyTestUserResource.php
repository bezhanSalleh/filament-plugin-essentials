<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users;

use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\LegacyStructureTestPlugin;
use Filament\Resources\Resource;

/**
 * UserResource for testing legacy flat structure defaults
 */
class LegacyTestUserResource extends Resource
{
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = User::class;

    public static function getEssentialsPlugin(): ?LegacyStructureTestPlugin
    {
        return LegacyStructureTestPlugin::get();
    }
}
