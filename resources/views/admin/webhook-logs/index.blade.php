@php($pageTitle = 'Logs de Webhook - Admin')
@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Webhooks</span>
                    <h1 class="mb-0 mt-3">Logs de webhook</h1>
                </div>
                <div class="text-end text-muted">
                    Historico de chamadas por tenant, gateway e retorno processado.
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @unless ($hasWebhookTable)
                <div class="alert alert-warning border-0 shadow-sm">
                    Rode <code>php artisan migrate</code> para criar a tabela de logs de webhook.
                </div>
            @endunless

            <div class="card">
                <div class="card-header border-0 pt-4">
                    <h3 class="card-title fw-bold">Historico recente</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle" data-datatable>
                            <thead>
                                <tr>
                                    <th>Processado em</th>
                                    <th>Tenant</th>
                                    <th>Gateway</th>
                                    <th>Evento</th>
                                    <th>Status</th>
                                    <th>Resposta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $log->processed_at?->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $log->tenant?->name ?: '-' }}</td>
                                        <td class="text-capitalize">{{ $log->gateway }}</td>
                                        <td>{{ $log->event_type ?: '-' }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $log->status_code >= 200 && $log->status_code < 300 ? 'success' : 'danger' }}">
                                                {{ $log->status_code }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ \Illuminate\Support\Str::limit($log->response_body, 120) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Nenhum webhook registrado ainda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
