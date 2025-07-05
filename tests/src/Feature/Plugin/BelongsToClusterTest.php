<?php

use BezhanSalleh\PluginEssentials\Plugin\BelongsToCluster;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    $this->testClass = new class
    {
        use BelongsToCluster;
        use EvaluatesClosures;
    };
});

it('can set cluster as string', function () {
    $clusterClass = 'App\\Filament\\Clusters\\TestCluster';

    $result = $this->testClass->cluster($clusterClass);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getCluster())->toBe($clusterClass);
});

it('can set cluster as closure', function () {
    $clusterClass = 'App\\Filament\\Clusters\\TestCluster';

    $result = $this->testClass->cluster(fn () => $clusterClass);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getCluster())->toBe($clusterClass);
});

it('can set cluster as null', function () {
    $result = $this->testClass->cluster(null);

    expect($result)->toBe($this->testClass)
        ->and($this->testClass->getCluster())->toBeNull();
});

it('returns fluent interface', function () {
    $result = $this->testClass->cluster('TestCluster');

    expect($result)->toBe($this->testClass);
});

it('evaluates closure when getting cluster', function () {
    $called = false;

    $this->testClass->cluster(function () use (&$called) {
        $called = true;

        return 'App\\Filament\\Clusters\\TestCluster';
    });

    $cluster = $this->testClass->getCluster();

    expect($called)->toBeTrue()
        ->and($cluster)->toBe('App\\Filament\\Clusters\\TestCluster');
});

it('has default null cluster', function () {
    expect($this->testClass->getCluster())->toBeNull();
});
