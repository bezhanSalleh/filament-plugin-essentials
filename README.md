<a href="https://github.com/bezhansalleh/filament-plugin-essentials" class="filament-hidden">
<img style="width: 100%; max-width: 100%;" alt="filament-plugin-essentials-art" src="https://repository-images.githubusercontent.com/1014100295/abe541e0-1f7e-4c9d-9120-ad49806f15b1" >
</a>
<p align="center" class="flex items-center justify-center">
    <a href="https://filamentphp.com/docs/4.x/introduction/installation">
        <img alt="FILAMENT 4.x" src="https://img.shields.io/badge/FILAMENT-4.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://filamentphp.com/docs/5.x/introduction/installation">
        <img alt="FILAMENT 5.x" src="https://img.shields.io/badge/FILAMENT-5.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://packagist.org/packages/bezhansalleh/filament-plugin-essentials">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/bezhansalleh/filament-plugin-essentials.svg?style=for-the-badge&logo=packagist">
    </a>
    <a href="https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3Arun-tests+branch%3Amain" class="filament-hidden">
        <img alt="Tests Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/run-tests.yml?style=for-the-badge&logo=github&label=tests" class="filament-hidden">
    </a>
    <a href="https://github.com/bezhanSalleh/filament-plugin-essentials/actions/workflows/fix-php-code-style-issues.yml?query=branch%3Amain" class="filament-hidden">
        <img alt="Code Style Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/fix-php-code-style-issues.yml?style=for-the-badge&logo=github&label=code%20style">
    </a>

<a href="https://packagist.org/packages/bezhansalleh/filament-plugin-essentials">
    <img alt="Downloads" src="https://img.shields.io/packagist/dt/bezhansalleh/filament-plugin-essentials.svg?style=for-the-badge" >
    </a>
</p>


# Filament Plugin Essentials

A collection of essential traits that streamline Filament plugin development by taking care of the boilerplate, so you can focus on shipping real features faster

## Table of Contents

- [Filament Plugin Essentials](#filament-plugin-essentials)
  - [Table of Contents](#table-of-contents)
  - [Features](#features)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [For Plugin Developers](#for-plugin-developers)
    - [1. Add traits to your plugin class](#1-add-traits-to-your-plugin-class)
    - [2. Add matching traits to your forResource classes](#2-add-matching-traits-to-your-forresource-classes)
    - [3. Set defaults for your plugin (optional)](#3-set-defaults-for-your-plugin-optional)
    - [How values are resolved](#how-values-are-resolved)
  - [How Plugin Users Can Configure Your Plugin](#how-plugin-users-can-configure-your-plugin)
    - [Multi-forResource configuration](#multi-forresource-configuration)
    - [Dynamic values with closures](#dynamic-values-with-closures)
  - [Plugin \& Resource Trait Mapping](#plugin--resource-trait-mapping)
  - [Configuration Options Provided by Each Trait](#configuration-options-provided-by-each-trait)
    - [`HasNavigation`](#hasnavigation)
    - [`HasLabels`](#haslabels)
    - [`HasGlobalSearch`](#hasglobalsearch)
    - [`BelongsToParent`](#belongstoparent)
    - [`BelongsToTenant`](#belongstotenant)
    - [`WithMultipleResourceSupport`](#withmultipleresourcesupport)
  - [Limitations](#limitations)
  - [Todo](#todo)
  - [Testing](#testing)
  - [Changelog](#changelog)
  - [Contributing](#contributing)
  - [Security Vulnerabilities](#security-vulnerabilities)
  - [Credits](#credits)
  - [License](#license)

## Features

- **Easily Configure**
  - **🎯 Navigation** - Complete control over resource navigation (labels, icons, groups, sorting, badges)
  - **🏷️ Label** - Model labels, plural forms, title attributes, and casing options
  - **🔍 Global Search** - Searchability controls, result limits, and case sensitivity options
  - **👥 Resource Tenant options** - Tenant scoping and relationship configuration
  - **🔗 Parent Resource** - Hierarchical resource relationships
- **⚙️ Multi-Resource Configuration** - Different settings per `Resource` in a single plugin
- **📦 3-Tier Default System** - User overrides → Plugin defaults → Filament defaults
- **🔄 Dynamic Values** - Closure support for conditional logic and real-time data
- **🛠️ Developer-Friendly** - Minimal boilerplate with maximum customization

## Requirements
- Filament [4.x](https://filamentphp.com/docs/4.x/introduction/installation) & [5.x](https://filamentphp.com/docs/5.x/introduction/installation)
- PHP 8.2+
  
## Installation

```bash
composer require bezhansalleh/filament-plugin-essentials
```

## For Plugin Developers

### 1. Add traits to your plugin class

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Concerns\Plugin\WithMultipleResourceSupport;
use Filament\Contracts\Plugin;
use Filament\Facades\Filament;

class YourPlugin implements Plugin
{
    use HasGlobalSearch;
    use HasLabels;
    use HasNavigation;
    use WithMultipleResourceSupport; // For multi-forResource plugins
    
    public static function make(): static
    {
        return app(static::class);
    }
    
    public static function get(): ?static
    {
        return Filament::getPlugin('your-plugin');
    }
    
    public function getId(): string
    {
        return 'your-plugin';
    }
    
    // ... rest of plugin implementation
}
```

### 2. Add matching traits to your forResource classes

```php
<?php

namespace YourVendor\YourPlugin\Resources;

use BezhanSalleh\PluginEssentials\Concerns;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    use Concerns\Resource\HasNavigation;
    use Concerns\Resource\HasLabels;
    use Concerns\Resource\HasGlobalSearch;
    
    protected static ?string $model = User::class;
    
    // Required: Link resource to plugin
    public static function getEssentialsPlugin(): ?YourPlugin
    {
        return YourPlugin::get();
    }
    
    // ... rest of forResource implementation
}
```

### 3. Set defaults for your plugin (optional)

```php
class YourPlugin implements Plugin
{
    use HasNavigation, HasLabels, HasGlobalSearch;
    
    protected function getPluginDefaults(): array
    {
        return [
            // Global defaults (apply to all resources)
            'navigationGroup' => 'Your Plugin',
            'navigationIcon' => 'heroicon-o-puzzle-piece',
            'modelLabel' => 'Item',
            'pluralModelLabel' => 'Items',
            'globalSearchResultsLimit' => 25,
            
            // Resource-specific defaults (optional)
            'resources' => [
                UserResource::class => [
                    'modelLabel' => 'User',
                    'pluralModelLabel' => 'Users',
                    'navigationIcon' => 'heroicon-o-users',
                    'globalSearchResultsLimit' => 50,
                ],
                PostResource::class => [
                    'modelLabel' => 'Post',
                    'pluralModelLabel' => 'Posts',
                    'navigationIcon' => 'heroicon-o-document-text',
                    'navigationSort' => 10,
                ],
            ],
        ];
    }
}
```

> [!NOTE]
> Defaults arrays are keyed by **property name** (`shouldRegisterNavigation`, `isGloballySearchable`, `hasTitleCaseModelLabel`, …), not by setter name. The copy-paste blocks under each trait below list the correct keys.

Alternatively, define a `getDefault{Property}()` method for any property — it takes precedence over the `getPluginDefaults()` array and receives the resource class being resolved:

```php
protected function getDefaultModelLabel(?string $resourceClass = null): string
{
    return $resourceClass === UserResource::class ? 'User' : 'Item';
}
```

The legacy flat structure (`UserResource::class => [...]` at the top level of the defaults array) keeps working alongside the nested `'resources'` key.

### How values are resolved

For every configurable property, the first tier with an answer wins:

1. **Per-resource user override** — `->forResource(UserResource::class)->navigationIcon(...)`
2. **Global user override** — `->navigationIcon(...)`
3. **Plugin developer defaults** — `getDefault{Property}()` method, then `getPluginDefaults()['resources'][ResourceClass][property]`, then legacy `getPluginDefaults()[ResourceClass][property]`, then `getPluginDefaults()[property]`
4. **Resource / Filament defaults** — the resource's own static configuration, then Filament's native behavior (including panel-level configuration such as `subNavigationPosition`)

Passing `null` explicitly to a nullable setting is an answer, not a reset — `->navigationIcon(null)` removes the icon even when the plugin ships a default or the resource declares its own static icon.

## How Plugin Users Can Configure Your Plugin

When plugin developers use these traits, users of their plugins get a fluent API to configure them. The available configuration options depend on which traits the plugin developer chose to include.

Configure any plugin that uses these traits:

```php
use YourVendor\YourPlugin\YourPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            YourPlugin::make()
                ->navigationLabel('Custom Label')
                ->navigationIcon('heroicon-o-star')
                ->modelLabel('Custom Item')
                ->globalSearchResultsLimit(30),
        ]);
}
```

### Multi-forResource configuration

```php
YourPlugin::make()
    // Configure UserResource
    ->forResource(UserResource::class)
        ->navigationLabel('Users')
        ->modelLabel('User')
        ->globalSearchResultsLimit(25)
        
    // Configure PostResource  
    ->forResource(PostResource::class)
        ->navigationLabel('Posts')
        ->modelLabel('Article')
        ->globalSearchResultsLimit(10)
```

### Dynamic values with closures

```php
YourPlugin::make()
    ->navigationLabel(fn() => 'Users (' . User::count() . ')')
    ->navigationBadge(fn() => User::whereNull('email_verified_at')->count())
    ->modelLabel(fn() => auth()->user()->isAdmin() ? 'Admin User' : 'User')
```

## Plugin & Resource Trait Mapping

Each plugin trait has a corresponding forResource trait that must be added to your forResource classes:
```php
use BezhanSalleh\PluginEssentials\Concerns\Plugin; // plugin
use BezhanSalleh\PluginEssentials\Concerns\Resource; // forResource
```
| Plugin Trait | Resource Trait |
|--------------|----------------|
| `Plugin\HasNavigation` | `Resource\HasNavigation` |
| `Plugin\HasLabels` | `Resource\HasLabels` |
| `Plugin\HasGlobalSearch` | `Resource\HasGlobalSearch` |
| `Plugin\BelongsToParent` | `Resource\BelongsToParent` |
| `Plugin\BelongsToTenant` | `Resource\BelongsToTenant` |
| `Plugin\WithMultipleResourceSupport` | *(No forResource trait needed - enables multi-forResource configuration)* |

## Configuration Options Provided by Each Trait

### `HasNavigation`

```php
$plugin
    ->navigationLabel('Label')                  // string|Closure|null
    ->navigationIcon('heroicon-o-home')         // string|Closure|null  
    ->activeNavigationIcon('heroicon-s-home')   // string|Closure|null
    ->navigationGroup('Group')                  // string|Closure|null
    ->navigationSort(10)                        // int|Closure|null
    ->navigationBadge('5')                      // string|Closure|null
    ->navigationBadgeColor('success')           // string|array|Closure|null
    ->navigationParentItem('parent.item')       // string|Closure|null
    ->navigationBadgeTooltip('New users')       // string|Closure|null
    ->subNavigationPosition(SubNavigationPosition::End) // SubNavigationPosition|Closure
    ->registerNavigation(false);                // bool|Closure
```

**Copy-paste defaults:**
```php
protected function getPluginDefaults(): array
{
    return [
        'navigationLabel' => 'Your Label',
        'navigationIcon' => 'heroicon-o-home',
        'activeNavigationIcon' => 'heroicon-s-home',
        'navigationGroup' => 'Your Group',
        'navigationSort' => 10,
        'navigationBadge' => null,
        'navigationBadgeColor' => null,
        'navigationBadgeTooltip' => null,
        'navigationParentItem' => null,
        'shouldRegisterNavigation' => true,
    ];
}
```

### `HasLabels`

```php
$plugin
    ->modelLabel('Model')                       // string|Closure|null
    ->pluralModelLabel('Models')                // string|Closure|null
    ->recordTitleAttribute('name')              // string|Closure|null
    ->titleCaseModelLabel(false);               // bool|Closure
```

**Copy-paste defaults:**
```php
protected function getPluginDefaults(): array
{
    return [
        'modelLabel' => 'Item',
        'pluralModelLabel' => 'Items',
        'recordTitleAttribute' => 'name',
        'hasTitleCaseModelLabel' => true,
    ];
}
```

### `HasGlobalSearch`

```php
$plugin
    ->globallySearchable(true)                  // bool|Closure
    ->globalSearchResultsLimit(50)             // int|Closure
    ->forceGlobalSearchCaseInsensitive(true)    // bool|Closure|null
    ->splitGlobalSearchTerms(false);            // bool|Closure
```

**Copy-paste defaults:**
```php
protected function getPluginDefaults(): array
{
    return [
        'isGloballySearchable' => true,
        'globalSearchResultsLimit' => 50,
        'isGlobalSearchForcedCaseInsensitive' => null,
        'shouldSplitGlobalSearchTerms' => true,
    ];
}
```


### `BelongsToParent`

```php
$plugin->parentResource(ParentResource::class); // string|Closure|null
```

**Copy-paste defaults:**
```php
protected function getPluginDefaults(): array
{
    return [
        'parentResource' => null,
    ];
}
```

### `BelongsToTenant`

```php
$plugin
    ->scopeToTenant(true)                       // bool|Closure
    ->tenantRelationshipName('organization')    // string|Closure|null
    ->tenantOwnershipRelationshipName('owner'); // string|Closure|null
```

**Copy-paste defaults:**
```php
protected function getPluginDefaults(): array
{
    return [
        'isScopedToTenant' => true,
        'tenantRelationshipName' => null,
        'tenantOwnershipRelationshipName' => null,
    ];
}
```

### `WithMultipleResourceSupport`

Enables per-forResource configuration:

```php
class YourPlugin implements Plugin 
{
    use HasNavigation;
    use WithMultipleResourceSupport;
}

// Usage:
$plugin
    ->forResource(UserResource::class)
        ->navigationLabel('Users')
    ->forResource(PostResource::class)
        ->navigationLabel('Posts');
```

## Limitations

Route-phase configuration cannot be plugin-delegated. Filament resolves resource **slugs**, **clusters**, and route prefixes while registering routes at application boot — before any panel boots and before `filament()->getPlugin()` can target the correct panel. Plugin configuration only becomes reliable per-request, after the panel boots. That is why these traits cover navigation, labels, global search, tenancy, and parent resources, but not `slug()` or cluster assignment.

## Todo
- [ ] Add support for pages
- [ ] ...features you want to see? [Open an issue]()

## Testing

```bash
composer test:unit
composer finalize
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/security/policy) on how to report security vulnerabilities.

## Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
