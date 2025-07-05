<?php

require_once __DIR__ . '/vendor/autoload.php';

use BezhanSalleh\PluginEssentials\Tests\Fixtures\EssentialPlugin;

// Create a plugin with defaults
$plugin = new class extends EssentialPlugin
{
    protected function getPluginDefaults(): array
    {
        return [
            'globalSearchResultsLimit' => 100,
            'isGloballySearchable' => false,
        ];
    }

    public function getId(): string
    {
        return 'bezhansalleh/essentials';
    }
};

echo "Testing plugin defaults...\n";
echo 'Plugin globalSearchResultsLimit: ' . $plugin->getGlobalSearchResultsLimit() . "\n";
echo 'Plugin isGloballySearchable: ' . ($plugin->isGloballySearchable() ? 'true' : 'false') . "\n";

// Test calling with resource class
echo "\nTesting with resource class...\n";
echo 'Plugin globalSearchResultsLimit(UserResource::class): ' . $plugin->getGlobalSearchResultsLimit('UserResource') . "\n";
echo 'Plugin isGloballySearchable(UserResource::class): ' . ($plugin->isGloballySearchable('UserResource') ? 'true' : 'false') . "\n";
