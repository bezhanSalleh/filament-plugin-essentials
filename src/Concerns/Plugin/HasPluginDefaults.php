<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use Filament\Support\Concerns\EvaluatesClosures;

trait HasPluginDefaults
{
    use EvaluatesClosures;

    protected array $userSetProperties = [];

    public function hasResolvedEssentialsProperty(string $property, ?string $resourceClass = null): bool
    {
        if ($this->hasEssentialsUserValue($property, $resourceClass)) {
            return true;
        }

        return $this->getPluginDefault($property, $resourceClass) !== null;
    }

    public function resolveEssentialsProperty(string $property, ?string $resourceClass = null): mixed
    {
        if ($this->hasEssentialsUserValue($property, $resourceClass)) {
            return $this->evaluate($this->getEssentialsUserValue($property, $resourceClass));
        }

        return $this->evaluate($this->getPluginDefault($property, $resourceClass));
    }

    protected function hasEssentialsUserValue(string $property, ?string $resourceClass = null): bool
    {
        if (method_exists($this, 'hasContextualProperty') && $this->hasContextualProperty($property, $resourceClass)) {
            return true;
        }

        return $this->isPropertyUserSet($property);
    }

    protected function getEssentialsUserValue(string $property, ?string $resourceClass = null): mixed
    {
        if (method_exists($this, 'hasContextualProperty') && $this->hasContextualProperty($property, $resourceClass)) {
            return $this->getRawContextualProperty($property, $resourceClass);
        }

        return $this->{$property} ?? null;
    }

    protected function getPropertyWithDefaults(string $property, ?string $resourceClass = null): mixed
    {
        return $this->resolveEssentialsProperty($property, $resourceClass);
    }

    protected function fillEssentialsProperty(string $property, mixed $value): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty($property, $value);
        }

        return $this->setUserProperty($property, $value);
    }

    protected function markPropertyAsUserSet(string $property): void
    {
        $this->userSetProperties[$property] = true;
    }

    protected function isPropertyUserSet(string $property): bool
    {
        return isset($this->userSetProperties[$property]);
    }

    protected function setUserProperty(string $property, mixed $value): static
    {
        $this->$property = $value;
        $this->markPropertyAsUserSet($property);

        return $this;
    }

    protected function getPluginDefault(string $property, ?string $resourceClass = null): mixed
    {
        // Try specific method first (e.g., getDefaultNavigationIcon)
        $specificMethod = 'getDefault' . ucfirst($property);
        if (method_exists($this, $specificMethod)) {
            return $this->$specificMethod($resourceClass);
        }

        // Try array-based defaults
        if (method_exists($this, 'getPluginDefaults')) {
            $defaults = $this->getPluginDefaults();

            // Check for forResource-specific defaults first
            if (! in_array($resourceClass, [null, '', '0'], true)) {
                // New nested structure: 'resources' => [ResourceClass::class => [...]]
                if (isset($defaults['resources'][$resourceClass][$property])) {
                    return $defaults['resources'][$resourceClass][$property];
                }

                // Legacy flat structure: ResourceClass::class => [...]
                if (isset($defaults[$resourceClass][$property])) {
                    return $defaults[$resourceClass][$property];
                }
            }

            // Check for global defaults
            if (isset($defaults[$property])) {
                return $defaults[$property];
            }
        }

        return null;
    }
}
