<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\BelongsToParent;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\FullFeaturesTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Full-featured plugin for testing all traits together
 */
class FullFeaturesTestPlugin implements Plugin
{
    use BelongsToParent;
    use BelongsToTenant;
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('full-features-test');
    }

    public function getId(): string
    {
        return 'full-features-test';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
            FullFeaturesTestUserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
