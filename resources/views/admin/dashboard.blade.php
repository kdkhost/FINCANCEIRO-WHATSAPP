@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">AdminLTE 4 Backend</span>
                    <h1 class="mb-0 mt-3">Dashboard administrativo</h1>
                </div>
                <div class="text-end text-muted">
                    Base pronta para demonstracao multi-tenant com dados seedados.
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card metric-card">
                        <div class="card-body">
                            <div class="metric-label">Tenants</div>
                            <div class="metric-value">{{ number_format($metrics['tenants'], 0, ',', '.') }}</div>
                            <div class="metric-meta">Empresas ativas na demonstracao.</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card metric-card">
                        <div class="card-body">
                            <div class="metric-label">Usuarios</div>
                            <div class="metric-value">{{ number_format($metrics['users'], 0, ',', '.') }}</div>
                            <div class="metric-meta">Administradores e operadores populados.</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card metric-card">
                        <div class="card-body">
                            <div class="metric-label">Clientes</div>
                            <div class="metric-value">{{ number_format($metrics['customers'], 0, ',', '.') }}</div>
                            <div class="metric-meta">Base pronta para CRUDs e cobrancas.</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card metric-card">
                        <div class="card-body">
                            <div class="metric-label">Receita demo</div>
                            <div class="metric-value">R$ {{ number_format($metrics['invoices_total'], 2, ',', '.') }}</div>
                            <div class="metric-meta">Soma das faturas geradas nos seeders.</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Clientes recentes</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable>
                                    <thead>
                                        <tr>
                                            <th>Tenant</th>
                                            <th>Cliente</th>
                                            <th>Telefone</th>
                                            <th>Cidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($latestCustomers as $customer)
                                            <tr>
                                                <td>{{ $customer->tenant?->name }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->city }}/{{ $customer->state }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Rode migrate + db:seed para carregar os dados demo.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Faturas recentes</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable>
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Tenant</th>
                                            <th>Cliente</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($latestInvoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->code }}</td>
                                                <td>{{ $invoice->tenant?->name }}</td>
                                                <td>{{ $invoice->customer?->name }}</td>
                                                <td>{{ ucfirst($invoice->status) }}</td>
                                                <td>R$ {{ number_format((float) $invoice->total, 2, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Nenhuma fatura carregada ainda.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Template demo de WhatsApp</h3>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" data-summernote>Ola @{{nome}}, sua fatura de @{{valor}} vence em @{{data_vencimento}}. Pague agora por PIX, boleto ou cartao.</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
