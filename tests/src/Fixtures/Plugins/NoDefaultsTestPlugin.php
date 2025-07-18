<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Plugin without defaults for testing forResource fallback
 */
class NoDefaultsTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasLabels;
    use HasNavigation;

    // No getPluginDefaults() method - should fall back to forResource defaults

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('no-defaults-test');
    }

    public function getId(): string
    {
        return 'no-defaults-test';
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
