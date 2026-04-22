<tr data-row-id="{{ $tenant->id }}">
    <td>{{ $tenant->name }}</td>
    <td>{{ $tenant->slug }}</td>
    <td>{{ $tenant->primary_domain ?: '-' }}</td>
    <td>{{ ucfirst($tenant->status) }}</td>
    <td class="text-end">
        <div class="d-inline-flex gap-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-edit-record
                data-form-selector="#tenant-form"
                data-url="{{ route('admin.tenants.update', $tenant) }}"
                data-method="PUT"
                data-record='@json($tenant)'
            >
                Editar
            </button>
            <button
                type="button"
                class="btn btn-sm btn-outline-danger"
                data-ajax-delete
                data-url="{{ route('admin.tenants.destroy', $tenant) }}"
                data-label="{{ $tenant->name }}"
            >
                Excluir
            </button>
        </div>
    </td>
</tr>
