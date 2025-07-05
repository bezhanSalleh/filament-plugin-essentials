<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MultiResourceEssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Admin\AdminResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Posts\PostResource;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\Resources\Users\UserResource;
use Filament\Facades\Filament;
use Filament\Pages\Enums\SubNavigationPosition;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

describe('Plugin Registration', function () {
    it('can register the plugin', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(),
            ]);

        expect(Filament::getPlugin('bezhansalleh/essentials'))->toBeInstanceOf(EssentialPlugin::class);
    });

    it('can register multi-resource plugin', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make(),
            ]);

        expect(Filament::getPlugin('bezhansalleh/essentials-multi'))->toBeInstanceOf(MultiResourceEssentialPlugin::class);
    });
});

describe('Plugin HasLabels Trait', function () {
    it('sets all custom labels', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->modelLabel('Custom User')
                    ->pluralModelLabel('Custom Users')
                    ->recordTitleAttribute('email')
                    ->titleCaseModelLabel(false),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test plugin getter methods
        expect($plugin->getModelLabel())->toBe('Custom User')
            ->and($plugin->getPluralModelLabel())->toBe('Custom Users')
            ->and($plugin->getRecordTitleAttribute())->toBe('email')
            ->and($plugin->hasTitleCaseModelLabel())->toBeFalse();

        // Test that resources delegate to plugin and receive values
        expect(UserResource::getModelLabel())->toBe('Custom User')
            ->and(UserResource::getPluralModelLabel())->toBe('Custom Users')
            ->and(UserResource::getRecordTitleAttribute())->toBe('email')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeFalse();
    });

    it('uses mixed labels and defaults', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->modelLabel('Person')
                    ->recordTitleAttribute('name'),
                // pluralModelLabel and titleCaseModelLabel use defaults
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test plugin getter methods - mixed custom and defaults
        expect($plugin->getModelLabel())->toBe('Person')
            ->and($plugin->getPluralModelLabel())->toBeNull() // Default null
            ->and($plugin->getRecordTitleAttribute())->toBe('name')
            ->and($plugin->hasTitleCaseModelLabel())->toBeTrue(); // Default true

        // Test that resources delegate to plugin and receive values
        expect(UserResource::getModelLabel())->toBe('Person')
            ->and(UserResource::getPluralModelLabel())->toBe('') // Default empty string
            ->and(UserResource::getRecordTitleAttribute())->toBe('name')
            ->and(UserResource::hasTitleCaseModelLabel())->toBeTrue(); // Default true
    });
});

describe('Plugin HasNavigation Trait', function () {
    it('sets all custom navigation', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->navigationLabel('User Management')
                    ->navigationIcon('heroicon-o-users')
                    ->activeNavigationIcon('heroicon-s-users')
                    ->navigationGroup('Admin')
                    ->navigationSort(10)
                    ->navigationBadge('NEW')
                    ->navigationBadgeColor('success')
                    ->navigationBadgeTooltip('New feature')
                    ->navigationParentItem('admin.dashboard')
                    ->subNavigationPosition(SubNavigationPosition::End)
                    ->registerNavigation(true),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test plugin getter methods
        expect($plugin->getNavigationLabel())->toBe('User Management')
            ->and($plugin->getNavigationIcon())->toBe('heroicon-o-users')
            ->and($plugin->getActiveNavigationIcon())->toBe('heroicon-s-users')
            ->and($plugin->getNavigationGroup())->toBe('Admin')
            ->and($plugin->getNavigationSort())->toBe(10)
            ->and($plugin->getNavigationBadge())->toBe('NEW')
            ->and($plugin->getNavigationBadgeColor())->toBe('success')
            ->and($plugin->getNavigationBadgeTooltip())->toBe('New feature')
            ->and($plugin->getNavigationParentItem())->toBe('admin.dashboard')
            ->and($plugin->getSubNavigationPosition())->toBe(SubNavigationPosition::End)
            ->and($plugin->shouldRegisterNavigation())->toBeTrue();

        // Test that resources delegate to plugin and receive values
        expect(UserResource::getNavigationLabel())->toBe('User Management')
            ->and(UserResource::getNavigationIcon())->toBe('heroicon-o-users')
            ->and(UserResource::getActiveNavigationIcon())->toBe('heroicon-s-users')
            ->and(UserResource::getNavigationGroup())->toBe('Admin')
            ->and(UserResource::getNavigationSort())->toBe(10)
            ->and(UserResource::getNavigationBadge())->toBe('NEW')
            ->and(UserResource::getNavigationBadgeColor())->toBe('success')
            ->and(UserResource::getNavigationBadgeTooltip())->toBe('New feature')
            ->and(UserResource::getNavigationParentItem())->toBe('admin.dashboard')
            ->and(UserResource::getSubNavigationPosition())->toBe(SubNavigationPosition::End)
            ->and(UserResource::shouldRegisterNavigation())->toBeTrue();
    });

    it('uses mixed navigation and defaults', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->navigationLabel('People')
                    ->navigationIcon('heroicon-o-user-group')
                    ->navigationSort(5),
                // Other navigation properties use defaults
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        // Test plugin getter methods - mixed custom and defaults
        expect($plugin->getNavigationLabel())->toBe('People')
            ->and($plugin->getNavigationIcon())->toBe('heroicon-o-user-group')
            ->and($plugin->getActiveNavigationIcon())->toBeNull() // Default null
            ->and($plugin->getNavigationGroup())->toBeNull() // Default null
            ->and($plugin->getNavigationSort())->toBe(5)
            ->and($plugin->getNavigationBadge())->toBeNull() // Default null
            ->and($plugin->getNavigationBadgeColor())->toBeNull() // Default null
            ->and($plugin->getNavigationBadgeTooltip())->toBeNull() // Default null
            ->and($plugin->getNavigationParentItem())->toBeNull() // Default null
            ->and($plugin->getSubNavigationPosition())->toBe(SubNavigationPosition::Start) // Default
            ->and($plugin->shouldRegisterNavigation())->toBeTrue(); // Default true

        // Test that resources delegate to plugin and receive values
        expect(UserResource::getNavigationLabel())->toBe('People')
            ->and(UserResource::getNavigationIcon())->toBe('heroicon-o-user-group')
            ->and(UserResource::getActiveNavigationIcon())->toBeNull() // Default null
            ->and(UserResource::getNavigationGroup())->toBeNull() // Default null
            ->and(UserResource::getNavigationSort())->toBe(5)
            ->and(UserResource::getNavigationBadge())->toBeNull() // Default null
            ->and(UserResource::getNavigationBadgeColor())->toBeNull() // Default null
            ->and(UserResource::getNavigationBadgeTooltip())->toBeNull() // Default null
            ->and(UserResource::getNavigationParentItem())->toBeNull() // Default null
            ->and(UserResource::getSubNavigationPosition())->toBe(SubNavigationPosition::Start) // Default
            ->and(UserResource::shouldRegisterNavigation())->toBeTrue(); // Default true
    });
});

describe('Plugin BelongsToCluster Trait', function () {
    it('sets custom cluster', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->cluster('App\\Filament\\Clusters\\UserCluster'),
            ]);

        $plugin = Filament::getPlugin('bezhansalleh/essentials');

        expect($plugin->getCluster())->toBe('App\\Filament\\Clusters\\UserCluster');
        expect(UserResource::getCluster())->toBe('App\\Filament\\Clusters\\UserCluster');
    });

    it('uses default cluster', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(), // No cluster configuration
            ]);

        expect(UserResource::getCluster())->toBeNull();
    });
});

describe('Plugin BelongsToParent Trait', function () {
    it('sets custom parent resource', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->parentResource('App\\Filament\\Resources\\OrganizationResource'),
            ]);

        expect(UserResource::getParentResource())->toBe('App\\Filament\\Resources\\OrganizationResource');
    });

    it('uses default parent resource', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(), // No parent resource configuration
            ]);

        expect(UserResource::getParentResource())->toBeNull();
    });
});

describe('Plugin BelongsToTenant Trait', function () {
    it('sets custom tenant properties', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->scopeToTenant(true)
                    ->tenantRelationshipName('organization')
                    ->tenantOwnershipRelationshipName('owner'),
            ]);

        expect(UserResource::isScopedToTenant())->toBeTrue()
            ->and(UserResource::getTenantRelationshipName())->toBe('organization')
            ->and(UserResource::getTenantOwnershipRelationshipName())->toBe('owner');
    });

    it('uses default tenant properties', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(), // No tenant configuration
            ]);

        // Default tenant scope is true, names are empty strings
        expect(UserResource::isScopedToTenant())->toBeTrue()
            ->and(UserResource::getTenantRelationshipName())->toBeString()
            ->and(UserResource::getTenantOwnershipRelationshipName())->toBeString();
    });
});

describe('Plugin HasGlobalSearch Trait', function () {
    it('sets custom global search properties', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make()
                    ->globallySearchable(true)
                    ->globalSearchResultsLimit(25)
                    ->forceGlobalSearchCaseInsensitive(true)
                    ->splitGlobalSearchTerms(true),
            ]);

        expect(UserResource::canGloballySearch())->toBeTrue()
            ->and(UserResource::getGlobalSearchResultsLimit())->toBe(25)
            ->and(UserResource::isGlobalSearchForcedCaseInsensitive())->toBeTrue()
            ->and(UserResource::shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    it('uses default global search properties', function () {
        $this->panel
            ->plugins([
                EssentialPlugin::make(), // No global search configuration
            ]);

        // Default values: searchable=true, limit=50, others=false/null
        expect(UserResource::canGloballySearch())->toBeTrue()
            ->and(UserResource::getGlobalSearchResultsLimit())->toBe(50)
            ->and(UserResource::isGlobalSearchForcedCaseInsensitive())->toBeNull()
            ->and(UserResource::shouldSplitGlobalSearchTerms())->toBeFalse();
    });
});

describe('Multi-Resource Plugin Support', function () {
    it('sets different labels per resource', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->modelLabel('System Admin')
                    ->pluralModelLabel('System Admins')
                    ->recordTitleAttribute('email')
                    ->resource(PostResource::class)
                    ->modelLabel('Blog Post')
                    ->pluralModelLabel('Blog Posts')
                    ->recordTitleAttribute('title'),
            ]);

        // Test that AdminResource gets its specific configuration
        expect(AdminResource::getModelLabel())->toBe('System Admin')
            ->and(AdminResource::getPluralModelLabel())->toBe('System Admins')
            ->and(AdminResource::getRecordTitleAttribute())->toBe('email');

        // Test that PostResource gets its specific configuration
        expect(PostResource::getModelLabel())->toBe('Blog Post')
            ->and(PostResource::getPluralModelLabel())->toBe('Blog Posts')
            ->and(PostResource::getRecordTitleAttribute())->toBe('title');
    });

    it('uses mixed resource configs and defaults', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->modelLabel('Administrator')
                        // Other properties use defaults
                    ->resource(PostResource::class)
                    ->pluralModelLabel('Articles')
                    ->recordTitleAttribute('slug'),
                // modelLabel uses default
            ]);

        // AdminResource gets partial config, others default
        expect(AdminResource::getModelLabel())->toBe('Administrator')
            ->and(AdminResource::getPluralModelLabel())->toBe('') // Default
            ->and(AdminResource::getRecordTitleAttribute())->toBeNull(); // Default

        // PostResource gets different partial config
        expect(PostResource::getModelLabel())->toBe('') // Default empty string
            ->and(PostResource::getPluralModelLabel())->toBe('Articles')
            ->and(PostResource::getRecordTitleAttribute())->toBe('slug');
    });

    it('sets different navigation per resource', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->navigationLabel('User Management')
                    ->navigationGroup('Admin')
                    ->navigationSort(10)
                    ->resource(PostResource::class)
                    ->navigationLabel('Blog Posts')
                    ->navigationGroup('Content')
                    ->navigationSort(20),
            ]);

        // AdminResource gets its specific navigation
        expect(AdminResource::getNavigationLabel())->toBe('User Management')
            ->and(AdminResource::getNavigationGroup())->toBe('Admin')
            ->and(AdminResource::getNavigationSort())->toBe(10);

        // PostResource gets its specific navigation
        expect(PostResource::getNavigationLabel())->toBe('Blog Posts')
            ->and(PostResource::getNavigationGroup())->toBe('Content')
            ->and(PostResource::getNavigationSort())->toBe(20);
    });

    it('uses mixed navigation configs and defaults', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->navigationLabel('Admins')
                    ->navigationSort(5)
                        // Group uses default
                    ->resource(PostResource::class)
                    ->navigationGroup('Publishing'),
                // Label and sort use defaults
            ]);

        // AdminResource gets partial navigation config
        expect(AdminResource::getNavigationLabel())->toBe('Admins')
            ->and(AdminResource::getNavigationGroup())->toBeNull() // Default
            ->and(AdminResource::getNavigationSort())->toBe(5);

        // PostResource gets different partial navigation config
        expect(PostResource::getNavigationLabel())->toBe('') // Default empty string
            ->and(PostResource::getNavigationGroup())->toBe('Publishing')
            ->and(PostResource::getNavigationSort())->toBeNull(); // Default
    });

    it('sets different cluster per resource', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->cluster('App\\Filament\\Clusters\\AdminCluster')
                    ->resource(PostResource::class)
                    ->cluster('App\\Filament\\Clusters\\ContentCluster'),
            ]);

        // Each resource gets its specific cluster
        expect(AdminResource::getCluster())->toBe('App\\Filament\\Clusters\\AdminCluster');
        expect(PostResource::getCluster())->toBe('App\\Filament\\Clusters\\ContentCluster');
    });

    it('sets different tenant settings per resource', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->scopeToTenant(true)
                    ->tenantRelationshipName('organization')
                    ->tenantOwnershipRelationshipName('owner')
                    ->resource(PostResource::class)
                    ->scopeToTenant(false)
                    ->tenantRelationshipName('company'),
            ]);

        // AdminResource gets its specific tenant config
        expect(AdminResource::isScopedToTenant())->toBeTrue()
            ->and(AdminResource::getTenantRelationshipName())->toBe('organization')
            ->and(AdminResource::getTenantOwnershipRelationshipName())->toBe('owner');

        // PostResource gets its specific tenant config
        expect(PostResource::isScopedToTenant())->toBeFalse()
            ->and(PostResource::getTenantRelationshipName())->toBe('company')
            ->and(PostResource::getTenantOwnershipRelationshipName())->toBeString(); // Default
    });

    it('sets different global search per resource', function () {
        $this->panel
            ->plugins([
                MultiResourceEssentialPlugin::make()
                    ->resource(AdminResource::class)
                    ->globallySearchable(true)
                    ->globalSearchResultsLimit(25)
                    ->forceGlobalSearchCaseInsensitive(true)
                    ->resource(PostResource::class)
                    ->globallySearchable(false)
                    ->globalSearchResultsLimit(10),
            ]);

        // AdminResource gets its specific global search config
        expect(AdminResource::canGloballySearch())->toBeTrue()
            ->and(AdminResource::getGlobalSearchResultsLimit())->toBe(25)
            ->and(AdminResource::isGlobalSearchForcedCaseInsensitive())->toBeTrue();

        // PostResource gets its specific global search config
        expect(PostResource::canGloballySearch())->toBeFalse()
            ->and(PostResource::getGlobalSearchResultsLimit())->toBe(10)
            ->and(PostResource::isGlobalSearchForcedCaseInsensitive())->toBeNull(); // Default
    });
});
