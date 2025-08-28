<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Enhanced;

use BezhanSalleh\PluginEssentials\Concerns\Resource\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Resource\HasNavigation;
use BezhanSalleh\PluginEssentials\Resource\DelegatesToPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedMultiResourceTestPlugin;
use Filament\Resources\Resource;

class EnhancedPostResource extends Resource
{
    use DelegatesToPlugin;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected static ?string $model = Post::class;

    public static function getEssentialsPlugin(): ?EnhancedMultiResourceTestPlugin
    {
        return EnhancedMultiResourceTestPlugin::get();
    }
}
