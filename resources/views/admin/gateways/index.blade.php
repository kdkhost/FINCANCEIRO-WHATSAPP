@php($pageTitle = 'Gateways - Admin')
@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Financeiro</span>
                    <h1 class="mb-0 mt-3">Gateways por tenant</h1>
                </div>
                <div class="text-end text-muted">
                    Mercado Pago, Efi e Stripe com configuracao individual por cliente.
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
                            <h3 class="card-title fw-bold">Formulario do gateway</h3>
                        </div>
                        <div class="card-body">
                            <form
                                id="gateway-form"
                                method="POST"
                                action="{{ route('admin.gateways.store') }}"
                                data-ajax-form
                                data-form-mode="create"
                                data-success-reset="true"
                                data-table-selector="#gateways-table"
                                class="d-grid gap-3"
                            >
                                @csrf
                                <input type="hidden" name="_method" value="POST" data-method-field>

                                <div>
                                    <label class="form-label">Tenant</label>
                                    <select name="tenant_id" class="form-select" required>
                                        <option value="">Selecione</option>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Gateway</label>
                                        <select name="gateway" class="form-select" required>
                                            <option value="mercadopago">Mercado Pago</option>
                                            <option value="efi">Efi Pay</option>
                                            <option value="stripe">Stripe</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nome interno</label>
                                        <input type="text" name="label" class="form-control" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Public key</label>
                                    <input type="text" name="public_key" class="form-control">
                                </div>

                                <div>
                                    <label class="form-label">Secret key</label>
                                    <textarea name="secret_key" class="form-control" rows="3"></textarea>
                                </div>

                                <div>
                                    <label class="form-label">Webhook secret</label>
                                    <input type="text" name="webhook_secret" class="form-control">
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Ativo</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-check">
                                            <input type="checkbox" name="sandbox" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Sandbox</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-check">
                                            <input type="checkbox" name="transparent_checkout" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Checkout transparente</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-check">
                                            <input type="checkbox" name="pass_gateway_fee" class="form-check-input" value="1">
                                            <span class="form-check-label">Repassar taxa</span>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="pix" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">PIX</span>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="boleto" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Boleto</span>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="card" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Cartao</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill" data-submit-label>Criar gateway</button>
                                    <button type="button" class="btn btn-outline-secondary" data-reset-form>Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Gateways cadastrados</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable id="gateways-table">
                                    <thead>
                                        <tr>
                                            <th>Tenant</th>
                                            <th>Gateway</th>
                                            <th>Configuracao</th>
                                            <th>Status</th>
                                            <th class="text-end">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($accounts as $account)
                                            @include('admin.gateways.partials.row', ['account' => $account])
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
