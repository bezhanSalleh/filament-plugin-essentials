<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\PostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;
use Filament\Pages\Enums\SubNavigationPosition;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
    $this->panel
        ->plugins([
            EssentialPlugin::make(),
        ]);
});

describe('Resource HasNavigation Trait', function () {
    it('resources have navigation methods from traits', function () {
        // Test that resources have the expected navigation methods from traits
        $userResourceMethods = get_class_methods(UserResource::class);
        $postResourceMethods = get_class_methods(PostResource::class);

        $expectedMethods = [
            'getNavigationIcon',
            'getNavigationLabel',
            'getNavigationGroup',
            'getNavigationSort',
            'getNavigationBadge',
            'getNavigationBadgeColor',
            'getNavigationParentItem',
            'getActiveNavigationIcon',
            'shouldRegisterNavigation',
            'getSubNavigationPosition',
            'getSlug',
        ];

        foreach ($expectedMethods as $method) {
            expect(in_array($method, $userResourceMethods))->toBeTrue("UserResource should have {$method} method");
            expect(in_array($method, $postResourceMethods))->toBeTrue("PostResource should have {$method} method");
        }
    });

    it('can call navigation methods on resources', function () {
        // Test that the navigation methods can be called (will delegate to plugin or fall back to parent)
        expect(UserResource::getNavigationIcon())->toBeNull();
        expect(UserResource::getNavigationLabel())->toBeString();
        expect(UserResource::getNavigationGroup())->toBeNull();
        expect(UserResource::getNavigationSort())->toBeNull();
        expect(UserResource::shouldRegisterNavigation())->toBeBool();
        expect(UserResource::getSubNavigationPosition())->toBeInstanceOf(SubNavigationPosition::class);

        expect(PostResource::getNavigationIcon())->toBeNull();
        expect(PostResource::getNavigationLabel())->toBeString();
        expect(PostResource::getNavigationGroup())->toBeNull();
        expect(PostResource::getNavigationSort())->toBeNull();
        expect(PostResource::shouldRegisterNavigation())->toBeBool();
        expect(PostResource::getSubNavigationPosition())->toBeInstanceOf(SubNavigationPosition::class);
    });

    it('delegates to plugin when plugin has navigation trait', function () {
        // This test verifies that the delegation system works
        // The actual plugin configuration will be tested in multi-forResource support
        expect(method_exists(UserResource::class, 'getEssentialsPlugin'))->toBeTrue();
        expect(method_exists(PostResource::class, 'getEssentialsPlugin'))->toBeTrue();

        // Verify the plugin is accessible
        expect(UserResource::getEssentialsPlugin())->toBeInstanceOf(EssentialPlugin::class);
    });
});

describe('Resource HasLabels Trait', function () {
    it('resources have label methods from traits', function () {
        $userResourceMethods = get_class_methods(UserResource::class);
        $postResourceMethods = get_class_methods(PostResource::class);

        $expectedMethods = [
            'getModelLabel',
            'getPluralModelLabel',
            'getRecordTitleAttribute',
            'hasTitleCaseModelLabel',
        ];

        foreach ($expectedMethods as $method) {
            expect(in_array($method, $userResourceMethods))->toBeTrue("UserResource should have {$method} method");
            expect(in_array($method, $postResourceMethods))->toBeTrue("PostResource should have {$method} method");
        }
    });

    it('can call label methods on resources', function () {
        // Note: Resource parent class provides default implementations
        expect(UserResource::getModelLabel())->toBe('Essential Item (Method)');  // Plugin method override
        expect(UserResource::getPluralModelLabel())->toBe('Essential Items');  // Plugin default from array
        expect(UserResource::getRecordTitleAttribute())->toBe('id'); // Plugin default from array
        expect(UserResource::hasTitleCaseModelLabel())->toBeFalse(); // Plugin default from array

        expect(PostResource::getModelLabel())->toBe('post');  // Filament default (no plugin delegation)
        expect(PostResource::getPluralModelLabel())->toBe('posts');  // Filament default (no plugin delegation)
        expect(PostResource::getRecordTitleAttribute())->toBeNull(); // Filament default (no plugin delegation)
        expect(PostResource::hasTitleCaseModelLabel())->toBeTrue(); // Filament default (no plugin delegation)
    });
});

describe('Resource BelongsToParent Trait', function () {
    it('resources have parent methods from traits', function () {
        $userResourceMethods = get_class_methods(UserResource::class);
        $postResourceMethods = get_class_methods(PostResource::class);

        $expectedMethods = [
            'getParentResource',
        ];

        foreach ($expectedMethods as $method) {
            expect(in_array($method, $userResourceMethods))->toBeTrue("UserResource should have {$method} method");
            expect(in_array($method, $postResourceMethods))->toBeTrue("PostResource should have {$method} method");
        }
    });

    it('can call parent methods on resources', function () {
        expect(UserResource::getParentResource())->toBeNull();
        expect(PostResource::getParentResource())->toBeNull();
    });
});

describe('Resource BelongsToTenant Trait', function () {
    it('resources have tenant methods from traits', function () {
        $userResourceMethods = get_class_methods(UserResource::class);
        $postResourceMethods = get_class_methods(PostResource::class);

        $expectedMethods = [
            'isScopedToTenant',
            'getTenantRelationshipName',
            'getTenantOwnershipRelationshipName',
        ];

        foreach ($expectedMethods as $method) {
            expect(in_array($method, $userResourceMethods))->toBeTrue("UserResource should have {$method} method");
            expect(in_array($method, $postResourceMethods))->toBeTrue("PostResource should have {$method} method");
        }
    });

    it('can call tenant methods on resources', function () {
        expect(UserResource::isScopedToTenant())->toBeBool();
        expect(UserResource::getTenantRelationshipName())->toBeString();
        expect(UserResource::getTenantOwnershipRelationshipName())->toBeString();

        expect(PostResource::isScopedToTenant())->toBeBool();
        expect(PostResource::getTenantRelationshipName())->toBeString();
        expect(PostResource::getTenantOwnershipRelationshipName())->toBeString();
    });
});

describe('Resource HasGlobalSearch Trait', function () {
    it('resources have global search methods from traits', function () {
        $userResourceMethods = get_class_methods(UserResource::class);
        $postResourceMethods = get_class_methods(PostResource::class);

        $expectedMethods = [
            'getGloballySearchableAttributes',
            'getGlobalSearchResultTitle',
            'getGlobalSearchResultDetails',
            'getGlobalSearchResultActions',
            'getGlobalSearchResultUrl',
            'getGlobalSearchEloquentQuery',
            'canGloballySearch',
        ];

        foreach ($expectedMethods as $method) {
            expect(in_array($method, $userResourceMethods))->toBeTrue("UserResource should have {$method} method");
            expect(in_array($method, $postResourceMethods))->toBeTrue("PostResource should have {$method} method");
        }
    });

    it('can call global search methods on resources', function () {
        expect(UserResource::getGloballySearchableAttributes())->toBeArray();
        expect(UserResource::canGloballySearch())->toBeBool();

        expect(PostResource::getGloballySearchableAttributes())->toBeArray();
        expect(PostResource::canGloballySearch())->toBeBool();
    });
});
