<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Panel;

class TraitlessTestPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return Filament::getPlugin('traitless-test');
    }

    public function getId(): string
    {
        return 'traitless-test';
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
