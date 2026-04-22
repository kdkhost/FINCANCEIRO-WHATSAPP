<tr data-row-id="{{ $template->id }}">
    <td>{{ $template->tenant?->name }}</td>
    <td>
        <div class="fw-semibold">{{ $template->name }}</div>
        <div class="text-muted small">{{ $template->subject }}</div>
    </td>
    <td>{{ $template->type }}</td>
    <td>
        <span class="badge text-bg-{{ $template->is_active ? 'success' : 'secondary' }}">
            {{ $template->is_active ? 'ATIVO' : 'INATIVO' }}
        </span>
    </td>
    <td class="text-end">
        <div class="d-inline-flex gap-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-edit-record
                data-form-selector="#email-template-form"
                data-url="{{ route('admin.templates.email.update', $template) }}"
                data-method="PUT"
                data-record='@json([
                    'tenant_id' => $template->tenant_id,
                    'type' => $template->type,
                    'name' => $template->name,
                    'subject' => $template->subject,
                    'body' => $template->body,
                    'is_active' => $template->is_active,
                ])'
            >
                Editar
            </button>
            <button
                type="button"
                class="btn btn-sm btn-outline-danger"
                data-ajax-delete
                data-url="{{ route('admin.templates.email.destroy', $template) }}"
                data-label="{{ $template->name }}"
            >
                Excluir
            </button>
        </div>
    </td>
</tr>
