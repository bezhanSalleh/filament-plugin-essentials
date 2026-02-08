<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\FullFeaturesTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\MixedDefaultsTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\FullFeaturesTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\MixedDefaultsTestUserResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('HasGlobalSearch Trait - 3-Tier Default System', function () {
    it('prioritizes user overrides over plugin defaults', function () {
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

    it('uses plugin defaults when no user values are set', function () {
        $this->panel
            ->plugins([
                FullFeaturesTestPlugin::make(),
            ]);

        $plugin = Filament::getPlugin('full-features-test');

        // Test plugin defaults (no user overrides)
        expect($plugin->getGlobalSearchResultsLimit())->toBe(50)
            ->and($plugin->isGloballySearchable())->toBeTrue()
            ->and($plugin->canGloballySearch())->toBeTrue()
            ->and($plugin->shouldSplitGlobalSearchTerms())->toBeFalse();

        // Test that resources receive plugin defaults
        expect(FullFeaturesTestUserResource::getGlobalSearchResultsLimit())->toBe(50)
            ->and(FullFeaturesTestUserResource::isGloballySearchable())->toBeTrue()
            ->and(FullFeaturesTestUserResource::canGloballySearch())->toBeTrue()
            ->and(FullFeaturesTestUserResource::shouldSplitGlobalSearchTerms())->toBeFalse();
    });

    it('handles mixed user overrides and plugin defaults', function () {
        $this->panel
            ->plugins([
                MixedDefaultsTestPlugin::make()
                    ->globalSearchResultsLimit(30) // User override
                    ->splitGlobalSearchTerms(true), // User override
                // globallySearchable uses forResource defaults (no plugin default)
            ]);

        $plugin = Filament::getPlugin('mixed-defaults-test');

        // Test mixed values: some user, some forResource defaults
        expect($plugin->getGlobalSearchResultsLimit())->toBe(30) // User override
            ->and($plugin->isGloballySearchable())->toBeTrue() // Resource default (no plugin default)
            ->and($plugin->canGloballySearch())->toBeTrue() // Resource default (no plugin default)
            ->and($plugin->shouldSplitGlobalSearchTerms())->toBeTrue(); // User override

        // Test that resources receive the mixed values
        expect(MixedDefaultsTestUserResource::getGlobalSearchResultsLimit())->toBe(30)
            ->and(MixedDefaultsTestUserResource::isGloballySearchable())->toBeTrue()
            ->and(MixedDefaultsTestUserResource::canGloballySearch())->toBeTrue()
            ->and(MixedDefaultsTestUserResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });
});
