<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Plugin;

use Closure;

trait BelongsToTenant
{
    protected bool | Closure $isScopedToTenant = true;

    protected string | Closure | null $tenantOwnershipRelationshipName = null;

    protected string | Closure | null $tenantRelationshipName = null;

    public function scopeToTenant(bool | Closure $condition = true): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('isScopedToTenant', $condition);
        }

        $this->isScopedToTenant = $condition;

        return $this;
    }

    public function tenantOwnershipRelationshipName(string | Closure | null $ownershipRelationshipName): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('tenantOwnershipRelationshipName', $ownershipRelationshipName);
        }

        $this->tenantOwnershipRelationshipName = $ownershipRelationshipName;

        return $this;
    }

    public function tenantRelationshipName(string | Closure | null $relationshipName): static
    {
        if (method_exists($this, 'setContextualProperty')) {
            return $this->setContextualProperty('tenantRelationshipName', $relationshipName);
        }

        $this->tenantRelationshipName = $relationshipName;

        return $this;
    }

    public function isScopedToTenant(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('isScopedToTenant', $resourceClass);
        } else {
            $value = $this->isScopedToTenant;
        }

        return $this->evaluate($value);
    }

    public function shouldScopeToTenant(?string $resourceClass = null): bool
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('isScopedToTenant', $resourceClass);
        } else {
            $value = $this->isScopedToTenant;
        }

        return $this->evaluate($value);
    }

    public function getTenantRelationshipName(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('tenantRelationshipName', $resourceClass);
        } else {
            $value = $this->tenantRelationshipName;
        }

        return $this->evaluate($value);
    }

    public function getTenantOwnershipRelationshipName(?string $resourceClass = null): ?string
    {
        if (method_exists($this, 'getContextualProperty')) {
            $value = $this->getContextualProperty('tenantOwnershipRelationshipName', $resourceClass);
        } else {
            $value = $this->tenantOwnershipRelationshipName;
        }

        return $this->evaluate($value);
    }
}
