<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\WithMultipleResourceSupport;
use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

class RegressionTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasGlobalSearch;
    use HasNavigation;
    use WithMultipleResourceSupport;

    protected function getPluginDefaults(): array
    {
        return [
            'navigationIcon' => 'heroicon-o-cog',
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return Filament::getPlugin('regression-test');
    }

    public function getId(): string
    {
        return 'regression-test';
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
