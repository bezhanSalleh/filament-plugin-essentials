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
     * Currently active forResource context for chaining
     */
    protected ?string $activeResourceContext = null;

    /**
     * Set the forResource context for the next configuration call
     */
    public function forResource(string $resourceClass): static
    {
        $this->activeResourceContext = $resourceClass;

        return $this;
    }

    /**
     * Set a property value with forResource context awareness
     */
    protected function setContextualProperty(string $property, mixed $value): static
    {
        if ($this->activeResourceContext) {
            // Store in forResource-specific context
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
     * Get a property value with forResource context awareness
     */
    protected function getContextualProperty(string $property, ?string $resourceClass = null): mixed
    {
        // If forResource class is specified and has specific config, use it
        if ($resourceClass && isset($this->resourceContexts[$resourceClass][$property])) {
            return $this->resourceContexts[$resourceClass][$property];
        }

        // If no forResource class or no forResource-specific config, check if user explicitly set global property
        if (method_exists($this, 'isPropertyUserSet') && $this->isPropertyUserSet($property)) {
            return $this->$property ?? null;
        }

        // Return null to allow fallback to plugin defaults
        return null;
    }

    /**
     * Check if this plugin supports multi-forResource configuration
     */
    public function supportsMultipleResources(): bool
    {
        return true;
    }
}
