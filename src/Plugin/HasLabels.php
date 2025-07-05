<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Plugin;

use Closure;

trait HasLabels
{
    protected string | Closure | null $modelLabel = null;

    protected string | Closure | null $pluralModelLabel = null;

    protected string | Closure | null $recordTitleAttribute = null;

    protected bool | Closure $hasTitleCaseModelLabel = true;

    public function modelLabel(string | Closure | null $label): static
    {
        $this->modelLabel = $label;

        return $this;
    }

    public function pluralModelLabel(string | Closure | null $label): static
    {
        $this->pluralModelLabel = $label;

        return $this;
    }

    public function titleCaseModelLabel(bool | Closure $condition = true): static
    {
        $this->hasTitleCaseModelLabel = $condition;

        return $this;
    }

    public function recordTitleAttribute(string | Closure | null $attribute): static
    {
        $this->recordTitleAttribute = $attribute;

        return $this;
    }

    public function getModelLabel(): ?string
    {
        return $this->evaluate($this->modelLabel);
    }

    public function getPluralModelLabel(): ?string
    {
        return $this->evaluate($this->pluralModelLabel);
    }

    public function hasTitleCaseModelLabel(): bool
    {
        return $this->evaluate($this->hasTitleCaseModelLabel);
    }

    public function getRecordTitleAttribute(): ?string
    {
        return $this->evaluate($this->recordTitleAttribute);
    }
}
