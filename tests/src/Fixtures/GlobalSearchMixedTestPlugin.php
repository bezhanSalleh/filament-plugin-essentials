<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures;

use BezhanSalleh\PluginEssentials\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

class GlobalSearchMixedTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;

    /**
     * Plugin developer defaults for testing - only some properties have defaults
     */
    protected function getPluginDefaults(): array
    {
        return [
            'globalSearchResultsLimit' => 75,
            'isGlobalSearchForcedCaseInsensitive' => false,
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('global-search-mixed-test');
    }

    public function getId(): string
    {
        return 'global-search-mixed-test';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
