<?php

use BezhanSalleh\PluginEssentials\Concerns\HasGlobalSearch;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    $this->testClass = new class
    {
        use EvaluatesClosures;
        use HasGlobalSearch;
    };
});

it('can set global search results limit', function () {
    $limit = 100;

    $result = $this->testClass->globalSearchResultsLimit($limit);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getGlobalSearchResultsLimit())->toBe($limit);
});

it('has default global search results limit of 50', function () {
    expect($this->testClass->getGlobalSearchResultsLimit())->toBe(50);
});

it('can set globally searchable as boolean', function () {
    $result = $this->testClass->globallySearchable(false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->canGloballySearch())->toBeFalse();
});

it('can set globally searchable as closure', function () {
    $result = $this->testClass->globallySearchable(fn () => false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->canGloballySearch())->toBeFalse();
});

it('has default globally searchable as true', function () {
    expect($this->testClass->canGloballySearch())->toBeTrue();
});

it('can force global search case insensitive as boolean', function () {
    $result = $this->testClass->forceGlobalSearchCaseInsensitive(true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->isGlobalSearchForcedCaseInsensitive())->toBeTrue();
});

it('can force global search case insensitive as closure', function () {
    $result = $this->testClass->forceGlobalSearchCaseInsensitive(fn () => true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->isGlobalSearchForcedCaseInsensitive())->toBeTrue();
});

it('can force global search case insensitive as null', function () {
    $result = $this->testClass->forceGlobalSearchCaseInsensitive(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->isGlobalSearchForcedCaseInsensitive())->toBeNull();
});

it('has default null for forced case insensitive', function () {
    expect($this->testClass->isGlobalSearchForcedCaseInsensitive())->toBeNull();
});

it('can set split global search terms as boolean', function () {
    $result = $this->testClass->splitGlobalSearchTerms(true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->shouldSplitGlobalSearchTerms())->toBeTrue();
});

it('can set split global search terms as closure', function () {
    $result = $this->testClass->splitGlobalSearchTerms(fn () => true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->shouldSplitGlobalSearchTerms())->toBeTrue();
});

it('has default false for split global search terms', function () {
    expect($this->testClass->shouldSplitGlobalSearchTerms())->toBeFalse();
});

it('evaluates closures properly', function () {
    $called = false;

    $this->testClass->globallySearchable(function () use (&$called) {
        $called = true;

        return false;
    });

    $result = $this->testClass->canGloballySearch();

    expect($called)->toBeTrue()
        ->and($result)->toBeFalse();
});

it('returns fluent interface for all methods', function () {
    expect($this->testClass->globalSearchResultsLimit(100))->toBe($this->testClass)
        ->and($this->testClass->globallySearchable(true))->toBe($this->testClass)
        ->and($this->testClass->forceGlobalSearchCaseInsensitive(true))->toBe($this->testClass)
        ->and($this->testClass->splitGlobalSearchTerms(true))->toBe($this->testClass);
});

it('can chain multiple methods', function () {
    $result = $this->testClass
        ->globalSearchResultsLimit(75)
        ->globallySearchable(true)
        ->forceGlobalSearchCaseInsensitive(false)
        ->splitGlobalSearchTerms(true);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getGlobalSearchResultsLimit())->toBe(75)
        ->and($this->testClass->canGloballySearch())->toBeTrue()
        ->and($this->testClass->isGlobalSearchForcedCaseInsensitive())->toBeFalse()
        ->and($this->testClass->shouldSplitGlobalSearchTerms())->toBeTrue();
});
