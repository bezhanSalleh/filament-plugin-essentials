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
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('modelLabel', $label);
        }

        $this->modelLabel = $label;

        return $this;
    }

    public function pluralModelLabel(string | Closure | null $label): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('pluralModelLabel', $label);
        }

        $this->pluralModelLabel = $label;

        return $this;
    }

    public function titleCaseModelLabel(bool | Closure $condition = true): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('hasTitleCaseModelLabel', $condition);
        }

        $this->hasTitleCaseModelLabel = $condition;

        return $this;
    }

    public function recordTitleAttribute(string | Closure | null $attribute): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('recordTitleAttribute', $attribute);
        }

        $this->recordTitleAttribute = $attribute;

        return $this;
    }

    public function getModelLabel(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('modelLabel', $resourceClass);
        } else {
            $value = $this->modelLabel;
        }

        return $this->evaluate($value);
    }

    public function getPluralModelLabel(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('pluralModelLabel', $resourceClass);
        } else {
            $value = $this->pluralModelLabel;
        }

        return $this->evaluate($value);
    }

    public function hasTitleCaseModelLabel(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('hasTitleCaseModelLabel', $resourceClass);
        } else {
            $value = $this->hasTitleCaseModelLabel;
        }

        return $this->evaluate($value);
    }

    public function getRecordTitleAttribute(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('recordTitleAttribute', $resourceClass);
        } else {
            $value = $this->recordTitleAttribute;
        }

        return $this->evaluate($value);
    }
}
