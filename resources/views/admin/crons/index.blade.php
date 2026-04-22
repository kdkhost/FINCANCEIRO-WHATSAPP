@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Operacao manual e automatica</span>
                    <h1 class="mb-0 mt-3">Central de crons</h1>
                </div>
                <div class="text-end text-muted">
                    Todas as rotinas do SaaS agrupadas por categoria com execucao manual.
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @unless ($hasCronTable)
                <div class="alert alert-warning border-0 shadow-sm">
                    Rode <code>php artisan migrate</code> para criar a tabela de historico dos crons e liberar a execucao manual pelo painel.
                </div>
            @endunless

            <div class="row g-4">
                @foreach ($groups as $groupName => $tasks)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0 pt-4">
                                <h3 class="card-title fw-bold">{{ $groupName }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle" data-datatable>
                                        <thead>
                                            <tr>
                                                <th>Tarefa</th>
                                                <th>Comando</th>
                                                <th>Frequencia</th>
                                                <th>Ultima execucao</th>
                                                <th>Status</th>
                                                <th class="text-end">Acao</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                @php($lastExecution = $task['last_execution'])
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold">{{ $task['label'] }}</div>
                                                        <div class="text-muted small">{{ $task['description'] }}</div>
                                                    </td>
                                                    <td><code>{{ $task['command'] }}</code></td>
                                                    <td>{{ $task['frequency'] }}</td>
                                                    <td>
                                                        {{ $lastExecution?->finished_at?->format('d/m/Y H:i:s') ?? 'Nunca executado' }}
                                                    </td>
                                                    <td>
                                                        @php($status = $lastExecution?->status ?? 'pending')
                                                        <span class="badge text-bg-{{ $status === 'success' ? 'success' : ($status === 'failed' ? 'danger' : 'secondary') }}">
                                                            {{ strtoupper($status) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-primary"
                                                            data-run-cron
                                                            data-url="{{ route('admin.crons.run', $task['key']) }}"
                                                            data-task="{{ $task['label'] }}"
                                                            {{ $hasCronTable ? '' : 'disabled' }}
                                                        >
                                                            Executar agora
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Historico recente</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable>
                                    <thead>
                                        <tr>
                                            <th>Inicio</th>
                                            <th>Grupo</th>
                                            <th>Tarefa</th>
                                            <th>Origem</th>
                                            <th>Status</th>
                                            <th>Saida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($history as $item)
                                            <tr>
                                                <td>{{ $item->started_at?->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ $item->group_name }}</td>
                                                <td><code>{{ $item->command }}</code></td>
                                                <td>{{ strtoupper($item->triggered_by) }}</td>
                                                <td>
                                                    <span class="badge text-bg-{{ $item->status === 'success' ? 'success' : ($item->status === 'failed' ? 'danger' : 'secondary') }}">
                                                        {{ strtoupper($item->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-muted small">{{ \Illuminate\Support\Str::limit($item->output, 100) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    Nenhuma execucao registrada ainda.
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
        </div>
    </div>
@endsection
