<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedDefaultsTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\GlobalDefaultsOnlyTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\LegacyStructureTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\EnhancedTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\EnhancedTestPostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\GlobalDefaultsOnlyTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\GlobalDefaultsOnlyTestPostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\LegacyTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\LegacyTestPostResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Enhanced Resource-Specific Default System', function () {
    it('uses resource-specific defaults from nested structure', function () {
        // Arrange: Set up plugin with NO user configuration (pure defaults)
        $this->panel
            ->plugins([
                EnhancedDefaultsTestPlugin::make(), // No user configuration
            ]);

        // Act: No explicit action needed - panel configuration triggers the system

        // Assert: EnhancedTestUserResource should get resource-specific defaults
        expect(EnhancedTestUserResource::getModelLabel())->toBe('Enhanced User') // Resource-specific default
            ->and(EnhancedTestUserResource::getPluralModelLabel())->toBe('Enhanced Users') // Resource-specific default
            ->and(EnhancedTestUserResource::getNavigationLabel())->toBe('Enhanced Users') // Resource-specific default
            ->and(EnhancedTestUserResource::getNavigationIcon())->toBe('heroicon-o-users') // Resource-specific default
            ->and(EnhancedTestUserResource::getGlobalSearchResultsLimit())->toBe(25) // Resource-specific default (overrides global)
            ->and(EnhancedTestUserResource::getNavigationGroup())->toBe('Enhanced Plugin') // Falls back to global default
            ->and(EnhancedTestUserResource::getNavigationSort())->toBe(20); // Falls back to global default

        // Assert: EnhancedTestPostResource should get different resource-specific defaults
        expect(EnhancedTestPostResource::getModelLabel())->toBe('Enhanced Post') // Resource-specific default
            ->and(EnhancedTestPostResource::getPluralModelLabel())->toBe('Enhanced Posts') // Resource-specific default
            ->and(EnhancedTestPostResource::getNavigationLabel())->toBe('Enhanced Posts') // Resource-specific default
            ->and(EnhancedTestPostResource::getNavigationIcon())->toBe('heroicon-o-document-text') // Resource-specific default
            ->and(EnhancedTestPostResource::getNavigationSort())->toBe(10) // Resource-specific default (overrides global)
            ->and(EnhancedTestPostResource::getNavigationGroup())->toBe('Enhanced Plugin') // Falls back to global default
            ->and(EnhancedTestPostResource::getGlobalSearchResultsLimit())->toBe(15); // Falls back to global default
    });

    it('prioritizes user overrides over resource-specific defaults', function () {
        // Arrange: Set up plugin with user configuration that overrides some resource-specific defaults
        $this->panel
            ->plugins([
                EnhancedDefaultsTestPlugin::make()
                    ->resource(EnhancedTestUserResource::class)
                    ->modelLabel('User Override') // User override
                    ->navigationIcon('heroicon-o-user-group') // User override
                    ->resource(EnhancedTestPostResource::class)
                    ->pluralModelLabel('Post Override'), // User override
            ]);

        // Act: No explicit action needed - panel configuration triggers the system

        // Assert: EnhancedTestUserResource should prioritize user overrides, then resource-specific defaults, then global defaults
        expect(EnhancedTestUserResource::getModelLabel())->toBe('User Override') // User override (highest priority)
            ->and(EnhancedTestUserResource::getNavigationIcon())->toBe('heroicon-o-user-group') // User override (highest priority)
            ->and(EnhancedTestUserResource::getPluralModelLabel())->toBe('Enhanced Users') // Resource-specific default (no user override)
            ->and(EnhancedTestUserResource::getNavigationLabel())->toBe('Enhanced Users') // Resource-specific default (no user override)
            ->and(EnhancedTestUserResource::getGlobalSearchResultsLimit())->toBe(25) // Resource-specific default (overrides global)
            ->and(EnhancedTestUserResource::getNavigationGroup())->toBe('Enhanced Plugin'); // Global default (no resource-specific or user override)

        // Assert: EnhancedTestPostResource should prioritize user overrides, then resource-specific defaults, then global defaults
        expect(EnhancedTestPostResource::getPluralModelLabel())->toBe('Post Override') // User override (highest priority)
            ->and(EnhancedTestPostResource::getModelLabel())->toBe('Enhanced Post') // Resource-specific default (no user override)
            ->and(EnhancedTestPostResource::getNavigationLabel())->toBe('Enhanced Posts') // Resource-specific default (no user override)
            ->and(EnhancedTestPostResource::getNavigationIcon())->toBe('heroicon-o-document-text') // Resource-specific default (no user override)
            ->and(EnhancedTestPostResource::getNavigationSort())->toBe(10) // Resource-specific default (overrides global)
            ->and(EnhancedTestPostResource::getNavigationGroup())->toBe('Enhanced Plugin'); // Global default (no resource-specific or user override)
    });

    it('falls back to global defaults when no resource-specific defaults exist', function () {
        // Arrange: Use a dedicated plugin with only global defaults (no 'resources' key)
        $this->panel->plugins([
            GlobalDefaultsOnlyTestPlugin::make(),
        ]);

        // Act: No explicit action needed - panel configuration triggers the system

        // Assert: Both resources should use global defaults (no resource-specific defaults available)
        expect(GlobalDefaultsOnlyTestUserResource::getModelLabel())->toBe('Global Only') // Global default
            ->and(GlobalDefaultsOnlyTestUserResource::getPluralModelLabel())->toBe('Global Only Items') // Global default
            ->and(GlobalDefaultsOnlyTestUserResource::getNavigationSort())->toBe(99) // Global default
            ->and(GlobalDefaultsOnlyTestUserResource::getGlobalSearchResultsLimit())->toBe(50) // Global default
            ->and(GlobalDefaultsOnlyTestUserResource::getNavigationGroup())->toBe('Global Plugin'); // Global default

        expect(GlobalDefaultsOnlyTestPostResource::getModelLabel())->toBe('Global Only') // Global default
            ->and(GlobalDefaultsOnlyTestPostResource::getPluralModelLabel())->toBe('Global Only Items') // Global default
            ->and(GlobalDefaultsOnlyTestPostResource::getNavigationSort())->toBe(99) // Global default
            ->and(GlobalDefaultsOnlyTestPostResource::getGlobalSearchResultsLimit())->toBe(50) // Global default
            ->and(GlobalDefaultsOnlyTestPostResource::getNavigationGroup())->toBe('Global Plugin'); // Global default
    });

    it('supports backward compatibility with legacy flat structure', function () {
        // Arrange: Use a dedicated plugin that uses the legacy flat structure for resource-specific defaults
        $this->panel->plugins([
            LegacyStructureTestPlugin::make(),
        ]);

        // Act: No explicit action needed - panel configuration triggers the system

        // Assert: Resources should get legacy structure defaults
        expect(LegacyTestUserResource::getModelLabel())->toBe('Legacy User') // Legacy structure default
            ->and(LegacyTestUserResource::getNavigationIcon())->toBe('heroicon-o-user') // Legacy structure default
            ->and(LegacyTestUserResource::getNavigationGroup())->toBe('Legacy Plugin') // Global default
            ->and(LegacyTestUserResource::getGlobalSearchResultsLimit())->toBe(30); // Global default

        expect(LegacyTestPostResource::getModelLabel())->toBe('Legacy Post') // Legacy structure default
            ->and(LegacyTestPostResource::getNavigationIcon())->toBe('heroicon-o-document') // Legacy structure default
            ->and(LegacyTestPostResource::getNavigationGroup())->toBe('Legacy Plugin') // Global default
            ->and(LegacyTestPostResource::getGlobalSearchResultsLimit())->toBe(30); // Global default
    });
});
