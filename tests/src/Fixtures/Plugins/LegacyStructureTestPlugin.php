<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\WithMultipleResourceSupport;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\LegacyTestPostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\LegacyTestUserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Plugin for testing backward compatibility with legacy flat structure
 */
class LegacyStructureTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;
    use WithMultipleResourceSupport;

    protected function getPluginDefaults(): array
    {
        return [
            // Global defaults
            'navigationGroup' => 'Legacy Plugin',
            'globalSearchResultsLimit' => 30,

            // Legacy flat structure (should still work)
            LegacyTestUserResource::class => [
                'modelLabel' => 'Legacy User',
                'navigationIcon' => 'heroicon-o-user',
            ],
            LegacyTestPostResource::class => [
                'modelLabel' => 'Legacy Post',
                'navigationIcon' => 'heroicon-o-document',
            ],
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('legacy-structure-test');
    }

    public function getId(): string
    {
        return 'legacy-structure-test';
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
