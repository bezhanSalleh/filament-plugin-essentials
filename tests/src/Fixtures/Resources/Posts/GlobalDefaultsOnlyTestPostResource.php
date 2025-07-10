<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\GlobalDefaultsOnlyTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use Filament\Resources\Resource;

/**
 * PostResource for testing global defaults only (no resource-specific defaults)
 */
class GlobalDefaultsOnlyTestPostResource extends Resource
{
    use HasLabels;
    use HasNavigation;
    use HasGlobalSearch;

    protected static ?string $model = Post::class;

    public static function pluginEssential(): ?GlobalDefaultsOnlyTestPlugin
    {
        return GlobalDefaultsOnlyTestPlugin::get();
    }
}
