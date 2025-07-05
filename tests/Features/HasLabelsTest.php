<?php

use BezhanSalleh\PluginEssentials\Concerns\HasLabels;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    $this->testClass = new class
    {
        use EvaluatesClosures;
        use HasLabels;
    };
});

it('can set model label as string', function () {
    $label = 'User';

    $result = $this->testClass->modelLabel($label);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getModelLabel())->toBe($label);
});

it('can set model label as closure', function () {
    $label = 'User';

    $result = $this->testClass->modelLabel(fn () => $label);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getModelLabel())->toBe($label);
});

it('can set model label as null', function () {
    $result = $this->testClass->modelLabel(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getModelLabel())->toBeNull();
});

it('has default null model label', function () {
    expect($this->testClass->getModelLabel())->toBeNull();
});

it('can set plural model label as string', function () {
    $label = 'Users';

    $result = $this->testClass->pluralModelLabel($label);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getPluralModelLabel())->toBe($label);
});

it('can set plural model label as closure', function () {
    $label = 'Users';

    $result = $this->testClass->pluralModelLabel(fn () => $label);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getPluralModelLabel())->toBe($label);
});

it('can set plural model label as null', function () {
    $result = $this->testClass->pluralModelLabel(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getPluralModelLabel())->toBeNull();
});

it('has default null plural model label', function () {
    expect($this->testClass->getPluralModelLabel())->toBeNull();
});

it('can set title case model label as boolean', function () {
    $result = $this->testClass->titleCaseModelLabel(false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->hasTitleCaseModelLabel())->toBeFalse();
});

it('can set title case model label as closure', function () {
    $result = $this->testClass->titleCaseModelLabel(fn () => false);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->hasTitleCaseModelLabel())->toBeFalse();
});

it('has default true title case model label', function () {
    expect($this->testClass->hasTitleCaseModelLabel())->toBeTrue();
});

it('can set record title attribute as string', function () {
    $attribute = 'name';

    $result = $this->testClass->recordTitleAttribute($attribute);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getRecordTitleAttribute())->toBe($attribute);
});

it('can set record title attribute as closure', function () {
    $attribute = 'name';

    $result = $this->testClass->recordTitleAttribute(fn () => $attribute);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getRecordTitleAttribute())->toBe($attribute);
});

it('can set record title attribute as null', function () {
    $result = $this->testClass->recordTitleAttribute(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getRecordTitleAttribute())->toBeNull();
});

it('has default null record title attribute', function () {
    expect($this->testClass->getRecordTitleAttribute())->toBeNull();
});

it('evaluates closures properly', function () {
    $called = false;

    $this->testClass->modelLabel(function () use (&$called) {
        $called = true;

        return 'Test Label';
    });

    $result = $this->testClass->getModelLabel();

    expect($called)->toBeTrue()
        ->and($result)->toBe('Test Label');
});

it('returns fluent interface for all methods', function () {
    expect($this->testClass->modelLabel('User'))->toBe($this->testClass)
        ->and($this->testClass->pluralModelLabel('Users'))->toBe($this->testClass)
        ->and($this->testClass->titleCaseModelLabel(false))->toBe($this->testClass)
        ->and($this->testClass->recordTitleAttribute('name'))->toBe($this->testClass);
});

it('can chain multiple methods', function () {
    $result = $this->testClass
        ->modelLabel('Post')
        ->pluralModelLabel('Posts')
        ->titleCaseModelLabel(false)
        ->recordTitleAttribute('title');

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getModelLabel())->toBe('Post')
        ->and($this->testClass->getPluralModelLabel())->toBe('Posts')
        ->and($this->testClass->hasTitleCaseModelLabel())->toBeFalse()
        ->and($this->testClass->getRecordTitleAttribute())->toBe('title');
});
