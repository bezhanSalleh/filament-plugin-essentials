<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;
use Filament\Pages\Enums\SubNavigationPosition;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

describe('Resource HasNavigation Delegation', function () {
    it('delegates getActiveNavigationIcon to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->activeNavigationIcon('heroicon-s-active');

        MockResource::setPlugin($plugin);

        expect(MockResource::getActiveNavigationIcon())->toBe('heroicon-s-active');
    });

    it('falls back to parent for getActiveNavigationIcon when no plugin', function () {
        expect(MockResource::getActiveNavigationIcon())->toBeNull();
    });

    it('handles null plugin result for getActiveNavigationIcon', function () {
        $plugin = new MockPlugin;
        $plugin->activeNavigationIcon(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getActiveNavigationIcon())->toBeNull();
    });

    it('delegates getNavigationParentItem to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->navigationParentItem('parent.item');

        MockResource::setPlugin($plugin);

        expect(MockResource::getNavigationParentItem())->toBe('parent.item');
    });

    it('falls back to parent for getNavigationParentItem when no plugin', function () {
        expect(MockResource::getNavigationParentItem())->toBeNull();
    });

    it('handles null plugin result for getNavigationParentItem', function () {
        $plugin = new MockPlugin;
        $plugin->navigationParentItem(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getNavigationParentItem())->toBeNull();
    });

    it('delegates getNavigationBadgeColor to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->navigationBadgeColor('success');

        MockResource::setPlugin($plugin);

        expect(MockResource::getNavigationBadgeColor())->toBe('success');
    });

    it('falls back to parent for getNavigationBadgeColor when no plugin', function () {
        expect(MockResource::getNavigationBadgeColor())->toBe('primary');
    });

    it('handles array plugin result for getNavigationBadgeColor', function () {
        $plugin = new MockPlugin;
        $plugin->navigationBadgeColor(['warning', 'danger']);

        MockResource::setPlugin($plugin);

        expect(MockResource::getNavigationBadgeColor())->toBe(['warning', 'danger']);
    });

    it('delegates getSlug to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->slug('custom-slug');

        MockResource::setPlugin($plugin);

        expect(MockResource::getSlug())->toBe('custom-slug');
    });

    it('falls back to parent for getSlug when no plugin', function () {
        expect(MockResource::getSlug())->toBe('default-slug');
    });

    it('handles null plugin result for getSlug correctly', function () {
        $plugin = new MockPlugin;
        $plugin->slug(null);

        MockResource::setPlugin($plugin);

        // When plugin returns null, the delegation should return null (empty string)
        expect(MockResource::getSlug())->toBe('');
    });

    it('delegates getSubNavigationPosition to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->subNavigationPosition(SubNavigationPosition::Top);

        MockResource::setPlugin($plugin);

        expect(MockResource::getSubNavigationPosition())->toBe(SubNavigationPosition::Top);
    });

    it('falls back to parent for getSubNavigationPosition when no plugin', function () {
        expect(MockResource::getSubNavigationPosition())->toBe(SubNavigationPosition::Start);
    });

    it('handles enum plugin result for getSubNavigationPosition', function () {
        $plugin = new MockPlugin;
        $plugin->subNavigationPosition(SubNavigationPosition::Start);

        MockResource::setPlugin($plugin);

        expect(MockResource::getSubNavigationPosition())->toBe(SubNavigationPosition::Start);
    });

    it('handles all navigation methods with closures', function () {
        $plugin = new MockPlugin;
        $plugin->activeNavigationIcon(fn () => 'heroicon-s-closure')
            ->navigationParentItem(fn () => 'closure.parent')
            ->navigationBadgeColor(fn () => 'closure-color')
            ->slug(fn () => 'closure-slug')
            ->subNavigationPosition(fn () => SubNavigationPosition::End);

        MockResource::setPlugin($plugin);

        expect(MockResource::getActiveNavigationIcon())->toBe('heroicon-s-closure')
            ->and(MockResource::getNavigationParentItem())->toBe('closure.parent')
            ->and(MockResource::getNavigationBadgeColor())->toBe('closure-color')
            ->and(MockResource::getSlug())->toBe('closure-slug')
            ->and(MockResource::getSubNavigationPosition())->toBe(SubNavigationPosition::End);
    });
});
