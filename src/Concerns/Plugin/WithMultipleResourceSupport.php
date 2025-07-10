<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

trait WithMultipleResourceSupport
{
    /**
     * Resource-specific configurations
     */
    protected array $resourceContexts = [];

    /**
     * Currently active resource context for chaining
     */
    protected ?string $activeResourceContext = null;

    /**
     * Set the resource context for the next configuration call
     */
    public function resource(string $resourceClass): static
    {
        $this->activeResourceContext = $resourceClass;

        return $this;
    }

    /**
     * Set a property value with resource context awareness
     */
    protected function setContextualProperty(string $property, mixed $value): static
    {
        if ($this->activeResourceContext) {
            // Store in resource-specific context
            if (! isset($this->resourceContexts[$this->activeResourceContext])) {
                $this->resourceContexts[$this->activeResourceContext] = [];
            }

            $this->resourceContexts[$this->activeResourceContext][$property] = $value;
            // Keep the activeResourceContext for method chaining
        } else {
            // Store as default/global value
            $this->$property = $value;
            // Mark as user-set so getContextualProperty knows it was explicitly set
            if (method_exists($this, 'markPropertyAsUserSet')) {
                $this->markPropertyAsUserSet($property);
            }
        }

        return $this;
    }

    /**
     * Get a property value with resource context awareness
     */
    protected function getContextualProperty(string $property, ?string $resourceClass = null): mixed
    {
        // If resource class is specified and has specific config, use it
        if ($resourceClass && isset($this->resourceContexts[$resourceClass][$property])) {
            return $this->resourceContexts[$resourceClass][$property];
        }

        // If no resource class or no resource-specific config, check if user explicitly set global property
        if (method_exists($this, 'isPropertyUserSet') && $this->isPropertyUserSet($property)) {
            return $this->$property ?? null;
        }

        // Return null to allow fallback to plugin defaults
        return null;
    }

    /**
     * Check if this plugin supports multi-resource configuration
     */
    public function supportsMultipleResources(): bool
    {
        return true;
    }
}
