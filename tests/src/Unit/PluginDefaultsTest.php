<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\GlobalSearchMixedTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\GlobalSearchTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\GlobalSearchMixedUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\GlobalSearchUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Plugin Default System', function () {
    it('uses plugin developer defaults when no user values are set', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(), // No user configuration
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test that plugin returns developer defaults
        // Note: getDefaultModelLabel() method overrides the array default
        expect($plugin->getModelLabel())->toBe('Essential Item (Method)')
            ->and($plugin->getPluralModelLabel())->toBe('Essential Items')
            ->and($plugin->getRecordTitleAttribute())->toBe('id');

        // Debug the boolean issue
        $titleCaseResult = $plugin->hasTitleCaseModelLabel();
        expect($titleCaseResult)->toBeFalse('Expected false but got: ' . var_export($titleCaseResult, true));

        // Test that resources delegate to plugin and receive plugin defaults
        expect(UserResource::getModelLabel())->toBe('Essential Item (Method)')
            ->and(UserResource::getPluralModelLabel())->toBe('Essential Items')
            ->and(UserResource::getRecordTitleAttribute())->toBe('id')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeFalse();
    });

    it('allows user fluent API to override plugin defaults', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->modelLabel('User Override')
                    ->pluralModelLabel('User Overrides')
                    ->recordTitleAttribute('name')
                    ->titleCaseModelLabel(true),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test that user values override plugin defaults
        expect($plugin->getModelLabel())->toBe('User Override')
            ->and($plugin->getPluralModelLabel())->toBe('User Overrides')
            ->and($plugin->getRecordTitleAttribute())->toBe('name')
            ->and($plugin->hasTitleCaseModelLabel())->toBeTrue();

        // Test that resources receive user overrides
        expect(UserResource::getModelLabel())->toBe('User Override')
            ->and(UserResource::getPluralModelLabel())->toBe('User Overrides')
            ->and(UserResource::getRecordTitleAttribute())->toBe('name')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeTrue();
    });

    it('uses mixed user overrides and plugin defaults', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->modelLabel('Mixed Override')
                    ->titleCaseModelLabel(true),
                // pluralModelLabel and recordTitleAttribute use plugin defaults
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test mixed values: some user, some plugin defaults
        expect($plugin->getModelLabel())->toBe('Mixed Override') // User override
            ->and($plugin->getPluralModelLabel())->toBe('Essential Items') // Plugin default
            ->and($plugin->getRecordTitleAttribute())->toBe('id') // Plugin default
            ->and($plugin->hasTitleCaseModelLabel())->toBeTrue(); // User override

        // Test that resources receive the mixed values
        expect(UserResource::getModelLabel())->toBe('Mixed Override')
            ->and(UserResource::getPluralModelLabel())->toBe('Essential Items')
            ->and(UserResource::getRecordTitleAttribute())->toBe('id')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeTrue();
    });

    it('falls back to resource defaults when no plugin defaults exist', function () {
        // Create a plugin instance without calling any fluent methods
        // and without overriding the getPluginDefaults method
        $this->panel
            ->plugins([
                new class implements \Filament\Contracts\Plugin
                {
                    use \BezhanSalleh\PluginEssentials\Plugin\HasLabels;
                    use \Filament\Support\Concerns\EvaluatesClosures;

                    public function getId(): string
                    {
                        return 'no-defaults-plugin';
                    }

                    public function register(\Filament\Panel $panel): void {}

                    public function boot(\Filament\Panel $panel): void {}

                    public static function get(): \Filament\Contracts\Plugin
                    {
                        return filament('no-defaults-plugin');
                    }
                },
            ]);

        $plugin = Filament::getPlugin('no-defaults-plugin');

        // Test that plugin returns null (no defaults)
        expect($plugin->getModelLabel())->toBeNull()
            ->and($plugin->getPluralModelLabel())->toBeNull()
            ->and($plugin->getRecordTitleAttribute())->toBeNull()
            ->and($plugin->hasTitleCaseModelLabel())->toBeTrue(); // Built-in default

        // Note: Resource defaults testing requires a proper resource setup
        // For now, we verify the plugin returns appropriate null values
        // which allows the resource delegation to fall back to its defaults
    });

    // HasGlobalSearch Tests
    it('handles user overrides for global search properties', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->globalSearchResultsLimit(25)
                    ->globallySearchable(false)
                    ->forceGlobalSearchCaseInsensitive(true)
                    ->splitGlobalSearchTerms(true),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test user overrides
        expect($plugin->getGlobalSearchResultsLimit())->toBe(25)
            ->and($plugin->isGloballySearchable())->toBeFalse()
            ->and($plugin->canGloballySearch())->toBeFalse()
            ->and($plugin->isGlobalSearchForcedCaseInsensitive())->toBeTrue()
            ->and($plugin->shouldSplitGlobalSearchTerms())->toBeTrue();

        // Test that resources receive user overrides
        expect(UserResource::getGlobalSearchResultsLimit())->toBe(25)
            ->and(UserResource::isGloballySearchable())->toBeFalse()
            ->and(UserResource::canGloballySearch())->toBeFalse()
            ->and(UserResource::isGlobalSearchForcedCaseInsensitive())->toBeTrue()
            ->and(UserResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    it('uses plugin defaults for global search when user has not set values', function () {
        $this->panel
            ->plugins([
                GlobalSearchTestPlugin::make(),
            ]);

        $plugin = Filament::getPlugin('global-search-test');

        // Test plugin defaults (no user overrides)
        expect($plugin->getGlobalSearchResultsLimit())->toBe(100)
            ->and($plugin->isGloballySearchable())->toBeFalse()
            ->and($plugin->canGloballySearch())->toBeFalse()
            ->and($plugin->isGlobalSearchForcedCaseInsensitive())->toBeTrue()
            ->and($plugin->shouldSplitGlobalSearchTerms())->toBeTrue();

        // Test that resources receive plugin defaults
        expect(GlobalSearchUserResource::getGlobalSearchResultsLimit())->toBe(100)
            ->and(GlobalSearchUserResource::isGloballySearchable())->toBeFalse()
            ->and(GlobalSearchUserResource::canGloballySearch())->toBeFalse()
            ->and(GlobalSearchUserResource::isGlobalSearchForcedCaseInsensitive())->toBeTrue()
            ->and(GlobalSearchUserResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    it('handles mixed global search overrides and defaults', function () {
        $this->panel
            ->plugins([
                GlobalSearchMixedTestPlugin::make()
                    ->globalSearchResultsLimit(30) // User override
                    ->splitGlobalSearchTerms(true), // User override
                // globallySearchable and isGlobalSearchForcedCaseInsensitive use plugin/resource defaults
            ]);

        $plugin = Filament::getPlugin('global-search-mixed-test');

        // Test mixed values: some user, some plugin defaults, some resource defaults
        expect($plugin->getGlobalSearchResultsLimit())->toBe(30) // User override
            ->and($plugin->isGloballySearchable())->toBeTrue() // Resource default (no plugin default)
            ->and($plugin->canGloballySearch())->toBeTrue() // Resource default (no plugin default)
            ->and($plugin->isGlobalSearchForcedCaseInsensitive())->toBeFalse() // Plugin default
            ->and($plugin->shouldSplitGlobalSearchTerms())->toBeTrue(); // User override

        // Test that resources receive the mixed values
        expect(GlobalSearchMixedUserResource::getGlobalSearchResultsLimit())->toBe(30)
            ->and(GlobalSearchMixedUserResource::isGloballySearchable())->toBeTrue()
            ->and(GlobalSearchMixedUserResource::canGloballySearch())->toBeTrue()
            ->and(GlobalSearchMixedUserResource::isGlobalSearchForcedCaseInsensitive())->toBeFalse()
            ->and(GlobalSearchMixedUserResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    // Basic tests for other traits to verify the system works universally
    it('works with all plugin traits for user overrides', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    // HasLabels
                    ->modelLabel('User Override Label')
                    // HasNavigation
                    ->navigationLabel('User Nav Label')
                    ->navigationSort(99)
                    // BelongsToCluster
                    ->cluster('UserCluster')
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
            ->and($plugin->getCluster())->toBe('UserCluster')
            ->and($plugin->getParentResource())->toBe('UserParentResource')
            ->and($plugin->isScopedToTenant())->toBeFalse()
            ->and($plugin->getTenantRelationshipName())->toBe('userTenant');
    });

    it('works with all plugin traits for plugin defaults', function () {
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
                            'cluster' => 'PluginCluster',
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
            ->and($plugin->getCluster())->toBe('PluginCluster')
            ->and($plugin->getParentResource())->toBe('PluginParentResource')
            ->and($plugin->isScopedToTenant())->toBeFalse()
            ->and($plugin->getTenantRelationshipName())->toBe('pluginTenant');
    });
});
