<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\EnhancedMultiResourceTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Enhanced\EnhancedUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Enhanced\EnhancedPostResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();

    // Register the plugin following the working pattern
    $this->panel->plugins([
        EnhancedMultiResourceTestPlugin::make()
    ]);
});

describe('Enhanced Multi-Resource Default System', function () {
    it('uses resource-specific defaults for user resource', function () {
        // Test navigation label - should use resource-specific default
        expect(EnhancedUserResource::getNavigationLabel())->toBe('Plugin Users')
            ->and(EnhancedUserResource::getNavigationIcon())->toBe('heroicon-o-users')
            ->and(EnhancedUserResource::getModelLabel())->toBe('Plugin User')
            ->and(EnhancedUserResource::getPluralModelLabel())->toBe('Plugin Users')
            ->and(EnhancedUserResource::getGlobalSearchResultsLimit())->toBe(25);
    });

    it('uses resource-specific defaults for post resource', function () {
        // Test navigation properties - should use resource-specific defaults
        expect(EnhancedPostResource::getNavigationLabel())->toBe('Plugin Posts')
            ->and(EnhancedPostResource::getNavigationIcon())->toBe('heroicon-o-document-text')
            ->and(EnhancedPostResource::getModelLabel())->toBe('Plugin Post')
            ->and(EnhancedPostResource::getPluralModelLabel())->toBe('Plugin Posts')
            ->and(EnhancedPostResource::getNavigationSort())->toBe(10);
    });

    it('falls back to global defaults when no resource-specific default exists', function () {
        // Test navigation group - should use global default (no resource-specific value)
        expect(EnhancedUserResource::getNavigationGroup())->toBe('Enhanced Plugin')
            ->and(EnhancedPostResource::getNavigationGroup())->toBe('Enhanced Plugin')
            ->and(EnhancedUserResource::getNavigationSort())->toBe(50) // Global default for user
            ->and(EnhancedPostResource::getGlobalSearchResultsLimit())->toBe(30); // Global default for post
    });

    it('prioritizes user overrides over resource-specific defaults', function () {
        // Configure user overrides
        $plugin = EnhancedMultiResourceTestPlugin::make()
            ->resource(EnhancedUserResource::class)
                ->navigationLabel('User Override')
                ->navigationIcon('heroicon-o-user-group')
            ->resource(EnhancedPostResource::class)
                ->modelLabel('Post Override')
                ->navigationSort(5);

        // Re-register with user overrides
        $this->panel->plugin($plugin);

        // Test user overrides take priority
        expect(EnhancedUserResource::getNavigationLabel())->toBe('User Override')
            ->and(EnhancedUserResource::getNavigationIcon())->toBe('heroicon-o-user-group')
            ->and(EnhancedPostResource::getModelLabel())->toBe('Post Override')
            ->and(EnhancedPostResource::getNavigationSort())->toBe(5);

        // Test that non-overridden values still use resource defaults
        expect(EnhancedUserResource::getModelLabel())->toBe('Plugin User') // Still uses resource default
            ->and(EnhancedPostResource::getNavigationLabel())->toBe('Plugin Posts'); // Still uses resource default
    });

    it('demonstrates complete 4-tier fallback system', function () {
        // 4-tier system:
        // 1. User overrides (highest priority)
        // 2. Resource-specific plugin defaults
        // 3. Global plugin defaults
        // 4. Filament defaults (lowest priority)

        // Configure partial user overrides
        $plugin = EnhancedMultiResourceTestPlugin::make()
            ->resource(EnhancedUserResource::class)
                ->navigationLabel('User Override'); // User override

        $this->panel->plugin($plugin);

        // Test the complete fallback chain for user resource:
        expect(EnhancedUserResource::getNavigationLabel())->toBe('User Override') // 1. User override
            ->and(EnhancedUserResource::getNavigationIcon())->toBe('heroicon-o-users') // 2. Resource default
            ->and(EnhancedUserResource::getNavigationGroup())->toBe('Enhanced Plugin') // 3. Global default
            ->and(EnhancedUserResource::getNavigationBadge())->toBeNull(); // 4. Filament default (null)

        // Test the complete fallback chain for post resource:
        expect(EnhancedPostResource::getNavigationLabel())->toBe('Plugin Posts') // 2. Resource default
            ->and(EnhancedPostResource::getNavigationIcon())->toBe('heroicon-o-document-text') // 2. Resource default
            ->and(EnhancedPostResource::getNavigationGroup())->toBe('Enhanced Plugin') // 3. Global default
            ->and(EnhancedPostResource::getNavigationBadge())->toBeNull(); // 4. Filament default (null)
    });

    it('maintains backward compatibility with flat resource structure', function () {
        // Create a plugin with legacy flat structure
        $plugin = new class extends EnhancedMultiResourceTestPlugin {
            protected function getPluginDefaults(): array
            {
                return [
                    // Global defaults
                    'navigationGroup' => 'Legacy Plugin',

                    // Legacy flat structure (for backward compatibility)
                    EnhancedUserResource::class => [
                        'navigationLabel' => 'Legacy Users',
                        'modelLabel' => 'Legacy User',
                    ],
                ];
            }
        };

        $this->panel->plugin($plugin);

        // Test that legacy structure still works
        expect(EnhancedUserResource::getNavigationLabel())->toBe('Legacy Users')
            ->and(EnhancedUserResource::getModelLabel())->toBe('Legacy User')
            ->and(EnhancedUserResource::getNavigationGroup())->toBe('Legacy Plugin');
    });

    it('prioritizes new nested structure over legacy flat structure', function () {
        // Create a plugin with both structures (new should win)
        $plugin = new class extends EnhancedMultiResourceTestPlugin {
            protected function getPluginDefaults(): array
            {
                return [
                    // Global defaults
                    'navigationGroup' => 'Mixed Plugin',

                    // New nested structure
                    'resources' => [
                        EnhancedUserResource::class => [
                            'navigationLabel' => 'New Nested Users',
                            'modelLabel' => 'New Nested User',
                        ],
                    ],

                    // Legacy flat structure (should be ignored when nested exists)
                    EnhancedUserResource::class => [
                        'navigationLabel' => 'Legacy Users',
                        'modelLabel' => 'Legacy User',
                    ],
                ];
            }
        };

        $this->panel->plugin($plugin);

        // Test that new nested structure takes precedence
        expect(EnhancedUserResource::getNavigationLabel())->toBe('New Nested Users')
            ->and(EnhancedUserResource::getModelLabel())->toBe('New Nested User');
    });
});
