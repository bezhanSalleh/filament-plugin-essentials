<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\BelongsToCluster;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\BelongsToParent;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\BelongsToTenant;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\WithMultipleResourceSupport;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\PostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Multi-forResource plugin for testing contextual property support
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
        return \Filament\Facades\Filament::getPlugin('multi-forResource-test');
    }

    public function getId(): string
    {
        return 'multi-forResource-test';
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
