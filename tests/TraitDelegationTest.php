<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\FullFeaturesTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Plugins\NoDefaultsTestPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\PostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});
describe('Trait Delegation with Real Plugin Registration', function () {

    it('delegates HasLabels when used and fallbacks to defaults', function () {
        $this->panel
            ->plugins([
                FullFeaturesTestPlugin::make(),
            ]);
        $resource = $this->panel->getResources()[0];

        expect($resource::getModelLabel())->toBe('user');
        expect($resource::getPluralModelLabel())->toBe('users');
        expect($resource::getRecordTitleAttribute())->toBeNull();
        expect($resource::hasTitleCaseModelLabel())->toBeTrue();

        $this->panel
            ->plugins([
                FullFeaturesTestPlugin::make()
                    ->modelLabel('Full Item')
                    ->pluralModelLabel('Full Items')
                    ->recordTitleAttribute('name')
                // ->titleCaseModelLabel(false)
                ,
            ]);

        expect($resource::getModelLabel())->toBe('Full Item');
        expect($resource::getPluralModelLabel())->toBe('Full Items');
        expect($resource::getRecordTitleAttribute())->toBe('name');
        expect($resource::hasTitleCaseModelLabel())->toBeTrue();
    });

    it('delegates to plugin when plugin has defaults', function () {

        $this->panel
            ->plugins([
                FullFeaturesTestPlugin::make(),
            ]);
        $userResource = $this->panel->getResources()[0];

        expect($userResource::getTenantRelationshipName())->toBe('users');
        expect($userResource::getTenantOwnershipRelationshipName())->toBeEmpty();

        $this->panel
            ->plugins([
                FullFeaturesTestPlugin::make()
                    ->tenantRelationshipName('organization')
                    ->tenantOwnershipRelationshipName('owner'),
            ]);

        expect($userResource::getTenantRelationshipName())->toBe('organization');
        expect($userResource::getTenantOwnershipRelationshipName())->toBe('owner');
    });

    // it('falls back to Filament core when plugin has no defaults (BelongsToTenant)', function () {
    //     // Register plugin WITHOUT tenant defaults
    //     $panel = Filament::getCurrentOrDefaultPanel();
    //     $panel->plugins([
    //         NoDefaultsTestPlugin::make(),
    //     ]);

    //     // Should fall back to Filament's core logic which generates from model class
    //     // UserResource -> User model -> 'users' relationship name
    //     expect(UserResource::getTenantRelationshipName())->toBe('users');

    //     // Should fall back to Filament's getTenantOwnershipRelationshipName()
    //     // which returns the panel's default tenant ownership relationship name
    //     expect(UserResource::getTenantOwnershipRelationshipName())->toBeString();

    //     // Should fall back to Filament's default: true
    //     expect(UserResource::isScopedToTenant())->toBeTrue();
    // });

    // it('delegates to plugin when plugin has defaults (HasLabels)', function () {
    //     // Register plugin with label defaults
    //     $panel = Filament::getCurrentOrDefaultPanel();
    //     $panel->plugins([
    //         FullFeaturesTestPlugin::make(),
    //     ]);

    //     // This should use plugin's configured value: 'Full Item'
    //     expect(UserResource::getModelLabel())->toBe('Full Item');

    //     // This should use plugin's configured value: 'Full Items'
    //     expect(UserResource::getPluralModelLabel())->toBe('Full Items');

    //     // This should use plugin's configured value: 'title'
    //     expect(UserResource::getRecordTitleAttribute())->toBe('title');

    //     // This should use plugin's configured value: false
    //     expect(UserResource::hasTitleCaseModelLabel())->toBeFalse();
    // });

    // it('falls back to Filament core when plugin has no defaults (HasLabels)', function () {
    //     // Register plugin WITHOUT label defaults
    //     $panel = Filament::getCurrentOrDefaultPanel();
    //     $panel->plugins([
    //         NoDefaultsTestPlugin::make(),
    //     ]);

    //     // Should fall back to Filament's core logic which generates from model class
    //     // User model -> 'user' model label
    //     expect(UserResource::getModelLabel())->toBe('user');

    //     // User model -> 'users' plural model label
    //     expect(UserResource::getPluralModelLabel())->toBe('users');

    //     // Should fall back to Filament's default: null
    //     expect(UserResource::getRecordTitleAttribute())->toBeNull();

    //     // Should fall back to Filament's default: true
    //     expect(UserResource::hasTitleCaseModelLabel())->toBeTrue();
    // });

    // it('works correctly for different resource classes', function () {
    //     // Test with NoDefaults plugin to ensure Filament core fallback works for different models
    //     $panel = Filament::getCurrentOrDefaultPanel();
    //     $panel->plugins([
    //         NoDefaultsTestPlugin::make(),
    //     ]);

    //     // PostResource -> Post model -> 'posts' relationship name
    //     expect(PostResource::getTenantRelationshipName())->toBe('posts');

    //     // Post model -> 'post' model label
    //     expect(PostResource::getModelLabel())->toBe('post');

    //     // Post model -> 'posts' plural model label
    //     expect(PostResource::getPluralModelLabel())->toBe('posts');
    // });
});
