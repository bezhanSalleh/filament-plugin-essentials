# Filament Plugin Essentials

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-plugin-essentials/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bezhansalleh/filament-plugin-essentials/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-plugin-essentials.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-plugin-essentials)

A comprehensive collection of essential traits that streamline Filament plugin development by providing a powerful **conditional trait-based method override system**. This allows plugin developers to offer end users a fluent, customizable API while maintaining clean separation of concerns and type safety.

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
- ✅ **Conditional delegation system** with automatic trait detection
- ✅ **Type-safe implementation** with full IntelliSense support
- ✅ **Fluent API** for end-user configuration
- ✅ **Graceful fallbacks** when plugins don't implement certain features
- ✅ **Closure support** for dynamic values
- ✅ **Comprehensive test coverage** (97%+)
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

## 🧪 Testing

The package includes comprehensive tests covering all delegation scenarios:

```bash
composer test
composer test:coverage  # View coverage report
composer test:type      # Type coverage analysis
```

Current test coverage: **97%+** with 188 tests and 326 assertions.

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