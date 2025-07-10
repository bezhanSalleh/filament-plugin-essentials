# Filament Plugin Essentials

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)

A collection of essential traits that streamline Filament plugin development by taking care of the boilerplate, so you can focus on shipping real features faster

## Features

- **Easily Configure**
  - **🎯 Navigation** - Complete control over resource navigation (labels, icons, groups, sorting, badges)
  - **🏷️ Label** - Model labels, plural forms, title attributes, and casing options
  - **🔍 Global Search** - Searchability controls, result limits, and case sensitivity options
  - **🗂️ Resource Cluster** - Organize resources into clusters for better navigation
  - **👥 Resource Tenant options** - Tenant scoping and relationship configuration
  - **🔗 Parent Resource** - Hierarchical resource relationships
- **⚙️ Multi-Resource Configuration** - Different settings per `Resource` in a single plugin
- **📦 3-Tier Default System** - User overrides → Plugin defaults → Filament defaults
- **🔄 Dynamic Values** - Closure support for conditional logic and real-time data
- **🛠️ Developer-Friendly** - Minimal boilerplate with maximum customization

## Installation

```bash
composer require bezhansalleh/filament-plugin-essentials
```

## For Plugin Developers

### 1. Add traits to your plugin class

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Concerns\Plugin;
use Filament\Contracts\Plugin;

class YourPlugin implements Plugin
{
    use Plugin\HasNavigation;
    use Plugin\HasLabels;
    use Plugin\HasGlobalSearch;
    use Plugin\WithMultipleResourceSupport; // For multi-forResource plugins
    
    public static function make(): static
    {
        return app(static::class);
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
| `Plugin\BelongsToCluster` | `Resource\BelongsToCluster` |
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
    ->slug('custom-slug')                       // string|Closure|null
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
        'navigationParentItem' => null,
        'slug' => null,
        'registerNavigation' => true,
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
        'titleCaseModelLabel' => true,
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
        'globallySearchable' => true,
        'globalSearchResultsLimit' => 50,
        'forceGlobalSearchCaseInsensitive' => null,
        'splitGlobalSearchTerms' => false,
    ];
}
```

### `BelongsToCluster`

```php
$plugin->cluster(MyCluster::class);             // string|Closure|null
```

**Copy-paste defaults:**
```php
protected function getPluginDefaults(): array
{
    return [
        'cluster' => null,
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
        'scopeToTenant' => true,
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

## Todo
- [ ] Add support for pages
- [ ] ...features you want to see? [Open an issue]()

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [All Contributors](../../contributors)
