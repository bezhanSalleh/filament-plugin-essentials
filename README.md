# Filament Plugin Essentials

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)

A comprehensive collection of essential traits that streamline Filament plugin development by providing a **3-tier default/override system** with **multi-resource support**. This package allows plugin developers to create customizable plugins with minimal boilerplate while giving end users a fluent, intuitive configuration API.

## 🎯 What This Package Provides

**For Plugin Developers:**
- 🛠️ **Ready-to-use traits** for common Filament functionality (navigation, labels, global search, tenancy, etc.)
- 📦 **3-tier default system** with global and resource-specific defaults
- 🎯 **Multi-resource support** with per-resource configuration
- 🔗 **Automatic delegation** between plugins and resources
- 📝 **Minimal boilerplate** - just add traits and optionally define defaults

**For End Users:**
- 🎨 **Fluent API** for configuring any plugin that uses these traits
- 🎛️ **Per-resource customization** for multi-resource plugins
- ⚡ **Dynamic values** using closures for conditional logic
- 🛡️ **Intelligent fallbacks** to sensible defaults
- 🔧 **Zero configuration** required - works out of the box

## 🚀 Key Features

- ✅ **3-tier default/override system** - Global → Resource-specific → User overrides
- ✅ **Multi-resource support** - Configure different settings per resource
- ✅ **Resource-specific defaults** - Plugin developers can set different defaults per resource
- ✅ **Fluent API** - Intuitive method chaining for configuration
- ✅ **Closure support** - Dynamic values and conditional logic
- ✅ **Type safety** - Full IntelliSense support
- ✅ **Backward compatibility** - Zero breaking changes
- ✅ **Comprehensive test coverage** - 103 tests with 476 assertions

## � Quick Start

### 1. Install the Package

```bash
composer require bezhansalleh/filament-plugin-essentials
```

### 2. Add Traits to Your Plugin

```php
use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;

class YourPlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    
    // Your plugin implementation...
}
```

### 3. Add Matching Traits to Your Resources

```php
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;

class YourResource extends Resource
{
    use HasNavigation;
    use HasLabels;
    
    public static function pluginEssential(): ?YourPlugin
    {
        return YourPlugin::get();
    }
}
```

### 4. Configure the Plugin (Optional)

```php
YourPlugin::make()
    ->navigationLabel('My Custom Label')
    ->navigationIcon('heroicon-o-star')
    ->modelLabel('Custom Item')
```

**That's it!** Your plugin now has a fluent configuration API with intelligent defaults.

## �📦 Installation

## 📦 Detailed Installation

For more detailed setup instructions:

```bash
composer require bezhansalleh/filament-plugin-essentials
```

No additional configuration or service provider registration is required.

## 🛠 For Plugin Developers

### Basic Setup

Include the desired traits in your plugin class:

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\HasGlobalSearch;
use BezhanSalleh\PluginEssentials\Plugin\WithMultipleResourceSupport;
use Filament\Contracts\Plugin;
use Filament\Panel;

class YourPlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    use HasGlobalSearch;
    use WithMultipleResourceSupport; // For multi-resource plugins
    
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
            UserResource::class,
            PostResource::class,
        ]);
    }
    
    public function boot(Panel $panel): void
    {
        //
    }
}
```

### Setting Plugin Defaults

Provide sensible defaults for your users by implementing the `getPluginDefaults()` method:

```php
class YourPlugin implements Plugin
{
    use HasNavigation, HasLabels, HasGlobalSearch;
    
    /**
     * Define default values for your plugin
     */
    protected function getPluginDefaults(): array
    {
        return [
            // Global defaults (apply to all resources)
            'navigationGroup' => 'Your Plugin',
            'navigationIcon' => 'heroicon-o-puzzle-piece', 
            'globalSearchResultsLimit' => 25,
            
            // Resource-specific defaults (optional)
            'resources' => [
                UserResource::class => [
                    'modelLabel' => 'Plugin User',
                    'pluralModelLabel' => 'Plugin Users',
                    'navigationIcon' => 'heroicon-o-users',
                    'globalSearchResultsLimit' => 50, // Override global
                ],
                PostResource::class => [
                    'modelLabel' => 'Plugin Post',
                    'pluralModelLabel' => 'Plugin Posts', 
                    'navigationIcon' => 'heroicon-o-document-text',
                    'navigationSort' => 10,
                ],
            ],
        ];
    }
    
    // ...rest of plugin
}
```

### Resource Setup

In your resource classes, include the corresponding resource traits:

```php
<?php

namespace YourVendor\YourPlugin\Resources;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasGlobalSearch;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    use HasNavigation;
    use HasLabels;
    use HasGlobalSearch;
    
    protected static ?string $model = User::class;
    
    // Required: Link resource to plugin
    public static function pluginEssential(): ?YourPlugin
    {
        return YourPlugin::get();
    }
    
    // Your resource implementation...
}
```

## 🎯 For End Users

Once a plugin uses these traits, configure it with a fluent API:

### Basic Configuration

```php
use YourVendor\YourPlugin\YourPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            YourPlugin::make()
                // Navigation
                ->navigationLabel('Custom Label')
                ->navigationIcon('heroicon-o-star')
                ->navigationGroup('My Group')
                ->navigationSort(10)
                ->navigationBadge('NEW')
                ->navigationBadgeColor('success')
                
                // Labels
                ->modelLabel('Custom Item')
                ->pluralModelLabel('Custom Items')
                
                // Global Search
                ->globallySearchable(true)
                ->globalSearchResultsLimit(30),
        ]);
}
```

### Multi-Resource Configuration

For plugins with multiple resources, configure each resource separately:

```php
YourPlugin::make()
    // Configure UserResource
    ->resource(UserResource::class)
        ->navigationLabel('User Management')
        ->navigationIcon('heroicon-o-users')
        ->modelLabel('User')
        ->globalSearchResultsLimit(25)
        
    // Configure PostResource  
    ->resource(PostResource::class)
        ->navigationLabel('Blog Posts')
        ->navigationIcon('heroicon-o-document-text')
        ->modelLabel('Article')
        ->globalSearchResultsLimit(10)
```

### Dynamic Values with Closures

All methods support closures for dynamic values:

```php
YourPlugin::make()
    ->navigationLabel(fn() => 'Users (' . User::count() . ')')
    ->navigationBadge(fn() => User::whereNull('email_verified_at')->count())
    ->navigationBadgeColor(fn() => 
        User::whereNull('email_verified_at')->count() > 0 ? 'warning' : 'success'
    )
    ->modelLabel(fn() => auth()->user()->isAdmin() ? 'Admin User' : 'User')
```

## 🎯 Understanding the 3-Tier System

This package provides a powerful **3-tier priority system** that ensures maximum flexibility:

### Priority Order (Highest to Lowest)

1. **🔥 User Overrides** - Values set by end users via the fluent API
2. **🏗️ Plugin Defaults** - Defaults provided by plugin developers  
3. **⚙️ Filament Defaults** - Standard Filament behavior

### Example: How Values Are Resolved

```php
// 1. Plugin Developer sets defaults
class BlogPlugin implements Plugin
{
    protected function getPluginDefaults(): array
    {
        return [
            'navigationGroup' => 'Blog Management',    // Plugin default
            'navigationIcon' => 'heroicon-o-document', // Plugin default
            'globalSearchResultsLimit' => 15,          // Plugin default
        ];
    }
}

// 2. End User configures plugin
BlogPlugin::make()
    ->navigationGroup('Content')          // ✅ User override
    ->navigationIcon('heroicon-o-star')   // ✅ User override
    // globalSearchResultsLimit not set  // ⬇️ Will use plugin default
    // navigationSort not set            // ⬇️ Will use Filament default

// 3. Final Result:
// ✅ navigationGroup: "Content" (user override wins)
// ✅ navigationIcon: "heroicon-o-star" (user override wins)  
// 🏗️ globalSearchResultsLimit: 15 (plugin default used)
// ⚙️ navigationSort: null (Filament default used)
```

### Resource-Specific Defaults

Plugin developers can also set different defaults per resource:

```php
protected function getPluginDefaults(): array
{
    return [
        // 🌐 Global defaults (apply to all resources)
        'navigationGroup' => 'My Plugin',
        'globalSearchResultsLimit' => 25,
        
        // 🎯 Resource-specific defaults (higher priority than global)
        'resources' => [
            UserResource::class => [
                'modelLabel' => 'User Account',
                'navigationIcon' => 'heroicon-o-users',
                'globalSearchResultsLimit' => 50, // Overrides global default
            ],
            PostResource::class => [
                'modelLabel' => 'Blog Post',
                'navigationIcon' => 'heroicon-o-document-text',
                'navigationSort' => 10,
                // globalSearchResultsLimit not set, will use global default (25)
            ],
        ],
    ];
}
```

This means for `UserResource`, the search limit will be 50, but for `PostResource` it will be 25.

### Benefits of This System

- **🎯 DRY Principle** - Plugin developers set defaults once, users only override what they need
- **🔧 Maximum Flexibility** - Users can override any value at any level
- **⚡ Zero Configuration** - Works perfectly out of the box with sensible defaults
- **🛡️ Fallback Safety** - Always has sensible defaults even if nothing is configured
- **🧩 Consistent API** - Works the same way across all plugin traits

## 📚 Complete API Reference

### Plugin Traits (Add to your plugin class)

#### `HasNavigation`
Provides complete navigation customization:

```php
$plugin
    ->navigationLabel('Custom Label')           // string|Closure|null
    ->navigationIcon('heroicon-o-home')         // string|Closure|null  
    ->activeNavigationIcon('heroicon-s-home')   // string|Closure|null
    ->navigationGroup('Group Name')             // string|Closure|null
    ->navigationSort(10)                        // int|Closure|null
    ->navigationBadge('5')                      // string|Closure|null
    ->navigationBadgeColor('success')           // string|array|Closure|null
    ->navigationParentItem('parent.item')       // string|Closure|null
    ->slug('custom-slug')                       // string|Closure|null
    ->subNavigationPosition(SubNavigationPosition::Top) // SubNavigationPosition|Closure|null
    ->registerNavigation(false);                // bool|Closure
```

#### `HasLabels`
Provides label and display customization:

```php
$plugin
    ->modelLabel('Custom Model')               // string|Closure|null
    ->pluralModelLabel('Custom Models')        // string|Closure|null
    ->recordTitleAttribute('name')             // string|Closure|null
    ->titleCaseModelLabel(false);              // bool|Closure
```

#### `HasGlobalSearch`
Configures global search behavior:

```php
$plugin
    ->globallySearchable(true)                 // bool|Closure
    ->globalSearchResultsLimit(50)            // int|Closure
    ->forceGlobalSearchCaseInsensitive(true)   // bool|Closure|null
    ->splitGlobalSearchTerms(false);           // bool|Closure
```

#### `BelongsToCluster`
Enables cluster assignment:

```php
$plugin->cluster(MyCluster::class);           // string|Closure|null
```

#### `BelongsToParent`
Enables parent resource assignment:

```php
$plugin->parentResource(ParentResource::class); // string|Closure|null
```

#### `BelongsToTenant`
Provides multi-tenancy configuration:

```php
$plugin
    ->scopeToTenant(true)                      // bool|Closure
    ->tenantRelationshipName('organization')   // string|Closure|null
    ->tenantOwnershipRelationshipName('owner'); // string|Closure|null
```

#### `WithMultipleResourceSupport`
Enables per-resource configuration for multi-resource plugins:

```php
// Add this trait to enable ->resource(ResourceClass::class) API
class YourPlugin implements Plugin 
{
    use HasNavigation;
    use HasLabels;
    use WithMultipleResourceSupport;  // Enables multi-resource support
}

// Usage:
$plugin
    ->resource(UserResource::class)
        ->navigationLabel('Users')
        ->modelLabel('User')
    ->resource(PostResource::class)
        ->navigationLabel('Posts')
        ->modelLabel('Article');
```

### Resource Traits (Add to your resource classes)

Each plugin trait has a corresponding resource trait:

| Plugin Trait | Resource Trait |
|--------------|----------------|
| `HasNavigation` | `Resource\Concerns\HasNavigation` |
| `HasLabels` | `Resource\Concerns\HasLabels` |
| `HasGlobalSearch` | `Resource\Concerns\HasGlobalSearch` |
| `BelongsToCluster` | `Resource\Concerns\BelongsToCluster` |
| `BelongsToParent` | `Resource\Concerns\BelongsToParent` |
| `BelongsToTenant` | `Resource\Concerns\BelongsToTenant` |

```php
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;

class YourResource extends Resource
{
    use HasNavigation;
    use HasLabels;
    
    // Required: Link to your plugin
    public static function pluginEssential(): ?YourPlugin
    {
        return YourPlugin::get();
    }
}
```
##  Advanced Usage Examples

### Complex Plugin Configuration

```php
YourPlugin::make()
    // Static values
    ->navigationLabel('User Management')
    ->navigationIcon('heroicon-o-users')
    ->navigationGroup('Administration')
    
    // Dynamic values with closures
    ->navigationBadge(fn() => User::whereNull('email_verified_at')->count())
    ->navigationBadgeColor(fn() => 
        User::whereNull('email_verified_at')->count() > 0 ? 'warning' : 'success'
    )
    
    // Conditional logic
    ->cluster(fn() => auth()->user()?->isAdmin() ? AdminCluster::class : null)
    ->modelLabel(fn() => Filament::getTenant()?->type === 'enterprise' ? 'Employee' : 'User')
    
    // Global search configuration
    ->globallySearchable(fn() => config('app.enable_global_search'))
    ->globalSearchResultsLimit(25)
```

### Multi-Resource Plugin with Different Settings

```php
YourMultiResourcePlugin::make()
    // Configure UserResource
    ->resource(UserResource::class)
        ->navigationLabel(fn() => 'Users (' . User::count() . ')')
        ->navigationGroup('Administration')
        ->globallySearchable(true)
        ->globalSearchResultsLimit(25)
        ->cluster(AdminCluster::class)
        
    // Configure PostResource with different settings
    ->resource(PostResource::class)
        ->navigationLabel(fn() => 'Posts (' . Post::published()->count() . ')')
        ->navigationGroup('Content')
        ->globallySearchable(true)
        ->globalSearchResultsLimit(10)
        ->cluster(ContentCluster::class)
        
    // Configure CategoryResource
    ->resource(CategoryResource::class)
        ->navigationLabel('Categories')
        ->navigationGroup('Content')
        ->globallySearchable(false)
        ->parentResource(PostResource::class)
```

### Plugin with Resource-Specific Defaults

```php
class BlogPlugin implements Plugin
{
    use HasNavigation, HasLabels, HasGlobalSearch, WithMultipleResourceSupport;
    
    protected function getPluginDefaults(): array
    {
        return [
            // Global defaults
            'navigationGroup' => 'Blog Management',
            'globalSearchResultsLimit' => 15,
            
            // Resource-specific defaults  
            'resources' => [
                PostResource::class => [
                    'modelLabel' => 'Blog Post',
                    'pluralModelLabel' => 'Blog Posts',
                    'navigationIcon' => 'heroicon-o-document-text',
                    'navigationSort' => 10,
                    'globalSearchResultsLimit' => 20, // Override global
                ],
                CategoryResource::class => [
                    'modelLabel' => 'Blog Category',
                    'pluralModelLabel' => 'Blog Categories', 
                    'navigationIcon' => 'heroicon-o-folder',
                    'navigationSort' => 20,
                    'globallySearchable' => false, // Disable for this resource
                ],
            ],
        ];
    }
}
```

## 🧪 Testing

Run the package tests:

```bash
composer test
composer test:coverage  # View coverage report
```

Current test coverage: **103 tests** with **476 assertions**.

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒 Security

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## 🙏 Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [All Contributors](../../contributors)