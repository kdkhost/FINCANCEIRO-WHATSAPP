<?php

namespace App\Support\Tenancy;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TenantResolver
{
    /**
     * Resolve tenant from request
     *
     * @param Request $request
     * @return Tenant|null
     */
    public function resolveFromRequest(Request $request): ?Tenant
    {
        $slug = $request->route('tenant');

        if (is_string($slug) && $slug !== '') {
            return $this->resolveTenant('slug', $slug);
        }

        $host = $request->getHost();

        return $this->resolveTenant('primary_domain', $host);
    }

    /**
     * Resolve tenant by attribute
     *
     * @param string $attribute
     * @param string $value
     * @return Tenant|null
     */
    private function resolveTenant(string $attribute, string $value): ?Tenant
    {
        $tenant = Tenant::query()
            ->where($attribute, $value)
            ->first();

        if (!$tenant) {
            Log::warning("Tenant not found", [
                'attribute' => $attribute,
                'value' => $value,
            ]);
            return null;
        }

        // Validar se o tenant está ativo
        if (!$this->isTenantActive($tenant)) {
            Log::warning("Tenant is not active", [
                'tenant_id' => $tenant->id,
                'status' => $tenant->status ?? 'unknown',
            ]);
            return null;
        }

        return $tenant;
    }

    /**
     * Verifica se o tenant está ativo
     *
     * @param Tenant $tenant
     * @return bool
     */
    private function isTenantActive(Tenant $tenant): bool
    {
        // Se o tenant tem coluna 'status', verificar se está ativo
        if (isset($tenant->status)) {
            return $tenant->status === 'active';
        }

        // Se o tenant tem coluna 'is_active', verificar
        if (isset($tenant->is_active)) {
            return (bool) $tenant->is_active;
        }

        // Se o tenant tem coluna 'suspended_at', verificar se não está suspenso
        if (isset($tenant->suspended_at)) {
            return $tenant->suspended_at === null;
        }

        // Por padrão, considerar como ativo
        return true;
    }

    /**
     * Resolve tenant by ID
     *
     * @param int $tenantId
     * @return Tenant|null
     */
    public function resolveById(int $tenantId): ?Tenant
    {
        $tenant = Tenant::find($tenantId);

        if (!$tenant || !$this->isTenantActive($tenant)) {
            return null;
        }

        return $tenant;
    }
}
