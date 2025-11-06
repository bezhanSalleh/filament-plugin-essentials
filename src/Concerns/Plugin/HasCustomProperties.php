<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use Closure;

trait HasCustomProperties
{
    use HasPluginDefaults;

    protected array $customProperties = [];

    public function customProperties(array | Closure | null $customProperties): static
    {
        // Get plugin default customProperties
        $defaultProperties = $this->getPluginDefault('customProperties', $this->activeResourceContext ?? null);
        // merge customProperties
        $customProperties = array_merge($defaultProperties, $customProperties);

        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('customProperties', $customProperties);
        }

        $this->customProperties = $customProperties;
        $this->markPropertyAsUserSet('customProperties');

        return $this;
    }

    public function getCustomProperties(?string $resourceClass = null): ?array
    {
        return $this->getPropertyWithDefaults('customProperties', $resourceClass);
    }
}
