<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedDefaultsTestPlugin;
use Filament\Resources\Resource;

/**
 * PostResource for testing enhanced resource-specific defaults
 */
class EnhancedTestPostResource extends Resource
{
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = Post::class;

    public static function pluginEssential(): ?EnhancedDefaultsTestPlugin
    {
        return EnhancedDefaultsTestPlugin::get();
    }
}
