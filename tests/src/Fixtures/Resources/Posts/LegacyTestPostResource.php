<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\LegacyStructureTestPlugin;
use Filament\Resources\Resource;

/**
 * PostResource for testing legacy flat structure defaults
 */
class LegacyTestPostResource extends Resource
{
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = Post::class;

    public static function pluginEssential(): ?LegacyStructureTestPlugin
    {
        return LegacyStructureTestPlugin::get();
    }
}
