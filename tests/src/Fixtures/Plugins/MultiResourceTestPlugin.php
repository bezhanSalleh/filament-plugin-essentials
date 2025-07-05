<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Plugin\BelongsToCluster;
use BezhanSalleh\PluginEssentials\Plugin\BelongsToParent;
use BezhanSalleh\PluginEssentials\Plugin\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\WithMultipleResourceSupport;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\PostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Multi-resource plugin for testing contextual property support
 */
class MultiResourceTestPlugin implements Plugin
{
    use BelongsToCluster;
    use BelongsToParent;
    use BelongsToTenant;
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;
    use WithMultipleResourceSupport;

    protected function getPluginDefaults(): array
    {
        return [
            'modelLabel' => 'Multi Item',
            'pluralModelLabel' => 'Multi Items',
            'navigationSort' => 20,
            'globalSearchResultsLimit' => 15,
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('multi-resource-test');
    }

    public function getId(): string
    {
        return 'multi-resource-test';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
            PostResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
