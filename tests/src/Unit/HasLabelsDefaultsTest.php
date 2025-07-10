<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('HasLabels Trait - 3-Tier Default System', function () {
    it('prioritizes user overrides over plugin defaults', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->modelLabel('User Override Label')
                    ->pluralModelLabel('User Override Plural')
                    ->titleCaseModelLabel(false)
                    ->recordTitleAttribute('email'),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test user overrides
        expect($plugin->getModelLabel())->toBe('User Override Label')
            ->and($plugin->getPluralModelLabel())->toBe('User Override Plural')
            ->and($plugin->hasTitleCaseModelLabel())->toBeFalse()
            ->and($plugin->getRecordTitleAttribute())->toBe('email');

        // Test that resources receive user overrides
        expect(UserResource::getModelLabel())->toBe('User Override Label')
            ->and(UserResource::getPluralModelLabel())->toBe('User Override Plural')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeFalse()
            ->and(UserResource::getRecordTitleAttribute())->toBe('email');
    });

    it('uses plugin defaults when no user values are set', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(), // No user configuration
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test that plugin returns developer defaults
        // Note: getDefaultModelLabel() method overrides the array default
        expect($plugin->getModelLabel())->toBe('Essential Item (Method)')
            ->and($plugin->getPluralModelLabel())->toBe('Essential Items')
            ->and($plugin->getRecordTitleAttribute())->toBe('id')
            ->and($plugin->hasTitleCaseModelLabel())->toBeFalse();

        // Test that resources receive plugin defaults
        expect(UserResource::getModelLabel())->toBe('Essential Item (Method)')
            ->and(UserResource::getPluralModelLabel())->toBe('Essential Items')
            ->and(UserResource::getRecordTitleAttribute())->toBe('id')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeFalse();
    });

    it('allows user fluent API to override plugin defaults', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->modelLabel('User Override'), // User override
                // pluralModelLabel and recordTitleAttribute will use plugin defaults
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test mixed values: some user, some plugin defaults
        expect($plugin->getModelLabel())->toBe('User Override') // User override
            ->and($plugin->getPluralModelLabel())->toBe('Essential Items') // Plugin default
            ->and($plugin->getRecordTitleAttribute())->toBe('id') // Plugin default
            ->and($plugin->hasTitleCaseModelLabel())->toBeFalse(); // Plugin default

        // Test that resources receive the mixed values
        expect(UserResource::getModelLabel())->toBe('User Override')
            ->and(UserResource::getPluralModelLabel())->toBe('Essential Items')
            ->and(UserResource::getRecordTitleAttribute())->toBe('id')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeFalse();
    });

    it('falls back to resource defaults when no plugin defaults exist', function () {
        // Create a plugin instance without calling any fluent methods
        // and without overriding the getPluginDefaults method
        $this->panel
            ->plugins([
                new class implements \Filament\Contracts\Plugin
                {
                    use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
                    use \Filament\Support\Concerns\EvaluatesClosures;

                    public function getId(): string
                    {
                        return 'no-defaults-plugin';
                    }

                    public function register(\Filament\Panel $panel): void {}

                    public function boot(\Filament\Panel $panel): void {}

                    public static function make(): static
                    {
                        return app(self::class);
                    }

                    public static function get(): ?static
                    {
                        return \Filament\Facades\Filament::getPlugin('no-defaults-plugin');
                    }
                },
            ]);

        // Since UserResource can't delegate to this plugin (different ID),
        // it should fall back to its own defaults
        expect(UserResource::getModelLabel())->toBeString()
            ->and(UserResource::getPluralModelLabel())->toBeString()
            ->and(UserResource::hasTitleCaseModelLabel())->toBeBool();
    });
});
