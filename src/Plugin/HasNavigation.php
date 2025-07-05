<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Plugin;

use BackedEnum;
use Closure;
use Filament\Pages\Enums\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;

trait HasNavigation
{
    protected Closure | null | SubNavigationPosition $subNavigationPosition = null;

    protected bool | Closure $shouldRegisterNavigation = true;

    protected Closure | null | string $navigationBadgeTooltip = null;

    protected Closure | null | string | UnitEnum $navigationGroup = null;

    protected array | Closure | null | string $navigationBadgeColor = null;

    protected Closure | string | null $navigationBadge = null;

    protected Closure | string | null $navigationParentItem = null;

    protected BackedEnum | Closure | null | string $navigationIcon = null;

    protected BackedEnum | Closure | null | string $activeNavigationIcon = null;

    protected Closure | null | string $navigationLabel = null;

    protected Closure | int | null $navigationSort = null;

    // protected Closure | null | string $slug = null;

    public function subNavigationPosition(Closure | SubNavigationPosition $subNavigationPosition): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('subNavigationPosition', $subNavigationPosition);
        }

        $this->subNavigationPosition = $subNavigationPosition;

        return $this;
    }

    public function registerNavigation(bool | Closure $shouldRegisterNavigation): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('shouldRegisterNavigation', $shouldRegisterNavigation);
        }

        $this->shouldRegisterNavigation = $shouldRegisterNavigation;

        return $this;
    }

    public function navigationBadgeTooltip(string | Closure | null $tooltip): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationBadgeTooltip', $tooltip);
        }

        $this->navigationBadgeTooltip = $tooltip;

        return $this;
    }

    public function navigationBadge(Closure | null | string $value = null): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationBadge', $value);
        }

        $this->navigationBadge = $value;

        return $this;
    }

    public function navigationBadgeColor(array | Closure | string $color): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationBadgeColor', $color);
        }

        $this->navigationBadgeColor = $color;

        return $this;
    }

    public function navigationGroup(Closure | null | string | UnitEnum $group): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationGroup', $group);
        }

        $this->navigationGroup = $group;

        return $this;
    }

    public function navigationParentItem(string | Closure | null $item): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationParentItem', $item);
        }

        $this->navigationParentItem = $item;

        return $this;
    }

    public function navigationIcon(BackedEnum | Closure | null | string $icon): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationIcon', $icon);
        }

        $this->navigationIcon = $icon;

        return $this;
    }

    public function activeNavigationIcon(BackedEnum | Closure | null | string $icon): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('activeNavigationIcon', $icon);
        }

        $this->activeNavigationIcon = $icon;

        return $this;
    }

    public function navigationLabel(Closure | null | string $label): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationLabel', $label);
        }

        $this->navigationLabel = $label;

        return $this;
    }

    public function navigationSort(int | Closure | null $sort): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('navigationSort', $sort);
        }

        $this->navigationSort = $sort;

        return $this;
    }

    // public function slug(string | Closure | null $slug): static
    // {
    //     if (method_exists($this, 'setContextualProperty')) {
    //         return $this->setContextualProperty('slug', $slug);
    //     }

    //     $this->slug = $slug;

    //     return $this;
    // }

    public function getSubNavigationPosition(?string $resourceClass = null): SubNavigationPosition
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('subNavigationPosition', $resourceClass);
        } else {
            $value = $this->subNavigationPosition;
        }

        return $this->evaluate($value) ?? SubNavigationPosition::Start;
    }

    public function shouldRegisterNavigation(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('shouldRegisterNavigation', $resourceClass);
        } else {
            $value = $this->shouldRegisterNavigation;
        }

        return $this->evaluate($value);
    }

    public function getNavigationBadgeTooltip(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationBadgeTooltip', $resourceClass);
        } else {
            $value = $this->navigationBadgeTooltip;
        }

        return $this->evaluate($value);
    }

    public function getNavigationBadge(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationBadge', $resourceClass);
        } else {
            $value = $this->navigationBadge;
        }

        return $this->evaluate($value);
    }

    public function getNavigationBadgeColor(?string $resourceClass = null): array | string | null
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationBadgeColor', $resourceClass);
        } else {
            $value = $this->navigationBadgeColor;
        }

        return $this->evaluate($value);
    }

    public function getNavigationGroup(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationGroup', $resourceClass);
        } else {
            $value = $this->navigationGroup;
        }

        return $this->evaluate($value);
    }

    public function getNavigationParentItem(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationParentItem', $resourceClass);
        } else {
            $value = $this->navigationParentItem;
        }

        return $this->evaluate($value);
    }

    public function getNavigationIcon(?string $resourceClass = null): BackedEnum | Htmlable | null | string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationIcon', $resourceClass);
        } else {
            $value = $this->navigationIcon;
        }

        return $this->evaluate($value);
    }

    public function getActiveNavigationIcon(?string $resourceClass = null): BackedEnum | Htmlable | null | string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('activeNavigationIcon', $resourceClass);
        } else {
            $value = $this->activeNavigationIcon;
        }

        return $this->evaluate($value);
    }

    public function getNavigationLabel(?string $resourceClass = null): string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationLabel', $resourceClass);
        } else {
            $value = $this->navigationLabel;
        }

        return (string) $this->evaluate($value);
    }

    public function getNavigationSort(?string $resourceClass = null): ?int
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('navigationSort', $resourceClass);
        } else {
            $value = $this->navigationSort;
        }

        return $this->evaluate($value);
    }

    // public function getSlug(?string $resourceClass = null): ?string
    // {
    //     if (method_exists($this, 'getContextualProperty')) {
    //         $value = $this->getContextualProperty('slug', $resourceClass);
    //     } else {
    //         $value = $this->slug;
    //     }

    //     return $this->evaluate($value);
    // }
}
