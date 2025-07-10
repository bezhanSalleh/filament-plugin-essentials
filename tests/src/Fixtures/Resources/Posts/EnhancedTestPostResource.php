<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedDefaultsTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use Filament\Resources\Resource;

/**
 * PostResource for testing enhanced resource-specific defaults
 */
class EnhancedTestPostResource extends Resource
{
    use HasLabels;
    use HasNavigation;
    use HasGlobalSearch;

    protected static ?string $model = Post::class;

    public static function pluginEssential(): ?EnhancedDefaultsTestPlugin
    {
        return EnhancedDefaultsTestPlugin::get();
    }
}
