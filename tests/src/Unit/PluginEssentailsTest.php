<?php

use BezhanSalleh\PluginEssentials\Facades\PluginEssentials;
use BezhanSalleh\PluginEssentials\PluginEssentials as PluginEssentialsClass;

it('resolves the correct facade accessor', function () {
    $facade = new PluginEssentials;
    $reflection = new ReflectionClass($facade);
    $method = $reflection->getMethod('getFacadeAccessor');
    $method->setAccessible(true);

    $accessor = $method->invoke($facade);

    expect($accessor)->toBe(PluginEssentialsClass::class);
});

it('\s facade can be resolved from container', function () {
    // This test ensures the facade can be resolved properly
    // The service provider should bind the class to the container
    $instance = app(PluginEssentialsClass::class);

    expect($instance)->toBeInstanceOf(PluginEssentialsClass::class);
});

it('\s facade returns same instance as container', function () {
    $containerInstance = app(PluginEssentialsClass::class);

    $reflection = new ReflectionClass(PluginEssentials::class);
    $method = $reflection->getMethod('getFacadeAccessor');
    $method->setAccessible(true);
    $accessor = $method->invoke(null);

    $facadeInstance = app($accessor);

    expect($facadeInstance)->toBe($containerInstance)
        ->and($facadeInstance)->toBeInstanceOf(PluginEssentialsClass::class);
});

it('\s facade is registered as singleton', function () {
    $instance1 = app(PluginEssentialsClass::class);
    $instance2 = app(PluginEssentialsClass::class);

    expect($instance1)->toBe($instance2);
});
