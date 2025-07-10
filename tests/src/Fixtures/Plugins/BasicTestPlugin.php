<?php

namespace BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

/**
 * Basic plugin for testing simple default scenarios
 */
class BasicTestPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasLabels;

    protected function getPluginDefaults(): array
    {
        return [
            'modelLabel' => 'Basic Item',
            'pluralModelLabel' => 'Basic Items',
            'recordTitleAttribute' => 'name',
            'hasTitleCaseModelLabel' => true,
        ];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): ?static
    {
        return \Filament\Facades\Filament::getPlugin('basic-test');
    }

    public function getId(): string
    {
        return 'basic-test';
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
