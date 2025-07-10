<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Enhanced;

use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;
use BezhanSalleh\PluginEssentials\Resource\Concerns\BelongsToCluster;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedMultiResourceTestPlugin;
use Filament\Resources\Resource;

class EnhancedPostResource extends Resource
{
    use BelongsToCluster;
    use DelegatesToPlugin;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = Post::class;

    public static function pluginEssential(): ?EnhancedMultiResourceTestPlugin
    {
        return EnhancedMultiResourceTestPlugin::get();
    }
}
