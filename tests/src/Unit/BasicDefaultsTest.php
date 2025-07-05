<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\BasicTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\BasicTestUserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Basic 3-Tier Default System', function () {
    it('prioritizes user overrides over plugin defaults', function () {
        $this->panel
            ->plugins([
                BasicTestPlugin::make()
                    ->modelLabel('User Override')
                    ->pluralModelLabel('User Items'),
            ]);

        $plugin = Filament::getPlugin('basic-test');

        // Test user overrides take priority
        expect($plugin->getModelLabel())->toBe('User Override')
            ->and($plugin->getPluralModelLabel())->toBe('User Items')
            ->and($plugin->getRecordTitleAttribute())->toBe('name') // Plugin default
            ->and($plugin->hasTitleCaseModelLabel())->toBeTrue(); // Plugin default

        // Test that resources receive user overrides and plugin defaults
        expect(BasicTestUserResource::getModelLabel())->toBe('User Override')
            ->and(BasicTestUserResource::getPluralModelLabel())->toBe('User Items')
            ->and(BasicTestUserResource::getRecordTitleAttribute())->toBe('name')
            ->and(BasicTestUserResource::hasTitleCaseModelLabel())->toBeTrue();
    });

    it('uses plugin defaults when no user values are set', function () {
        $this->panel
            ->plugins([
                BasicTestPlugin::make(), // No user configuration
            ]);

        $plugin = Filament::getPlugin('basic-test');

        // Test plugin defaults are used
        expect($plugin->getModelLabel())->toBe('Basic Item')
            ->and($plugin->getPluralModelLabel())->toBe('Basic Items')
            ->and($plugin->getRecordTitleAttribute())->toBe('name')
            ->and($plugin->hasTitleCaseModelLabel())->toBeTrue();

        // Test that resources receive plugin defaults
        expect(BasicTestUserResource::getModelLabel())->toBe('Basic Item')
            ->and(BasicTestUserResource::getPluralModelLabel())->toBe('Basic Items')
            ->and(BasicTestUserResource::getRecordTitleAttribute())->toBe('name')
            ->and(BasicTestUserResource::hasTitleCaseModelLabel())->toBeTrue();
    });
});
