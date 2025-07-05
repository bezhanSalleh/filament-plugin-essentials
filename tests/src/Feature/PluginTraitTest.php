<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MultiResourceEssentialPlugin;
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
    $this->plugin = Filament::getPlugin('bezhansalleh/essentials');
});

describe('Plugin HasNavigation Trait', function () {
    it('can set navigation icon as string', function () {
        $result = $this->plugin->navigationIcon('heroicon-s-test');

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationIcon())->toBe('heroicon-s-test');
    });

    it('can set navigation icon as closure', function () {
        $icon = 'heroicon-s-closure';
        $result = $this->plugin->navigationIcon(fn () => $icon);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationIcon())->toBe($icon);
    });

    it('can set navigation label as string', function () {
        $label = 'Test Label';
        $result = $this->plugin->navigationLabel($label);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationLabel())->toBe($label);
    });

    it('can set navigation label as closure', function () {
        $label = 'Closure Label';
        $result = $this->plugin->navigationLabel(fn () => $label);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationLabel())->toBe($label);
    });

    it('can set navigation group as string', function () {
        $group = 'Test Group';
        $result = $this->plugin->navigationGroup($group);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationGroup())->toBe($group);
    });

    it('can set navigation sort as integer', function () {
        $sort = 10;
        $result = $this->plugin->navigationSort($sort);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationSort())->toBe($sort);
    });

    it('can set active navigation icon', function () {
        $icon = 'heroicon-s-active';
        $result = $this->plugin->activeNavigationIcon($icon);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getActiveNavigationIcon())->toBe($icon);
    });

    it('can set navigation parent item', function () {
        $parent = 'parent.item';
        $result = $this->plugin->navigationParentItem($parent);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationParentItem())->toBe($parent);
    });

    it('can set navigation badge', function () {
        $badge = 'NEW';
        $result = $this->plugin->navigationBadge($badge);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationBadge())->toBe($badge);
    });

    it('can set navigation badge color', function () {
        $color = 'success';
        $result = $this->plugin->navigationBadgeColor($color);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationBadgeColor())->toBe($color);
    });

    it('can set slug', function () {
        $slug = 'test-slug';
        $result = $this->plugin->slug($slug);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getSlug())->toBe($slug);
    })
    ->todo();

    it('can set sub navigation position', function () {
        $position = SubNavigationPosition::Start;
        $result = $this->plugin->subNavigationPosition($position);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getSubNavigationPosition())->toBe($position);
    });

    it('can set register navigation', function () {
        $result = $this->plugin->registerNavigation(false);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->shouldRegisterNavigation())->toBeFalse();
    });

    it('supports method chaining', function () {
        $result = $this->plugin->navigationIcon('heroicon-s-test')
            ->navigationLabel('Test Label')
            ->navigationGroup('Test Group')
            ->navigationSort(10);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationIcon())->toBe('heroicon-s-test')
            ->and($this->plugin->getNavigationLabel())->toBe('Test Label')
            ->and($this->plugin->getNavigationGroup())->toBe('Test Group')
            ->and($this->plugin->getNavigationSort())->toBe(10);
    });

    it('evaluates closures properly', function () {
        $called = false;
        $this->plugin->navigationLabel(function () use (&$called) {
            $called = true;

            return 'Closure Label';
        });

        $label = $this->plugin->getNavigationLabel();

        expect($called)->toBeTrue()
            ->and($label)->toBe('Closure Label');
    });

    it('handles null values', function () {
        $result = $this->plugin->navigationIcon(null)
            ->navigationLabel(null)
            ->navigationGroup(null);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getNavigationIcon())->toBeNull()
            ->and($this->plugin->getNavigationLabel())->toBe('')
            ->and($this->plugin->getNavigationGroup())->toBeNull();
    });
});

describe('Plugin HasLabels Trait', function () {
    it('can set model label as string', function () {
        $label = 'Test Model';
        $result = $this->plugin->modelLabel($label);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getModelLabel())->toBe($label);
    });

    it('can set model label as closure', function () {
        $label = 'Closure Model';
        $result = $this->plugin->modelLabel(fn () => $label);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getModelLabel())->toBe($label);
    });

    it('can set plural model label', function () {
        $label = 'Test Models';
        $result = $this->plugin->pluralModelLabel($label);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getPluralModelLabel())->toBe($label);
    });

    it('can set record title attribute', function () {
        $attribute = 'title';
        $result = $this->plugin->recordTitleAttribute($attribute);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getRecordTitleAttribute())->toBe($attribute);
    });

    it('can set title case model label', function () {
        $result = $this->plugin->titleCaseModelLabel(false);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->hasTitleCaseModelLabel())->toBeFalse();
    });

    it('has default true title case model label', function () {
        expect($this->plugin->hasTitleCaseModelLabel())->toBeTrue();
    });

    it('supports method chaining for labels', function () {
        $result = $this->plugin->modelLabel('Test')
            ->pluralModelLabel('Tests')
            ->recordTitleAttribute('name')
            ->titleCaseModelLabel(false);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getModelLabel())->toBe('Test')
            ->and($this->plugin->getPluralModelLabel())->toBe('Tests')
            ->and($this->plugin->getRecordTitleAttribute())->toBe('name')
            ->and($this->plugin->hasTitleCaseModelLabel())->toBeFalse();
    });
});

describe('Plugin BelongsToCluster Trait', function () {
    it('can set cluster as string', function () {
        $clusterClass = 'App\\Filament\\Clusters\\UserCluster';
        $result = $this->plugin->cluster($clusterClass);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getCluster())->toBe($clusterClass);
    });

    it('can set cluster as closure', function () {
        $clusterClass = 'App\\Filament\\Clusters\\UserCluster';
        $result = $this->plugin->cluster(fn () => $clusterClass);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getCluster())->toBe($clusterClass);
    });

    it('can set cluster as null', function () {
        $result = $this->plugin->cluster(null);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getCluster())->toBeNull();
    });

    it('has default null cluster', function () {
        expect($this->plugin->getCluster())->toBeNull();
    });
});

describe('Plugin BelongsToParent Trait', function () {
    it('can set parent resource as string', function () {
        $parentClass = 'App\\Filament\\Resources\\ParentResource';
        $result = $this->plugin->parentResource($parentClass);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getParentResource())->toBe($parentClass);
    });

    it('can set parent resource as null', function () {
        $result = $this->plugin->parentResource(null);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getParentResource())->toBeNull();
    });

    it('has default null parent resource', function () {
        expect($this->plugin->getParentResource())->toBeNull();
    });
});

describe('Plugin BelongsToTenant Trait', function () {
    it('can set tenant scope', function () {
        $result = $this->plugin->scopeToTenant(true);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->shouldScopeToTenant())->toBeTrue();
    });

    it('can set tenant relationship name', function () {
        $name = 'tenant';
        $result = $this->plugin->tenantRelationshipName($name);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getTenantRelationshipName())->toBe($name);
    });

    it('can set tenant ownership relationship name', function () {
        $name = 'tenantOwner';
        $result = $this->plugin->tenantOwnershipRelationshipName($name);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getTenantOwnershipRelationshipName())->toBe($name);
    });

    it('has default true tenant scope', function () {
        expect($this->plugin->shouldScopeToTenant())->toBeTrue();
    });
});

describe('Plugin HasGlobalSearch Trait', function () {
    it('can set global search results limit', function () {
        $limit = 25;
        $result = $this->plugin->globalSearchResultsLimit($limit);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getGlobalSearchResultsLimit())->toBe($limit);
    });

    it('can set globally searchable', function () {
        $result = $this->plugin->globallySearchable(false);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->canGloballySearch())->toBeFalse();
    });

    it('can set force global search case insensitive', function () {
        $result = $this->plugin->forceGlobalSearchCaseInsensitive(true);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->isGlobalSearchForcedCaseInsensitive())->toBeTrue();
    });

    it('can set split global search terms', function () {
        $result = $this->plugin->splitGlobalSearchTerms(true);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->shouldSplitGlobalSearchTerms())->toBeTrue();
    });

    it('has default true globally searchable', function () {
        expect($this->plugin->canGloballySearch())->toBeTrue();
    });

    it('has default 50 global search results limit', function () {
        expect($this->plugin->getGlobalSearchResultsLimit())->toBe(50);
    });

    it('has default false split global search terms', function () {
        expect($this->plugin->shouldSplitGlobalSearchTerms())->toBeFalse();
    });
});

describe('Multi-Resource Plugin Support', function () {
    beforeEach(function () {
        $this->multiPlugin = MultiResourceEssentialPlugin::make();
    });

    describe('WithMultipleResourceSupport Trait', function () {
        it('can set contextual navigation properties for specific resources', function () {
            $this->multiPlugin
                ->resource(UserResource::class)
                ->navigationLabel('User Management')
                ->navigationGroup('Admin')
                ->navigationSort(10)
                ->resource(PostResource::class)
                ->navigationLabel('Post Management')
                ->navigationGroup('Content')
                ->navigationSort(20);

            // Test UserResource context
            expect($this->multiPlugin->getNavigationLabel(UserResource::class))->toBe('User Management')
                ->and($this->multiPlugin->getNavigationGroup(UserResource::class))->toBe('Admin')
                ->and($this->multiPlugin->getNavigationSort(UserResource::class))->toBe(10);

            // Test PostResource context
            expect($this->multiPlugin->getNavigationLabel(PostResource::class))->toBe('Post Management')
                ->and($this->multiPlugin->getNavigationGroup(PostResource::class))->toBe('Content')
                ->and($this->multiPlugin->getNavigationSort(PostResource::class))->toBe(20);
        });

        it('can set contextual labels for specific resources', function () {
            $this->multiPlugin
                ->resource(UserResource::class)
                ->modelLabel('User')
                ->pluralModelLabel('Users')
                ->recordTitleAttribute('name')
                ->resource(PostResource::class)
                ->modelLabel('Article')
                ->pluralModelLabel('Articles')
                ->recordTitleAttribute('title');

            // Test UserResource context
            expect($this->multiPlugin->getModelLabel(UserResource::class))->toBe('User')
                ->and($this->multiPlugin->getPluralModelLabel(UserResource::class))->toBe('Users')
                ->and($this->multiPlugin->getRecordTitleAttribute(UserResource::class))->toBe('name');

            // Test PostResource context
            expect($this->multiPlugin->getModelLabel(PostResource::class))->toBe('Article')
                ->and($this->multiPlugin->getPluralModelLabel(PostResource::class))->toBe('Articles')
                ->and($this->multiPlugin->getRecordTitleAttribute(PostResource::class))->toBe('title');
        });

        it('can set contextual cluster settings for specific resources', function () {
            $this->multiPlugin
                ->resource(UserResource::class)
                ->cluster('App\\Filament\\Clusters\\AdminCluster')
                ->resource(PostResource::class)
                ->cluster('App\\Filament\\Clusters\\ContentCluster');

            expect($this->multiPlugin->getCluster(UserResource::class))->toBe('App\\Filament\\Clusters\\AdminCluster')
                ->and($this->multiPlugin->getCluster(PostResource::class))->toBe('App\\Filament\\Clusters\\ContentCluster');
        });

        it('can set contextual tenant settings for specific resources', function () {
            $this->multiPlugin
                ->resource(UserResource::class)
                ->scopeToTenant(false)
                ->tenantRelationshipName('organization')
                ->resource(PostResource::class)
                ->scopeToTenant(true)
                ->tenantRelationshipName('tenant');

            expect($this->multiPlugin->shouldScopeToTenant(UserResource::class))->toBeFalse()
                ->and($this->multiPlugin->getTenantRelationshipName(UserResource::class))->toBe('organization')
                ->and($this->multiPlugin->shouldScopeToTenant(PostResource::class))->toBeTrue()
                ->and($this->multiPlugin->getTenantRelationshipName(PostResource::class))->toBe('tenant');
        });

        it('can set contextual global search settings for specific resources', function () {
            $this->multiPlugin
                ->resource(UserResource::class)
                ->globallySearchable(true)
                ->globalSearchResultsLimit(25)
                ->splitGlobalSearchTerms(true)
                ->resource(PostResource::class)
                ->globallySearchable(false)
                ->globalSearchResultsLimit(10)
                ->splitGlobalSearchTerms(false);

            expect($this->multiPlugin->canGloballySearch(UserResource::class))->toBeTrue()
                ->and($this->multiPlugin->getGlobalSearchResultsLimit(UserResource::class))->toBe(25)
                ->and($this->multiPlugin->shouldSplitGlobalSearchTerms(UserResource::class))->toBeTrue()
                ->and($this->multiPlugin->canGloballySearch(PostResource::class))->toBeFalse()
                ->and($this->multiPlugin->getGlobalSearchResultsLimit(PostResource::class))->toBe(10)
                ->and($this->multiPlugin->shouldSplitGlobalSearchTerms(PostResource::class))->toBeFalse();
        });

        it('can set contextual parent resource settings', function () {
            $this->multiPlugin
                ->resource(UserResource::class)
                ->parentResource('App\\Filament\\Resources\\OrganizationResource')
                ->resource(PostResource::class)
                ->parentResource('App\\Filament\\Resources\\CategoryResource');

            expect($this->multiPlugin->getParentResource(UserResource::class))->toBe('App\\Filament\\Resources\\OrganizationResource')
                ->and($this->multiPlugin->getParentResource(PostResource::class))->toBe('App\\Filament\\Resources\\CategoryResource');
        });

        it('returns null for unset resource contexts', function () {
            // Set properties for UserResource only
            $this->multiPlugin
                ->resource(UserResource::class)
                ->navigationLabel('User Management')
                ->modelLabel('User');

            // PostResource should return null for unset properties
            expect($this->multiPlugin->getNavigationLabel(PostResource::class))->toBe('')
                ->and($this->multiPlugin->getModelLabel(PostResource::class))->toBeNull();
        });

        it('supports fluent method chaining across different resources', function () {
            $result = $this->multiPlugin
                ->resource(UserResource::class)
                ->navigationLabel('Users')
                ->navigationGroup('Admin')
                ->modelLabel('User')
                ->globallySearchable(true)
                ->resource(PostResource::class)
                ->navigationLabel('Posts')
                ->navigationGroup('Content')
                ->modelLabel('Post')
                ->globallySearchable(false);

            expect($result)->toBe($this->multiPlugin);

            // Verify all properties were set correctly
            expect($this->multiPlugin->getNavigationLabel(UserResource::class))->toBe('Users')
                ->and($this->multiPlugin->getNavigationGroup(UserResource::class))->toBe('Admin')
                ->and($this->multiPlugin->getModelLabel(UserResource::class))->toBe('User')
                ->and($this->multiPlugin->canGloballySearch(UserResource::class))->toBeTrue()
                ->and($this->multiPlugin->getNavigationLabel(PostResource::class))->toBe('Posts')
                ->and($this->multiPlugin->getNavigationGroup(PostResource::class))->toBe('Content')
                ->and($this->multiPlugin->getModelLabel(PostResource::class))->toBe('Post')
                ->and($this->multiPlugin->canGloballySearch(PostResource::class))->toBeFalse();
        });

        it('can handle closures in contextual properties', function () {
            $userLabelCalled = false;
            $postLabelCalled = false;

            $this->multiPlugin
                ->resource(UserResource::class)
                ->navigationLabel(function () use (&$userLabelCalled) {
                    $userLabelCalled = true;

                    return 'Dynamic User Label';
                })
                ->resource(PostResource::class)
                ->navigationLabel(function () use (&$postLabelCalled) {
                    $postLabelCalled = true;

                    return 'Dynamic Post Label';
                });

            // Get labels to trigger closures
            $userLabel = $this->multiPlugin->getNavigationLabel(UserResource::class);
            $postLabel = $this->multiPlugin->getNavigationLabel(PostResource::class);

            expect($userLabelCalled)->toBeTrue()
                ->and($postLabelCalled)->toBeTrue()
                ->and($userLabel)->toBe('Dynamic User Label')
                ->and($postLabel)->toBe('Dynamic Post Label');
        });
    });

    describe('Single-Resource Plugin Compatibility', function () {
        it('single-resource plugin works without WithMultipleResourceSupport trait', function () {
            // EssentialPlugin doesn't use WithMultipleResourceSupport
            $singlePlugin = EssentialPlugin::make();

            $result = $singlePlugin
                ->navigationLabel('Single Resource Label')
                ->navigationGroup('Single Group')
                ->modelLabel('Single Model');

            expect($result)->toBe($singlePlugin)
                ->and($singlePlugin->getNavigationLabel())->toBe('Single Resource Label')
                ->and($singlePlugin->getNavigationGroup())->toBe('Single Group')
                ->and($singlePlugin->getModelLabel())->toBe('Single Model');
        });

        it('multi-resource plugin can still be used without resource context for backward compatibility', function () {
            // When no resource context is set, should work like single-resource
            $result = $this->multiPlugin
                ->navigationLabel('Global Label')
                ->modelLabel('Global Model');

            expect($result)->toBe($this->multiPlugin)
                ->and($this->multiPlugin->getNavigationLabel())->toBe('Global Label')
                ->and($this->multiPlugin->getModelLabel())->toBe('Global Model');
        });
    });
});
