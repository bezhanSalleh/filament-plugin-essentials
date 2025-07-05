<?php

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockPlugin;
use BezhanSalleh\PluginEssentials\Tests\Fixtures\MockResource;
use Filament\Support\Concerns\EvaluatesClosures;

beforeEach(function () {
    // Create a mock plugin that uses the plugin traits
    $this->mockPlugin = new MockPlugin;

    // Create a mock resource that uses the resource traits
    $this->mockResource = new MockResource;
    $this->mockResource::setPlugin($this->mockPlugin);
});

describe('Conditional Plugin Delegation', function () {
    it('delegates to plugin when plugin has matching trait', function () {
        // Configure plugin
        $this->mockPlugin->navigationLabel('Plugin Label');

        // Resource should use plugin value
        expect($this->mockResource::getNavigationLabel())->toBe('Plugin Label');
    });

    it('falls back to parent when plugin does not have matching trait', function () {
        // Create resource without pluginEssential method
        $resourceWithoutPlugin = new class
        {
            use HasNavigation;

            public static function getParentResult($method)
            {
                return 'Parent Label';
            }
        };

        expect($resourceWithoutPlugin::getNavigationLabel())->toBe('Parent Label');
    });

    it('falls back to parent when plugin is null', function () {
        $resourceWithNullPlugin = new class
        {
            use HasNavigation;

            public static function pluginEssential(): ?object
            {
                return null;
            }

            public static function getParentResult($method)
            {
                return 'Parent Label';
            }
        };

        expect($resourceWithNullPlugin::getNavigationLabel())->toBe('Parent Label');
    });

    it('handles multiple trait methods correctly', function () {
        // Configure plugin with multiple values
        $this->mockPlugin
            ->navigationLabel('Plugin Nav Label')
            ->navigationIcon('plugin-icon')
            ->modelLabel('Plugin Model Label')
            ->cluster('PluginCluster');

        // All methods should delegate to plugin
        expect($this->mockResource::getNavigationLabel())->toBe('Plugin Nav Label')
            ->and($this->mockResource::getNavigationIcon())->toBe('plugin-icon')
            ->and($this->mockResource::getModelLabel())->toBe('Plugin Model Label')
            ->and($this->mockResource::getCluster())->toBe('PluginCluster');
    });

    it('evaluates closures correctly', function () {
        // Configure plugin with closure
        $this->mockPlugin->navigationLabel(fn () => 'Dynamic Label');

        expect($this->mockResource::getNavigationLabel())->toBe('Dynamic Label');
    });

    it('handles exceptions gracefully', function () {
        // Create resource that throws exception in pluginEssential
        $resourceWithException = new class
        {
            use HasNavigation;

            public static function pluginEssential(): ?object
            {
                throw new Exception('Plugin error');
            }

            public static function getParentResult($method)
            {
                return 'Parent Label';
            }
        };

        // Should fall back to parent without throwing
        expect($resourceWithException::getNavigationLabel())->toBe('Parent Label');
    });
});

describe('Trait Detection', function () {
    it('correctly identifies when plugin uses trait', function () {
        $resource = new class
        {
            use HasNavigation;

            public static function pluginEssential(): ?object
            {
                return test()->mockPlugin;
            }
        };

        // Plugin has HasNavigation trait, so it should be detected
        expect($resource::pluginUsesTrait($this->mockPlugin, 'HasNavigation'))->toBeTrue();
    });

    it('correctly identifies when plugin does not use trait', function () {
        $pluginWithoutTrait = new class
        {
            use EvaluatesClosures;
        };

        $resource = new class
        {
            use HasNavigation;

            public static function pluginEssential(): ?object
            {
                return test()->pluginWithoutTrait;
            }
        };

        expect($resource::pluginUsesTrait($pluginWithoutTrait, 'HasNavigation'))->toBeFalse();
    });
});

describe('Method Fallbacks', function () {
    it('provides correct default values for navigation methods', function () {
        $resourceWithoutPlugin = new class
        {
            use HasNavigation;

            public static function getParentResult($method)
            {
                return match ($method) {
                    'shouldRegisterNavigation' => true,
                    'getNavigationLabel' => '',
                    default => null,
                };
            }
        };

        expect($resourceWithoutPlugin::shouldRegisterNavigation())->toBeTrue()
            ->and($resourceWithoutPlugin::getNavigationLabel())->toBe('');
    });

    it('provides correct default values for global search methods', function () {
        $resourceWithoutPlugin = new class
        {
            use \BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;

            public static function getParentResult($method)
            {
                return match ($method) {
                    'canGloballySearch' => true,
                    'getGlobalSearchResultsLimit' => 50,
                    'shouldSplitGlobalSearchTerms' => false,
                    default => null,
                };
            }
        };

        expect($resourceWithoutPlugin::canGloballySearch())->toBeTrue()
            ->and($resourceWithoutPlugin::getGlobalSearchResultsLimit())->toBe(50)
            ->and($resourceWithoutPlugin::shouldSplitGlobalSearchTerms())->toBeFalse();
    });
});
