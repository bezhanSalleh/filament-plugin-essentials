# Filament Plugin Essentials

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)

A collection of essential traits that streamline Filament plugin development by providing a standardized API for common plugin customization options.

This package provides powerful traits that plugin developers can use to offer end users a consistent and fluent interface for customizing their plugins. When users register your plugin in a panel, they can easily configure navigation, clustering, tenant management, global search, and labeling options.

## Installation

You can install the package via composer:

```bash
composer require bezhansalleh/filament-plugin-essentials
```

## Usage

### For Plugin Developers

Include these traits in your plugin class to provide users with standardized customization options:

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\HasLabels;
use Filament\Contracts\Plugin;
use Filament\Panel;

class YourPlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    
    public static function make(): static
    {
        return app(static::class);
    }
    
    public function getId(): string
    {
        return 'your-plugin';
    }
    
    public function register(Panel $panel): void
    {
        $panel->resources([
            YourResource::class,
        ]);
    }
    
    public function boot(Panel $panel): void
    {
        // Configure your resource with the trait values
        YourResource::navigationIcon($this->getNavigationIcon());
        YourResource::navigationLabel($this->getNavigationLabel());
        YourResource::navigationGroup($this->getNavigationGroup());
        // ... other configurations
    }
}
```

### For End Users

When registering a plugin in your panel, you can now customize it using the fluent interface:

```php
<?php

use YourVendor\YourPlugin\YourPlugin;

return [
    // ... other panel configuration
    
    'plugins' => [
        YourPlugin::make()
            ->navigationIcon('heroicon-s-sparkles')
            ->navigationLabel('Custom Label')
            ->navigationGroup('My Tools')
            ->navigationSort(10)
            ->navigationBadge(true)
            ->navigationBadgeColor('success'),
    ],
];
```

## Available Traits

### 🧭 HasNavigation

Provides comprehensive navigation customization options for your plugin's resources and pages.

**Available Methods:**
- `navigationLabel()` - Set custom navigation label
- `navigationIcon()` - Set navigation icon
- `activeNavigationIcon()` - Set active navigation icon
- `navigationGroup()` - Set navigation group
- `navigationSort()` - Set navigation sort order
- `navigationBadge()` - Enable/disable navigation badge
- `navigationBadgeColor()` - Set badge color
- `navigationBadgeTooltip()` - Set badge tooltip
- `registerNavigation()` - Control navigation registration
- `slug()` - Set custom slug

**Example Usage:**
```php
MyPlugin::make()
    ->navigationIcon('heroicon-o-users')
    ->navigationLabel('Team Members')
    ->navigationGroup('HR')
    ->navigationSort(5)
    ->navigationBadge(fn() => User::pending()->count() > 0)
    ->navigationBadgeColor('warning');
```

### 🏷️ HasLabels

Allows users to customize model labels and record titles.

**Available Methods:**
- `modelLabel()` - Set custom model label
- `pluralModelLabel()` - Set plural model label
- `recordTitleAttribute()` - Set record title attribute
- `titleCaseModelLabel()` - Control title case formatting

**Example Usage:**
```php
MyPlugin::make()
    ->modelLabel('Team Member')
    ->pluralModelLabel('Team Members')
    ->recordTitleAttribute('full_name')
    ->titleCaseModelLabel(false);
```

### 🔍 HasGlobalSearch

Enables customization of global search functionality.

**Available Methods:**
- `globallySearchable()` - Enable/disable global search
- `globalSearchResultsLimit()` - Set search results limit
- `forceGlobalSearchCaseInsensitive()` - Force case insensitive search
- `splitGlobalSearchTerms()` - Split search terms

**Example Usage:**
```php
MyPlugin::make()
    ->globallySearchable(true)
    ->globalSearchResultsLimit(25)
    ->forceGlobalSearchCaseInsensitive(true)
    ->splitGlobalSearchTerms(false);
```

### 🏢 BelongsToTenant

Provides tenant management configuration for multi-tenant applications.

**Available Methods:**
- `scopeToTenant()` - Enable/disable tenant scoping
- `tenantRelationshipName()` - Set tenant relationship name
- `tenantOwnershipRelationshipName()` - Set ownership relationship name

**Example Usage:**
```php
MyPlugin::make()
    ->scopeToTenant(true)
    ->tenantRelationshipName('organization')
    ->tenantOwnershipRelationshipName('owner');
```

### 🗂️ BelongsToCluster

Allows users to assign your plugin's resources to clusters.

**Available Methods:**
- `cluster()` - Set cluster class

**Example Usage:**
```php
MyPlugin::make()
    ->cluster(MyCluster::class);
```

### 👨‍👩‍👧‍👦 BelongsToParent

Enables parent-child resource relationships.

**Available Methods:**
- `parentResource()` - Set parent resource class

**Example Usage:**
```php
MyPlugin::make()
    ->parentResource(ParentResource::class);
```

## Features

### 🔄 Fluent Interface

All traits support method chaining for clean, readable plugin configuration:

```php
MyPlugin::make()
    ->navigationIcon('heroicon-o-cube')
    ->navigationLabel('Products')
    ->navigationGroup('Catalog')
    ->navigationSort(5)
    ->globallySearchable(true)
    ->globalSearchResultsLimit(50);
```

### 🎯 Closure Support

Most methods accept closures for dynamic values:

```php
MyPlugin::make()
    ->navigationLabel(fn() => auth()->user()->isAdmin() ? 'Admin Products' : 'Products')
    ->navigationBadge(fn() => Product::where('status', 'pending')->count() > 0)
    ->globallySearchable(fn() => auth()->user()->can('search_products'));
```

### 🎨 Type Safety

All traits are fully typed with proper PHPDoc annotations and union types for better IDE support and type checking.

### 📦 Standardized API

Provides a consistent interface across all Filament plugins that use these traits, making it easier for users to learn and configure multiple plugins.

## Implementation Example

Here's a complete example of how to implement these traits in your plugin:

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\HasGlobalSearch;
use Filament\Contracts\Plugin;
use Filament\Panel;

class YourPlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    use HasGlobalSearch;
    
    public static function make(): static
    {
        return app(static::class);
    }
    
    public function getId(): string
    {
        return 'your-plugin';
    }
    
    public function register(Panel $panel): void
    {
        $panel->resources([
            YourResource::class,
        ]);
    }
    
    public function boot(Panel $panel): void
    {
        // Apply user configurations to your resources
        YourResource::navigationIcon($this->getNavigationIcon());
        YourResource::navigationLabel($this->getNavigationLabel());
        YourResource::navigationGroup($this->getNavigationGroup());
        YourResource::modelLabel($this->getModelLabel());
        YourResource::globallySearchable($this->isGloballySearchable());
        // ... other configurations
    }
}
```

Then users can configure your plugin like this:

```php
YourPlugin::make()
    ->navigationIcon('heroicon-s-sparkles')
    ->navigationLabel('My Custom Plugin')
    ->navigationGroup('Custom Tools')
    ->modelLabel('Custom Item')
    ->globallySearchable(true)
    ->globalSearchResultsLimit(25);
```

## Method Reference

### Navigation Methods
- `navigationLabel(string|Closure|null $label)` - Set navigation label
- `navigationIcon(string|Closure|null $icon)` - Set navigation icon
- `activeNavigationIcon(string|Closure|null $icon)` - Set active navigation icon  
- `navigationGroup(string|Closure|null $group)` - Set navigation group
- `navigationSort(int|Closure|null $sort)` - Set navigation sort order
- `navigationBadge(bool|Closure $condition)` - Enable/disable navigation badge
- `navigationBadgeColor(string|array|Closure $color)` - Set badge color
- `navigationBadgeTooltip(string|Closure|null $tooltip)` - Set badge tooltip
- `registerNavigation(bool|Closure $condition)` - Control navigation registration
- `slug(string|Closure|null $slug)` - Set resource slug

### Global Search Methods
- `globallySearchable(bool|Closure $condition)` - Enable/disable global search
- `globalSearchResultsLimit(int $limit)` - Set search results limit
- `forceGlobalSearchCaseInsensitive(bool|Closure|null $condition)` - Force case insensitive search
- `splitGlobalSearchTerms(bool|Closure $condition)` - Split search terms

### Label Methods
- `modelLabel(string|Closure|null $label)` - Set model label
- `pluralModelLabel(string|Closure|null $label)` - Set plural model label
- `recordTitleAttribute(string|Closure|null $attribute)` - Set record title attribute
- `titleCaseModelLabel(bool|Closure $condition)` - Enable/disable title case

### Tenant Methods
- `scopeToTenant(bool|Closure $condition)` - Enable/disable tenant scoping
- `tenantRelationshipName(string|Closure|null $name)` - Set tenant relationship name
- `tenantOwnershipRelationshipName(string|Closure|null $name)` - Set ownership relationship name

### Cluster & Parent Methods
- `cluster(string|Closure|null $cluster)` - Set cluster class
- `parentResource(string|null $resource)` - Set parent resource class

## Requirements

- PHP 8.2+
- Laravel 11.x | 12.x
- Filament 4.x

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
