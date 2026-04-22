<tr data-row-id="{{ $account->id }}">
    <td>{{ $account->tenant?->name }}</td>
    <td>
        <div class="fw-semibold text-capitalize">{{ $account->gateway }}</div>
        <div class="text-muted small">{{ $account->label }}</div>
    </td>
    <td>
        <div class="d-flex flex-wrap gap-1">
            @foreach (['pix' => 'PIX', 'boleto' => 'Boleto', 'card' => 'Cartao'] as $key => $label)
                @if (data_get($account->settings, $key))
                    <span class="badge text-bg-light border">{{ $label }}</span>
                @endif
            @endforeach
            @if (data_get($account->settings, 'transparent_checkout'))
                <span class="badge text-bg-info">Transparente</span>
            @endif
            @if (data_get($account->settings, 'sandbox'))
                <span class="badge text-bg-warning">Sandbox</span>
            @endif
        </div>
    </td>
    <td>
        <span class="badge text-bg-{{ $account->is_active ? 'success' : 'secondary' }}">
            {{ $account->is_active ? 'ATIVO' : 'INATIVO' }}
        </span>
    </td>
    <td class="text-end">
        <div class="d-inline-flex gap-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-edit-record
                data-form-selector="#gateway-form"
                data-url="{{ route('admin.gateways.update', $account) }}"
                data-method="PUT"
                data-record='@json([
                    'tenant_id' => $account->tenant_id,
                    'gateway' => $account->gateway,
                    'label' => $account->label,
                    'public_key' => $account->public_key,
                    'secret_key' => $account->secret_key,
                    'webhook_secret' => $account->webhook_secret,
                    'is_active' => $account->is_active,
                    'sandbox' => (bool) data_get($account->settings, 'sandbox'),
                    'transparent_checkout' => (bool) data_get($account->settings, 'transparent_checkout'),
                    'pass_gateway_fee' => (bool) data_get($account->settings, 'pass_gateway_fee'),
                    'pix' => (bool) data_get($account->settings, 'pix'),
                    'boleto' => (bool) data_get($account->settings, 'boleto'),
                    'card' => (bool) data_get($account->settings, 'card'),
                ])'
            >
                Editar
            </button>
            <button
                type="button"
                class="btn btn-sm btn-outline-danger"
                data-ajax-delete
                data-url="{{ route('admin.gateways.destroy', $account) }}"
                data-label="{{ $account->label }}"
            >
                Excluir
            </button>
        </div>
    </td>
</tr>
