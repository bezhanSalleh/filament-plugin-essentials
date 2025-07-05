<?php

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;
use Filament\Pages\Enums\SubNavigationPosition;

beforeEach(function () {
    $this->plugin = EssentialPlugin::make();
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
    });

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
        $clusterClass = 'App\\Filament\\Clusters\\TestCluster';
        $result = $this->plugin->cluster($clusterClass);

        expect($result)->toBe($this->plugin)
            ->and($this->plugin->getCluster())->toBe($clusterClass);
    });

    it('can set cluster as closure', function () {
        $clusterClass = 'App\\Filament\\Clusters\\TestCluster';
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
