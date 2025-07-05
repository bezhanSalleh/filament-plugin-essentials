<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;

beforeEach(function () {
    // Reset the plugin before each test
    MockResource::setPlugin(null);
});

describe('Resource HasLabels Delegation', function () {
    it('delegates getModelLabel to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->modelLabel('Plugin Model Label');

        MockResource::setPlugin($plugin);

        expect(MockResource::getModelLabel())->toBe('Plugin Model Label');
    });

    it('falls back to parent for getModelLabel when no plugin', function () {
        expect(MockResource::getModelLabel())->toBe('Default Model');
    });

    it('handles null plugin result for getModelLabel', function () {
        $plugin = new MockPlugin;
        $plugin->modelLabel(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getModelLabel())->toBe('');
    });

    it('delegates getPluralModelLabel to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->pluralModelLabel('Plugin Models');

        MockResource::setPlugin($plugin);

        expect(MockResource::getPluralModelLabel())->toBe('Plugin Models');
    });

    it('falls back to parent for getPluralModelLabel when no plugin', function () {
        expect(MockResource::getPluralModelLabel())->toBe('Default Models');
    });

    it('handles null plugin result for getPluralModelLabel', function () {
        $plugin = new MockPlugin;
        $plugin->pluralModelLabel(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getPluralModelLabel())->toBe('');
    });

    it('delegates getRecordTitleAttribute to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->recordTitleAttribute('name');

        MockResource::setPlugin($plugin);

        expect(MockResource::getRecordTitleAttribute())->toBe('name');
    });

    it('falls back to parent for getRecordTitleAttribute when no plugin', function () {
        expect(MockResource::getRecordTitleAttribute())->toBeNull();
    });

    it('handles null plugin result for getRecordTitleAttribute', function () {
        $plugin = new MockPlugin;
        $plugin->recordTitleAttribute(null);

        MockResource::setPlugin($plugin);

        expect(MockResource::getRecordTitleAttribute())->toBeNull();
    });

    it('delegates hasTitleCaseModelLabel to plugin when plugin has trait', function () {
        $plugin = new MockPlugin;
        $plugin->titleCaseModelLabel(false);

        MockResource::setPlugin($plugin);

        expect(MockResource::hasTitleCaseModelLabel())->toBeFalse();
    });

    it('falls back to parent for hasTitleCaseModelLabel when no plugin', function () {
        expect(MockResource::hasTitleCaseModelLabel())->toBeTrue();
    });

    it('handles closure values correctly for labels', function () {
        $plugin = new MockPlugin;
        $plugin->modelLabel(fn () => 'Dynamic Model')
            ->pluralModelLabel(fn () => 'Dynamic Models')
            ->recordTitleAttribute(fn () => 'title')
            ->titleCaseModelLabel(fn () => false);

        MockResource::setPlugin($plugin);

        expect(MockResource::getModelLabel())->toBe('Dynamic Model')
            ->and(MockResource::getPluralModelLabel())->toBe('Dynamic Models')
            ->and(MockResource::getRecordTitleAttribute())->toBe('title')
            ->and(MockResource::hasTitleCaseModelLabel())->toBeFalse();
    });
});
