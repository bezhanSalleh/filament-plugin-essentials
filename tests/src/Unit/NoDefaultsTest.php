<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\NoDefaultsTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\NoDefaultsTestUserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('No Defaults System', function () {
    it('falls back to resource defaults when plugin has no defaults and no user overrides', function () {
        $this->panel
            ->plugins([
                NoDefaultsTestPlugin::make(),
            ]);

        expect(NoDefaultsTestUserResource::getModelLabel())->toBe('user')
            ->and(NoDefaultsTestUserResource::getPluralModelLabel())->toBe('users')
            ->and(NoDefaultsTestUserResource::getRecordTitleAttribute())->toBe('name') // Explicitly set in resource
            ->and(NoDefaultsTestUserResource::hasTitleCaseModelLabel())->toBeTrue(); // Default in trait
    });

    it('uses user overrides even when plugin has no defaults', function () {
        $this->panel
            ->plugins([
                NoDefaultsTestPlugin::make()
                    ->modelLabel('Custom Label')
                    ->pluralModelLabel('Custom Labels'),
            ]);

        expect(NoDefaultsTestUserResource::getModelLabel())->toBe('Custom Label')
            ->and(NoDefaultsTestUserResource::getPluralModelLabel())->toBe('Custom Labels');
    });
});
