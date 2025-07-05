<?php

use BezhanSalleh\PluginEssentials\Concerns\BelongsToParent;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    $this->testClass = new class
    {
        use BelongsToParent;
        use EvaluatesClosures;
    };
});

it('can set parent resource as string', function () {
    $parentResource = 'App\\Filament\\Resources\\TestResource';

    $result = $this->testClass->parentResource($parentResource);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getParentResource())->toBe($parentResource);
});

it('can set parent resource as closure', function () {
    $parentResource = 'App\\Filament\\Resources\\TestResource';

    $result = $this->testClass->parentResource($parentResource);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getParentResource())->toBe($parentResource);
});

it('can set parent resource as null', function () {
    $result = $this->testClass->parentResource(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getParentResource())->toBeNull();
});

it('returns fluent interface', function () {
    $result = $this->testClass->parentResource('TestResource');

    expect($result)->toBe($this->testClass);
});

it('has default null parent resource', function () {
    expect($this->testClass->getParentResource())->toBeNull();
});
