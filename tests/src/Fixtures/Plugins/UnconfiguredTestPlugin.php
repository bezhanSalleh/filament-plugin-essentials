<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

class UnconfiguredTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasNavigation;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return Filament::getPlugin('unconfigured-test');
    }

    public function getId(): string
    {
        return 'unconfigured-test';
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
