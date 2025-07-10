<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\PostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Enhanced Multi-Resource Default System', function () {
    it('supports nested resource-specific defaults in getPluginDefaults', function () {
        // Create an enhanced plugin with nested resource-specific defaults
        $plugin = new class extends EssentialPlugin
        {
            protected function getPluginDefaults(): array
            {
                return [
                    // Global defaults
                    'navigationGroup' => 'Enhanced Plugin',
                    'globalSearchResultsLimit' => 30,
                    'navigationSort' => 50,

                    // NEW: Resource-specific defaults using nested structure
                    'resources' => [
                        UserResource::class => [
                            'navigationLabel' => 'Enhanced Users',
                            'navigationIcon' => 'heroicon-o-user-group',
                            'modelLabel' => 'Enhanced User',
                            'globalSearchResultsLimit' => 25, // Override global
                        ],
                        PostResource::class => [
                            'navigationLabel' => 'Enhanced Posts',
                            'navigationIcon' => 'heroicon-o-document-text',
                            'modelLabel' => 'Enhanced Post',
                            'navigationSort' => 10, // Override global
                        ],
                    ],
                ];
            }

            public function getId(): string
            {
                return 'bezhansalleh/essentials';
            }
        };

        $this->panel->plugins([$plugin]);

        $registeredPlugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test UserResource gets resource-specific defaults
        expect(UserResource::getNavigationLabel())->toBe('Enhanced Users')
            ->and(UserResource::getNavigationIcon())->toBe('heroicon-o-user-group')
            ->and(UserResource::getModelLabel())->toBe('Enhanced User')
            ->and(UserResource::getGlobalSearchResultsLimit())->toBe(25) // Resource override
            ->and(UserResource::getNavigationGroup())->toBe('Enhanced Plugin') // Global fallback
            ->and(UserResource::getNavigationSort())->toBe(50); // Global fallback

        // Test PostResource gets its own resource-specific defaults
        expect(PostResource::getNavigationLabel())->toBe('Enhanced Posts')
            ->and(PostResource::getNavigationIcon())->toBe('heroicon-o-document-text')
            ->and(PostResource::getModelLabel())->toBe('Enhanced Post')
            ->and(PostResource::getNavigationSort())->toBe(10) // Resource override
            ->and(PostResource::getNavigationGroup())->toBe('Enhanced Plugin') // Global fallback
            ->and(PostResource::getGlobalSearchResultsLimit())->toBe(30); // Global fallback
    });

    it('maintains backward compatibility with flat structure when nested structure not present', function () {
        // Create a plugin using the legacy flat structure for some resources
        $plugin = new class extends EssentialPlugin
        {
            protected function getPluginDefaults(): array
            {
                return [
                    // Global defaults
                    'navigationGroup' => 'Legacy Plugin',
                    'modelLabel' => 'Legacy Item',

                    // Legacy flat structure (still supported)
                    UserResource::class => [
                        'navigationLabel' => 'Legacy Users',
                        'modelLabel' => 'Legacy User',
                    ],
                ];
            }

            public function getId(): string
            {
                return 'bezhansalleh/essentials';
            }
        };

        $this->panel->plugins([$plugin]);

        // Test that legacy flat structure still works
        expect(UserResource::getNavigationLabel())->toBe('Legacy Users')
            ->and(UserResource::getModelLabel())->toBe('Legacy User')
            ->and(UserResource::getNavigationGroup())->toBe('Legacy Plugin'); // Global fallback

        // Test that PostResource gets global defaults (no legacy resource-specific config)
        expect(PostResource::getModelLabel())->toBe('Legacy Item') // Global default
            ->and(PostResource::getNavigationGroup())->toBe('Legacy Plugin'); // Global default
    });

    it('prioritizes nested structure over legacy flat structure when both exist', function () {
        // Create a plugin with both nested and legacy structures
        $plugin = new class extends EssentialPlugin
        {
            protected function getPluginDefaults(): array
            {
                return [
                    'navigationGroup' => 'Mixed Plugin',

                    // NEW nested structure (should take precedence)
                    'resources' => [
                        UserResource::class => [
                            'navigationLabel' => 'Nested Users',
                            'modelLabel' => 'Nested User',
                        ],
                    ],

                    // Legacy flat structure (should be ignored when nested exists)
                    UserResource::class => [
                        'navigationLabel' => 'Flat Users',
                        'modelLabel' => 'Flat User',
                    ],
                ];
            }

            public function getId(): string
            {
                return 'bezhansalleh/essentials';
            }
        };

        $this->panel->plugins([$plugin]);

        // Test that nested structure takes precedence over flat structure
        expect(UserResource::getNavigationLabel())->toBe('Nested Users')
            ->and(UserResource::getModelLabel())->toBe('Nested User');
    });

    it('allows user overrides to take precedence over resource-specific defaults', function () {
        $this->panel->plugins([
            (new class extends EssentialPlugin
            {
                protected function getPluginDefaults(): array
                {
                    return [
                        'resources' => [
                            UserResource::class => [
                                'navigationLabel' => 'Default Users',
                                'modelLabel' => 'Default User',
                            ],
                        ],
                    ];
                }

                public function getId(): string
                {
                    return 'bezhansalleh/essentials';
                }
            })
                ->navigationLabel('User Override') // User override
                ->modelLabel('Override User'), // User override
        ]);

        // Test that user overrides take highest priority
        expect(UserResource::getNavigationLabel())->toBe('User Override') // User wins
            ->and(UserResource::getModelLabel())->toBe('Override User'); // User wins
    });
});
