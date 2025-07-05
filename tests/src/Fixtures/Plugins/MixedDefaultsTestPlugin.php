<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Plugin with only some defaults for testing mixed scenarios
 */
class MixedDefaultsTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;

    protected function getPluginDefaults(): array
    {
        return [
            // Only provide defaults for some properties
            'pluralModelLabel' => 'Mixed Items',
            'recordTitleAttribute' => 'slug',
            'navigationSort' => 50,
            'shouldRegisterNavigation' => false,
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('mixed-defaults-test');
    }

    public function getId(): string
    {
        return 'mixed-defaults-test';
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
