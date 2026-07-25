<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use Filament\Facades\Filament;
use Filament\Panel;

class InheritedTraitTestPlugin extends AbstractInheritedBasePlugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return Filament::getPlugin('inherited-trait-test');
    }

    public function getId(): string
    {
        return 'inherited-trait-test';
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
