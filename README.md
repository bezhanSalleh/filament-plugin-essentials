# Filament Plugin Essentials

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalle### Alternative: Method-Based Defaults

For complex scenarios, override individual getter methods:

```php
protected function getDefaultNavigationLabel(?string $resourceClass = null): string
{
    return match($resourceClass) {
        UserResource::class => 'Users',
        PostResource::class => 'Blog Posts',
        default => 'Items'
    };
}
```

### Enhanced: Nested Resource-Specific Defaults

For better organization, you can use the nested `resources` structure to define resource-specific defaults:

```php
protected function getPluginDefaults(): array
{
    return [
        // Global defaults (apply to all resources)
        'navigationGroup' => 'My Plugin',
        'globalSearchResultsLimit' => 25,
        
        // Resource-specific defaults (NEW)
        'resources' => [
            UserResource::class => [
                'modelLabel' => 'Plugin User',
                'pluralModelLabel' => 'Plugin Users',
                'navigationIcon' => 'heroicon-o-users',
                'globalSearchResultsLimit' => 50, // Override global default
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
```

The system supports both the flat structure and the nested structure for backward compatibility.gin-essentials)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)

A comprehensive collection of essential traits that streamline Filament plugin development by providing a powerful **conditional trait-based method override system** with a **3-tier default/override hierarchy**. This allows plugin developers to offer end users a fluent, customizable API while maintaining clean separation of concerns and type safety.

## 🎯 What This Package Does

**Filament Plugin Essentials** provides a standardized way for plugin developers to offer customizable resource and page configurations to end users. Instead of manually implementing configuration methods and delegation logic, plugin developers can simply include traits that automatically provide:

- **Navigation customization** (icons, labels, grouping, badges, etc.)
- **Clustering and hierarchy management**
- **Multi-tenancy configuration**
- **Global search settings**
- **Label and display customization**

The package uses an advanced **conditional delegation system** that automatically detects which traits a plugin uses and delegates method calls accordingly, with intelligent fallback to parent implementations when needed.

## 🚀 Key Features

- ✅ **Plug-and-play traits** for common plugin customizations
- ✅ **3-tier default/override system** for flexible configuration (New in v2.1!)
- ✅ **Multi-resource support** with per-resource configuration (New in v2.0!)
- ✅ **Conditional delegation system** with automatic trait detection
- ✅ **Type-safe implementation** with full IntelliSense support
- ✅ **Fluent API** for end-user configuration
- ✅ **Graceful fallbacks** when plugins don't implement certain features
- ✅ **Closure support** for dynamic values
- ✅ **Comprehensive test coverage** (72.4% with 73 tests)
- ✅ **Zero breaking changes** to existing Filament behavior

## 📦 Installation

Install the package via Composer:

```bash
composer require bezhansalleh/filament-plugin-essentials
```

## 🛠 Usage

### For Plugin Developers

Include the desired traits in your plugin class to provide users with standardized customization options:

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\BelongsToCluster;
use Filament\Contracts\Plugin;
use Filament\Panel;

class YourPlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    use BelongsToCluster;
    
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
        //
    }
}
```

Then, in your resource classes, include the corresponding resource traits:

```php
<?php

namespace YourVendor\YourPlugin\Resources;

use BezhanSalleh\PluginEssentials\Resource\Concerns\HasNavigation;
use BezhanSalleh\PluginEssentials\Resource\Concerns\HasLabels;
use BezhanSalleh\PluginEssentials\Resource\Concerns\BelongsToCluster;
use Filament\Resources\Resource;

class YourResource extends Resource
{
    use HasNavigation;
    use HasLabels;
    use BelongsToCluster;
    
    protected static ?string $model = YourModel::class;
    
    // Add this method to enable plugin delegation
    public static function pluginEssential(): ?YourPlugin
    {
        return filament('your-plugin');
    }
    
    // Your resource implementation...
}
```

### For End Users

Once a plugin uses these traits, end users can configure the plugin with a fluent API:

```php
use YourVendor\YourPlugin\YourPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            YourPlugin::make()
                // Navigation customization
                ->navigationLabel('Custom Label')
                ->navigationIcon('heroicon-o-custom')
                ->navigationGroup('My Group')
                ->navigationSort(10)
                ->navigationBadge('NEW')
                ->navigationBadgeColor('success')
                ->navigationBadgeTooltip('This is new!')
                
                // Clustering
                ->cluster(MyCluster::class)
                
                // Labels
                ->modelLabel('Custom Model')
                ->pluralModelLabel('Custom Models')
                ->recordTitleAttribute('name')
                
                // Dynamic values with closures
                ->navigationLabel(fn() => auth()->user()->isAdmin() ? 'Admin View' : 'User View')
                ->navigationBadge(fn() => Model::whereNew()->count()),
        ]);
}
```

## 🎯 3-Tier Default/Override System

**NEW in v2.1**: This package provides a powerful 3-tier fallback system that allows for flexible configuration at different levels, ensuring maximum flexibility for both plugin developers and end users.

### How It Works

The system uses three levels of configuration, checked in this priority order:

1. **🔥 User Override** (Highest Priority) - Values set by end users via the fluent API
2. **🏗️ Plugin Developer Default** (Medium Priority) - Defaults provided by plugin developers  
3. **⚙️ Resource/Filament Default** (Lowest Priority) - Standard Filament behavior

### For Plugin Developers: Setting Default Values

Plugin developers can provide sensible defaults for their users by implementing the `getPluginDefaults()` method:

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use Filament\Contracts\Plugin;

class YourPlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    
    /**
     * Define plugin-level defaults that will be used when users don't override values
     */
    protected function getPluginDefaults(): array
    {
        return [
            'navigationGroup' => 'My Plugin',
            'navigationIcon' => 'heroicon-o-puzzle-piece',
            'modelLabel' => 'Plugin Item',
            'pluralModelLabel' => 'Plugin Items',
            'globalSearchResultsLimit' => 25,
        ];
    }
    
    // ...existing code...
}
```

#### Alternative: Method-Based Defaults

For more complex scenarios, you can override individual getter methods:

```php
protected function getDefaultNavigationLabel(?string $resourceClass = null): string
{
    return match($resourceClass) {
        UserResource::class => 'Users',
        PostResource::class => 'Blog Posts',
        default => 'Items'
    };
}
```

### For End Users: Overriding Defaults

End users can override any plugin defaults using the fluent API:

```php
// Plugin provides defaults, user overrides some values
YourPlugin::make()
    ->navigationGroup('Custom Group')  // User override
    ->navigationIcon('heroicon-o-star') // User override
    // modelLabel, pluralModelLabel, globalSearchResultsLimit will use plugin defaults
    // Other values will fall back to Filament defaults
```

### Real-World Example

Here's how the 3-tier system works in practice:

```php
// 1. Plugin Developer sets defaults
class BlogPlugin implements Plugin
{
    use HasNavigation, HasLabels, HasGlobalSearch;
    
    protected function getPluginDefaults(): array
    {
        return [
            'navigationGroup' => 'Blog Management',
            'navigationIcon' => 'heroicon-o-document-text',
            'modelLabel' => 'Blog Post',
            'pluralModelLabel' => 'Blog Posts',
            'globalSearchResultsLimit' => 15,
        ];
    }
}

// 2. End User installs and configures
BlogPlugin::make()
    ->navigationGroup('Content')        // User override: "Content"
    ->navigationIcon('heroicon-o-star') // User override: "heroicon-o-star"  
    // modelLabel: uses plugin default "Blog Post"
    // pluralModelLabel: uses plugin default "Blog Posts"
    // globalSearchResultsLimit: uses plugin default 15
    // navigationSort: uses Filament default (null)
    // navigationBadge: uses Filament default (null)
```

### Multi-Resource Support

The system also works seamlessly with multi-resource plugins:

```php
// Per-resource configuration with fallbacks
BlogPlugin::make()
    ->forResource(PostResource::class, fn($resource) => $resource
        ->navigationLabel('Posts')           // User override for Posts
        ->navigationIcon('heroicon-o-document') // User override for Posts
    )
    ->forResource(CategoryResource::class, fn($resource) => $resource
        ->navigationLabel('Categories')      // User override for Categories
        // navigationIcon will use plugin default for Categories
    );
```

### Benefits

- **🎯 DRY**: Plugin developers set defaults once, users only override what they need
- **🔧 Flexible**: Users can override any value at any level
- **⚡ Efficient**: No need to specify common values repeatedly
- **🛡️ Fallback-Safe**: Always has sensible defaults even if nothing is configured
- **🧩 Modular**: Works consistently across all plugin traits

## 📚 Available Traits

### Plugin Traits (Include in your plugin class)

#### `HasNavigation`
Provides navigation customization options:

```php
$plugin
    ->navigationLabel('Custom Label')           // string|Closure|null
    ->navigationIcon('heroicon-o-home')         // string|Closure|null  
    ->activeNavigationIcon('heroicon-s-home')   // string|Closure|null
    ->navigationGroup('Group Name')             // string|Closure|null
    ->navigationSort(10)                        // int|Closure|null
    ->navigationBadge('5')                      // string|Closure|null
    ->navigationBadgeColor('success')           // string|array|Closure|null
    ->navigationBadgeTooltip('Tooltip')         // string|Closure|null
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
    ->tenantScope(true)                        // bool|Closure
    ->tenantRelationshipName('organization')   // string|Closure|null
    ->tenantOwnershipRelationshipName('owner'); // string|Closure|null
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

#### `WithMultipleResourceSupport` (New in v2.0)
Enables per-resource configuration for plugins with multiple resources:

```php
// Add this trait to enable resource-specific configuration
class YourPlugin implements Plugin 
{
    use HasNavigation;
    use HasLabels;
    use WithMultipleResourceSupport;  // Enables ->resource(ResourceClass::class) API
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

### Resource Traits (Include in your resource classes)

Each plugin trait has a corresponding resource trait:

- `HasNavigation` → `Resource\Concerns\HasNavigation`
- `HasLabels` → `Resource\Concerns\HasLabels`  
- `BelongsToCluster` → `Resource\Concerns\BelongsToCluster`
- `BelongsToParent` → `Resource\Concerns\BelongsToParent`
- `BelongsToTenant` → `Resource\Concerns\BelongsToTenant`
- `HasGlobalSearch` → `Resource\Concerns\HasGlobalSearch`

## 🔄 How The Delegation System Works

The delegation system automatically determines whether to use plugin-configured values or fall back to the resource's parent implementation:

1. **Plugin Check**: Is a plugin instance available via `pluginEssential()`?
2. **Trait Detection**: Does the plugin use the required trait?
3. **Method Availability**: Does the plugin implement the method?
4. **Value Delegation**: Use plugin value (even if `null`)
5. **Fallback**: If any check fails, use parent implementation

```php
// Example: getNavigationLabel() flow
public static function getNavigationLabel(): string
{
    $pluginResult = static::delegateToPlugin('HasNavigation', 'getNavigationLabel', null);
    
    if (!static::isNoPluginResult($pluginResult)) {
        return $pluginResult ?? '';  // Use plugin result (even null)
    }
    
    return static::getParentResult('getNavigationLabel') ?? '';  // Fallback to parent
}
```

## 💡 Advanced Usage

### Conditional Values with Closures

All configuration methods support closures for dynamic values:

```php
$plugin
    ->navigationLabel(fn() => match(app()->getLocale()) {
        'es' => 'Etiqueta Personalizada',
        'fr' => 'Étiquette Personnalisée', 
        default => 'Custom Label'
    })
    ->navigationBadge(fn() => Cache::remember('badge-count', 300, fn() => 
        Model::where('status', 'pending')->count()
    ))
    ->registerNavigation(fn() => auth()->user()?->can('viewAny', Model::class));
```

### Complex Plugin Configuration

```php
YourPlugin::make()
    // Basic navigation
    ->navigationLabel('User Management')
    ->navigationIcon('heroicon-o-users')
    ->navigationGroup('Administration')
    
    // Dynamic badge with count
    ->navigationBadge(fn() => \App\Models\User::where('email_verified_at', null)->count())
    ->navigationBadgeColor(fn() => 
        \App\Models\User::where('email_verified_at', null)->count() > 0 ? 'warning' : 'success'
    )
    
    // Conditional clustering based on user role
    ->cluster(fn() => auth()->user()?->isAdmin() ? AdminCluster::class : null)
    
    // Dynamic labels based on tenant
    ->modelLabel(fn() => Filament::getTenant()?->type === 'enterprise' ? 'Employee' : 'User')
    ->pluralModelLabel(fn() => Filament::getTenant()?->type === 'enterprise' ? 'Employees' : 'Users')
    
    // Multi-tenancy setup
    ->tenantScope(true)
    ->tenantRelationshipName('organization')
    
    // Global search configuration
    ->globallySearchable(fn() => config('app.enable_global_search'))
    ->globalSearchResultsLimit(25);
```

### Multiple Resource Support

If your plugin registers multiple resources, each can have different configurations:

```php
// UserResource.php
class UserResource extends Resource
{
    use HasNavigation, HasLabels;
    
    public static function pluginEssential(): ?YourPlugin
    {
        return filament('your-plugin');
    }
}

// PostResource.php  
class PostResource extends Resource
{
    use HasNavigation, BelongsToCluster;
    
    public static function pluginEssential(): ?YourPlugin
    {
        return filament('your-plugin');
    }
}
```

The delegation system automatically handles different trait combinations per resource.

## 🎯 Multi-Resource Plugin Support

**New in v2.0:** For plugins that register multiple resources with different configuration needs, you can now use the `WithMultipleResourceSupport` trait to provide resource-specific settings.

### Setup for Plugin Developers

Add the `WithMultipleResourceSupport` trait to your plugin to enable per-resource configuration:

```php
<?php

namespace YourVendor\YourPlugin;

use BezhanSalleh\PluginEssentials\Plugin\HasNavigation;
use BezhanSalleh\PluginEssentials\Plugin\HasLabels;
use BezhanSalleh\PluginEssentials\Plugin\WithMultipleResourceSupport;
use Filament\Contracts\Plugin;

class YourMultiResourcePlugin implements Plugin
{
    use HasNavigation;
    use HasLabels;
    use WithMultipleResourceSupport; // 🎯 This enables multi-resource support
    
    public function register(Panel $panel): void
    {
        $panel->resources([
            UserResource::class,
            PostResource::class,
            CategoryResource::class,
        ]);
    }
    
    // ... rest of plugin implementation
}
```

### Usage for End Users

End users can now configure different settings for each resource using the fluent `resource()` API:

```php
YourMultiResourcePlugin::make()
    // Configure UserResource
    ->resource(UserResource::class)
        ->navigationLabel('User Management')
        ->navigationGroup('Administration')
        ->navigationIcon('heroicon-o-users')
        ->modelLabel('User')
        ->pluralModelLabel('Users')
        ->cluster(AdminCluster::class)
        
    // Configure PostResource with different settings
    ->resource(PostResource::class)
        ->navigationLabel('Blog Posts')
        ->navigationGroup('Content')
        ->navigationIcon('heroicon-o-document-text')
        ->modelLabel('Article')
        ->pluralModelLabel('Articles')
        ->cluster(ContentCluster::class)
        
    // Configure CategoryResource
    ->resource(CategoryResource::class)
        ->navigationLabel('Categories')
        ->navigationGroup('Content')
        ->navigationIcon('heroicon-o-folder')
        ->globallySearchable(false);
```

### Resource-Specific Delegation

Resources automatically receive their specific configuration:

```php
// UserResource will get:
// - Navigation label: "User Management"
// - Navigation group: "Administration" 
// - Model label: "User"
// - Cluster: AdminCluster::class

// PostResource will get:
// - Navigation label: "Blog Posts"
// - Navigation group: "Content"
// - Model label: "Article" 
// - Cluster: ContentCluster::class
```

### Key Features

- **✅ Fluent API**: Chain configurations for different resources
- **✅ Resource Context**: Each resource gets its own isolated configuration
- **✅ Backward Compatible**: Single-resource plugins work exactly as before
- **✅ Closure Support**: Dynamic values work in resource-specific contexts
- **✅ Fallback Behavior**: Unset properties fall back to global defaults
- **✅ Type Safety**: Full IntelliSense support for all configurations

### Advanced Multi-Resource Configuration

```php
YourMultiResourcePlugin::make()
    ->resource(UserResource::class)
        ->navigationLabel(fn() => 'Users (' . User::count() . ')')
        ->navigationGroup('Admin')
        ->globallySearchable(true)
        ->globalSearchResultsLimit(25)
        ->tenantScope(false)
        
    ->resource(PostResource::class)
        ->navigationLabel(fn() => 'Posts (' . Post::published()->count() . ')')
        ->navigationGroup('Content')
        ->globallySearchable(true)
        ->globalSearchResultsLimit(10)
        ->tenantScope(true)
        ->tenantRelationshipName('organization')
        
    ->resource(CategoryResource::class)
        ->navigationLabel('Categories')
        ->navigationGroup('Content')
        ->globallySearchable(false)
        ->parentResource(PostResource::class);
```

### Backward Compatibility

Existing single-resource plugins continue to work without any changes:

```php
// This still works exactly as before
YourSingleResourcePlugin::make()
    ->navigationLabel('My Resource')
    ->navigationGroup('My Group')
    ->modelLabel('Item');
```

## 🧪 Testing

The package includes comprehensive tests covering all delegation scenarios:

```bash
composer test
composer test:coverage  # View coverage report
composer test:type      # Type coverage analysis
```

Current test coverage: **72.4%** with **73 tests** and **236 assertions**, including comprehensive multi-resource support testing.

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