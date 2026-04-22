@php($pageTitle = 'Cobrancas - Admin')
@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Financeiro</span>
                    <h1 class="mb-0 mt-3">Cobrancas</h1>
                </div>
                <div class="text-end text-muted">
                    Contas a receber com status, gateway e vencimento.
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Formulario da cobranca</h3>
                        </div>
                        <div class="card-body">
                            <form
                                id="invoice-form"
                                method="POST"
                                action="{{ route('admin.invoices.store') }}"
                                data-ajax-form
                                data-form-mode="create"
                                data-success-reset="true"
                                data-table-selector="#invoices-table"
                                class="d-grid gap-3"
                            >
                                @csrf
                                <input type="hidden" name="_method" value="POST" data-method-field>

                                <div>
                                    <label class="form-label">Tenant</label>
                                    <select name="tenant_id" class="form-select" data-tenant-select required>
                                        <option value="">Selecione</option>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Cliente</label>
                                    <select name="customer_id" class="form-select" data-customer-select required>
                                        <option value="">Selecione</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" data-tenant-id="{{ $customer->tenant_id }}">
                                                {{ $customer->tenant?->name }} - {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Codigo</label>
                                        <input type="text" name="code" class="form-control" placeholder="Gerado automaticamente se vazio">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="draft">Rascunho</option>
                                            <option value="pending">Pendente</option>
                                            <option value="paid">Pago</option>
                                            <option value="overdue">Vencido</option>
                                            <option value="cancelled">Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Vencimento</label>
                                        <input type="date" name="due_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Total</label>
                                        <input type="number" step="0.01" min="0" name="total" class="form-control" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Gateway</label>
                                    <select name="gateway" class="form-select">
                                        <option value="">Selecione</option>
                                        <option value="mercadopago">Mercado Pago</option>
                                        <option value="efi">Efi Pay</option>
                                        <option value="stripe">Stripe</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Descricao</label>
                                    <input type="text" name="description" class="form-control">
                                </div>

                                <div>
                                    <label class="form-label">URL de pagamento</label>
                                    <input type="url" name="payment_url" class="form-control">
                                </div>

                                <div>
                                    <label class="form-label">Referencia externa</label>
                                    <input type="text" name="external_reference" class="form-control">
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill" data-submit-label>Criar cobranca</button>
                                    <button type="button" class="btn btn-outline-secondary" data-reset-form>Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Lista de cobrancas</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable id="invoices-table">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Tenant</th>
                                            <th>Cliente</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th class="text-end">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            @include('admin.invoices.partials.row', ['invoice' => $invoice])
                                        @endforeach
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
