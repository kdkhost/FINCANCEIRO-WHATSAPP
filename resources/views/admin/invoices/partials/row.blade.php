<tr data-row-id="{{ $invoice->id }}">
    <td>{{ $invoice->code }}</td>
    <td>{{ $invoice->tenant?->name }}</td>
    <td>{{ $invoice->customer?->name }}</td>
    <td>{{ ucfirst($invoice->status) }}</td>
    <td>R$ {{ number_format((float) $invoice->total, 2, ',', '.') }}</td>
    <td class="text-end">
        <div class="d-inline-flex gap-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-edit-record
                data-form-selector="#invoice-form"
                data-url="{{ route('admin.invoices.update', $invoice) }}"
                data-method="PUT"
                data-record='@json($invoice)'
            >
                Editar
            </button>
            <button
                type="button"
                class="btn btn-sm btn-outline-danger"
                data-ajax-delete
                data-url="{{ route('admin.invoices.destroy', $invoice) }}"
                data-label="{{ $invoice->code }}"
            >
                Excluir
            </button>
        </div>
    </td>
</tr>
