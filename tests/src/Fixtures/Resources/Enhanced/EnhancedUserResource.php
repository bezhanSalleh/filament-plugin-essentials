<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Enhanced;

use BezhanSalleh\PluginEssentials\Concerns\Resource\BelongsToCluster;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\User;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedMultiResourceTestPlugin;
use Filament\Resources\Resource;

class EnhancedUserResource extends Resource
{
    use BelongsToCluster;
    use DelegatesToPlugin;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = User::class;

    public static function getEssentialsPlugin(): ?EnhancedMultiResourceTestPlugin
    {
        return EnhancedMultiResourceTestPlugin::get();
    }
}
