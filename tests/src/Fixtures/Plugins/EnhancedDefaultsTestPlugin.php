<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasPluginDefaults;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\WithMultipleResourceSupport;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\EnhancedTestPostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\EnhancedTestUserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Plugin for testing enhanced forResource-specific defaults using the new nested structure
 */
class EnhancedDefaultsTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;  // This is the key trait for the enhanced functionality!
    use HasLabels;
    use HasNavigation;
    use HasPluginDefaults;
    use WithMultipleResourceSupport;

    /**
     * Demonstrate the enhanced nested forResource-specific defaults structure
     */
    protected function getPluginDefaults(): array
    {
        return [
            // Global defaults (apply to all resources)
            'navigationGroup' => 'Enhanced Plugin',
            'globalSearchResultsLimit' => 15,
            'navigationSort' => 20,

            // NEW: Resource-specific defaults using nested structure
            'resources' => [
                EnhancedTestUserResource::class => [
                    'modelLabel' => 'Enhanced User',
                    'pluralModelLabel' => 'Enhanced Users',
                    'navigationLabel' => 'Enhanced Users',
                    'navigationIcon' => 'heroicon-o-users',
                    'globalSearchResultsLimit' => 25, // Override global default
                ],
                EnhancedTestPostResource::class => [
                    'modelLabel' => 'Enhanced Post',
                    'pluralModelLabel' => 'Enhanced Posts',
                    'navigationLabel' => 'Enhanced Posts',
                    'navigationIcon' => 'heroicon-o-document-text',
                    'navigationSort' => 10, // Override global default
                ],
            ],
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('enhanced-defaults-test');
    }

    public function getId(): string
    {
        return 'enhanced-defaults-test';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            EnhancedTestUserResource::class,
            EnhancedTestPostResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
