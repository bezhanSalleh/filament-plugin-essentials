<?php

declare(strict_types=1);

namespace BezhanSalleh\PluginEssentials\Concerns\Plugin;

use Closure;

trait BelongsToTenant
{
    use HasPluginDefaults;

    protected bool | Closure $isScopedToTenant = true;

    protected string | Closure | null $tenantOwnershipRelationshipName = null;

    protected string | Closure | null $tenantRelationshipName = null;

    public function scopeToTenant(bool | Closure $condition = true): static
    {
        return $this->fillEssentialsProperty('isScopedToTenant', $condition);
    }

    public function tenantOwnershipRelationshipName(string | Closure | null $ownershipRelationshipName): static
    {
        return $this->fillEssentialsProperty('tenantOwnershipRelationshipName', $ownershipRelationshipName);
    }

    public function tenantRelationshipName(string | Closure | null $relationshipName): static
    {
        return $this->fillEssentialsProperty('tenantRelationshipName', $relationshipName);
    }

    public function isScopedToTenant(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('isScopedToTenant', $resourceClass) ?? true;
    }

    public function shouldScopeToTenant(?string $resourceClass = null): bool
    {
        return $this->getPropertyWithDefaults('isScopedToTenant', $resourceClass) ?? true;
    }

    public function getTenantRelationshipName(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('tenantRelationshipName', $resourceClass);
    }

    public function getTenantOwnershipRelationshipName(?string $resourceClass = null): ?string
    {
        return $this->getPropertyWithDefaults('tenantOwnershipRelationshipName', $resourceClass);
    }
}
