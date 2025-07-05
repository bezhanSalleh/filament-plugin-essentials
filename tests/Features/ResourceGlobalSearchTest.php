<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

describe('Resource HasGlobalSearch Delegation', function () {
    it('delegates canGloballySearch to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->globallySearchable(false);

        MockResource::setPlugin($plugin);

        expect(MockResource::canGloballySearch())->toBeFalse();
    });

    it('falls back to parent for canGloballySearch when no plugin', function () {
        expect(MockResource::canGloballySearch())->toBeTrue();
    });

    it('handles boolean true plugin result for canGloballySearch', function () {
        $plugin = new MockPlugin;
        $plugin->globallySearchable(true);

        MockResource::setPlugin($plugin);

        expect(MockResource::canGloballySearch())->toBeTrue();
    });

    it('delegates getGlobalSearchResultsLimit to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->globalSearchResultsLimit(25);

        MockResource::setPlugin($plugin);

        expect(MockResource::getGlobalSearchResultsLimit())->toBe(25);
    });

    it('falls back to parent for getGlobalSearchResultsLimit when no plugin', function () {
        expect(MockResource::getGlobalSearchResultsLimit())->toBe(50);
    });

    it('handles int plugin result for getGlobalSearchResultsLimit', function () {
        $plugin = new MockPlugin;
        $plugin->globalSearchResultsLimit(100);

        MockResource::setPlugin($plugin);

        expect(MockResource::getGlobalSearchResultsLimit())->toBe(100);
    });

    it('delegates isGlobalSearchForcedCaseInsensitive to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->forceGlobalSearchCaseInsensitive(true);

        MockResource::setPlugin($plugin);

        expect(MockResource::isGlobalSearchForcedCaseInsensitive())->toBeTrue();
    });

    it('falls back to parent for isGlobalSearchForcedCaseInsensitive when no plugin', function () {
        expect(MockResource::isGlobalSearchForcedCaseInsensitive())->toBeNull();
    });

    it('handles null plugin result for isGlobalSearchForcedCaseInsensitive', function () {
        $plugin = new MockPlugin;
        $plugin->forceGlobalSearchCaseInsensitive(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::isGlobalSearchForcedCaseInsensitive())->toBeNull();
    });

    it('delegates shouldSplitGlobalSearchTerms to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->splitGlobalSearchTerms(true);

        MockResource::setPlugin($plugin);

        expect(MockResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    it('falls back to parent for shouldSplitGlobalSearchTerms when no plugin', function () {
        expect(MockResource::shouldSplitGlobalSearchTerms())->toBeFalse();
    });

    it('handles boolean false plugin result for shouldSplitGlobalSearchTerms', function () {
        $plugin = new MockPlugin;
        $plugin->splitGlobalSearchTerms(false);

        MockResource::setPlugin($plugin);

        expect(MockResource::shouldSplitGlobalSearchTerms())->toBeFalse();
    });

    it('handles closure values correctly for global search methods', function () {
        $plugin = new MockPlugin;
        $plugin->globallySearchable(fn () => false)
            ->globalSearchResultsLimit(75)
            ->forceGlobalSearchCaseInsensitive(fn () => true)
            ->splitGlobalSearchTerms(fn () => true);

        MockResource::setPlugin($plugin);

        expect(MockResource::canGloballySearch())->toBeFalse()
            ->and(MockResource::getGlobalSearchResultsLimit())->toBe(75)
            ->and(MockResource::isGlobalSearchForcedCaseInsensitive())->toBeTrue()
            ->and(MockResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });
});
