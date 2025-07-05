<?php

use BezhanSalleh\PluginEssentials\Concerns\BelongsToTenant;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    $this->testClass = new class
    {
        use BelongsToTenant;
        use EvaluatesClosures;
    };
});

it('can set tenant scope as boolean', function () {
    $result = $this->testClass->scopeToTenant(false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->isScopedToTenant())->toBeFalse();
});

it('can set tenant scope as closure', function () {
    $result = $this->testClass->scopeToTenant(fn () => false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->isScopedToTenant())->toBeFalse();
});

it('has default true tenant scope', function () {
    expect($this->testClass->isScopedToTenant())->toBeTrue();
});

it('can set tenant ownership relationship name as string', function () {
    $relationshipName = 'organization';

    $result = $this->testClass->tenantOwnershipRelationshipName($relationshipName);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getTenantOwnershipRelationshipName())->toBe($relationshipName);
});

it('can set tenant ownership relationship name as closure', function () {
    $relationshipName = 'organization';

    $result = $this->testClass->tenantOwnershipRelationshipName(fn () => $relationshipName);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getTenantOwnershipRelationshipName())->toBe($relationshipName);
});

it('can set tenant ownership relationship name as null', function () {
    $result = $this->testClass->tenantOwnershipRelationshipName(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getTenantOwnershipRelationshipName())->toBeNull();
});

it('can set tenant relationship name as string', function () {
    $relationshipName = 'tenant';

    $result = $this->testClass->tenantRelationshipName($relationshipName);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getTenantRelationshipName())->toBe($relationshipName);
});

it('can set tenant relationship name as closure', function () {
    $relationshipName = 'tenant';

    $result = $this->testClass->tenantRelationshipName(fn () => $relationshipName);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getTenantRelationshipName())->toBe($relationshipName);
});

it('can set tenant relationship name as null', function () {
    $result = $this->testClass->tenantRelationshipName(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getTenantRelationshipName())->toBeNull();
});

it('evaluates closures properly', function () {
    $called = false;

    $this->testClass->scopeToTenant(function () use (&$called) {
        $called = true;

        return false;
    });

    $result = $this->testClass->isScopedToTenant();

    expect($called)->toBeTrue()
        ->and($result)->toBeFalse();
});

it('has default null relationship names', function () {
    expect($this->testClass->getTenantOwnershipRelationshipName())->toBeNull()
        ->and($this->testClass->getTenantRelationshipName())->toBeNull();
});

it('returns fluent interface for all methods', function () {
    expect($this->testClass->scopeToTenant(true))->toBe($this->testClass)
        ->and($this->testClass->tenantOwnershipRelationshipName('test'))->toBe($this->testClass)
        ->and($this->testClass->tenantRelationshipName('test'))->toBe($this->testClass);
});
