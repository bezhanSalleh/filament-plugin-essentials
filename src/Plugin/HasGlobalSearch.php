<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Plugin;

use Closure;

trait HasGlobalSearch
{
    protected int $globalSearchResultsLimit = 50;

    protected bool | Closure $isGloballySearchable = true;

    protected bool | Closure | null $isGlobalSearchForcedCaseInsensitive = null;

    protected bool | Closure $shouldSplitGlobalSearchTerms = false;

    public function globalSearchResultsLimit(int $limit): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('globalSearchResultsLimit', $limit);
        }

        $this->globalSearchResultsLimit = $limit;

        return $this;
    }

    public function globallySearchable(bool | Closure $condition = true): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('isGloballySearchable', $condition);
        }

        $this->isGloballySearchable = $condition;

        return $this;
    }

    public function forceGlobalSearchCaseInsensitive(bool | Closure | null $condition = true): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('isGlobalSearchForcedCaseInsensitive', $condition);
        }

        $this->isGlobalSearchForcedCaseInsensitive = $condition;

        return $this;
    }

    public function splitGlobalSearchTerms(bool | Closure $condition = true): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('shouldSplitGlobalSearchTerms', $condition);
        }

        $this->shouldSplitGlobalSearchTerms = $condition;

        return $this;
    }

    public function canGloballySearch(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('isGloballySearchable', $resourceClass);
        } else {
            $value = $this->isGloballySearchable;
        }

        return $this->evaluate($value);
    }

    public function isGloballySearchable(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('isGloballySearchable', $resourceClass);
        } else {
            $value = $this->isGloballySearchable;
        }

        return $this->evaluate($value);
    }

    public function getGlobalSearchResultsLimit(?string $resourceClass = null): int
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('globalSearchResultsLimit', $resourceClass);
        } else {
            $value = $this->globalSearchResultsLimit;
        }

        return $this->evaluate($value);
    }

    public function isGlobalSearchForcedCaseInsensitive(?string $resourceClass = null): ?bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('isGlobalSearchForcedCaseInsensitive', $resourceClass);
        } else {
            $value = $this->isGlobalSearchForcedCaseInsensitive;
        }

        return $this->evaluate($value);
    }

    public function shouldSplitGlobalSearchTerms(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('shouldSplitGlobalSearchTerms', $resourceClass);
        } else {
            $value = $this->shouldSplitGlobalSearchTerms;
        }

        return $this->evaluate($value);
    }
}
