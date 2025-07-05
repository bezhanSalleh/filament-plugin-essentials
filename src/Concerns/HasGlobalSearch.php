<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns;

use Closure;

trait HasGlobalSearch
{
    protected int $globalSearchResultsLimit = 50;

    protected bool | Closure $isGloballySearchable = true;

    protected bool | Closure | null $isGlobalSearchForcedCaseInsensitive = null;

    protected bool | Closure $shouldSplitGlobalSearchTerms = false;

    public function globalSearchResultsLimit(int $limit): static
    {
        $this->globalSearchResultsLimit = $limit;

        return $this;
    }

    public function globallySearchable(bool | Closure $condition = true): static
    {
        $this->isGloballySearchable = $condition;

        return $this;
    }

    public function forceGlobalSearchCaseInsensitive(bool | Closure | null $condition = true): static
    {
        $this->isGlobalSearchForcedCaseInsensitive = $condition;

        return $this;
    }

    public function splitGlobalSearchTerms(bool | Closure $condition = true): static
    {
        $this->shouldSplitGlobalSearchTerms = $condition;

        return $this;
    }

    public function canGloballySearch(): bool
    {
        return $this->evaluate($this->isGloballySearchable);
    }

    public function getGlobalSearchResultsLimit(): int
    {
        return $this->evaluate($this->globalSearchResultsLimit);
    }

    public function isGlobalSearchForcedCaseInsensitive(): ?bool
    {
        return $this->evaluate($this->isGlobalSearchForcedCaseInsensitive);
    }

    public function shouldSplitGlobalSearchTerms(): bool
    {
        return $this->evaluate($this->shouldSplitGlobalSearchTerms);
    }
}
