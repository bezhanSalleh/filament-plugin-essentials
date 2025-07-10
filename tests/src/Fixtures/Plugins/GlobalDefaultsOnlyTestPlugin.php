<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\WithMultipleResourceSupport;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Plugin for testing fallback to global defaults (no resource-specific defaults)
 */
class GlobalDefaultsOnlyTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;
    use WithMultipleResourceSupport;

    protected function getPluginDefaults(): array
    {
        return [
            // Only global defaults, no 'resources' key
            'modelLabel' => 'Global Only',
            'pluralModelLabel' => 'Global Only Items',
            'navigationSort' => 99,
            'globalSearchResultsLimit' => 50,
            'navigationGroup' => 'Global Plugin',
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('global-defaults-only-test');
    }

    public function getId(): string
    {
        return 'global-defaults-only-test';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
