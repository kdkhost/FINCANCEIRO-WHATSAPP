<tr data-row-id="{{ $customer->id }}">
    <td>{{ $customer->tenant?->name }}</td>
    <td>{{ $customer->name }}</td>
    <td>{{ $customer->phone ?: '-' }}</td>
    <td>{{ $customer->document_number ?: '-' }}</td>
    <td class="text-end">
        <div class="d-inline-flex gap-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-edit-record
                data-form-selector="#customer-form"
                data-url="{{ route('admin.customers.update', $customer) }}"
                data-method="PUT"
                data-record='@json($customer)'
            >
                Editar
            </button>
            <button
                type="button"
                class="btn btn-sm btn-outline-danger"
                data-ajax-delete
                data-url="{{ route('admin.customers.destroy', $customer) }}"
                data-label="{{ $customer->name }}"
            >
                Excluir
            </button>
        </div>
    </td>
</tr>
