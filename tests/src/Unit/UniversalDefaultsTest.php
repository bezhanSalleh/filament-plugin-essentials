<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('All Plugin Traits - Universal 3-Tier System', function () {
    it('handles user overrides across all plugin traits', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    // HasLabels
                    ->modelLabel('User Override Label')
                    // HasNavigation
                    ->navigationLabel('User Nav Label')
                    ->navigationSort(99)
                    // BelongsToParent
                    ->parentResource('UserParentResource')
                    // BelongsToTenant
                    ->scopeToTenant(false)
                    ->tenantRelationshipName('userTenant'),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test that all traits respect user overrides
        expect($plugin->getModelLabel())->toBe('User Override Label')
            ->and($plugin->getNavigationLabel())->toBe('User Nav Label')
            ->and($plugin->getNavigationSort())->toBe(99)
            ->and($plugin->getParentResource())->toBe('UserParentResource')
            ->and($plugin->isScopedToTenant())->toBeFalse()
            ->and($plugin->getTenantRelationshipName())->toBe('userTenant');
    });

    it('uses plugin defaults across all plugin traits', function () {
        $this->panel
            ->plugins([
                new class extends EssentialPlugin
                {
                    protected function getPluginDefaults(): array
                    {
                        return [
                            'modelLabel' => 'Plugin Default Label',
                            'navigationLabel' => 'Plugin Nav Label',
                            'navigationSort' => 50,
                            'parentResource' => 'PluginParentResource',
                            'isScopedToTenant' => false,
                            'tenantRelationshipName' => 'pluginTenant',
                        ];
                    }

                    public function getId(): string
                    {
                        return 'bezhansalleh/essentials';
                    }
                },
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test that all traits use plugin defaults when no user overrides
        // Note: modelLabel uses method override which takes precedence
        expect($plugin->getModelLabel())->toBe('Essential Item (Method)')
            ->and($plugin->getNavigationLabel())->toBe('Plugin Nav Label')
            ->and($plugin->getNavigationSort())->toBe(50)
            ->and($plugin->getParentResource())->toBe('PluginParentResource')
            ->and($plugin->isScopedToTenant())->toBeFalse()
            ->and($plugin->getTenantRelationshipName())->toBe('pluginTenant');
    });

    it('demonstrates the complete 3-tier fallback across traits', function () {
        $this->panel
            ->plugins([
                (new class extends EssentialPlugin
                {
                    protected function getPluginDefaults(): array
                    {
                        return [
                            // Only provide defaults for some properties
                            'navigationSort' => 75,
                            'tenantRelationshipName' => 'organization',
                        ];
                    }

                    public function getId(): string
                    {
                        return 'bezhansalleh/essentials';
                    }
                })
                    ->modelLabel('User Override') // User override
                    ->navigationLabel('User Nav'), // User override
                // navigationSort: will use plugin default (75)
                // tenantRelationshipName: will use plugin default ('organization')
                // other properties: will fall back to forResource defaults
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Verify the 3-tier system:
        expect($plugin->getModelLabel())->toBe('User Override') // 1. User override
            ->and($plugin->getNavigationLabel())->toBe('User Nav') // 1. User override
            ->and($plugin->getNavigationSort())->toBe(75) // 2. Plugin default
            ->and($plugin->getTenantRelationshipName())->toBe('organization') // 2. Plugin default
            ->and($plugin->getParentResource())->toBeNull(); // 3. Resource default (property default)
    });
});
