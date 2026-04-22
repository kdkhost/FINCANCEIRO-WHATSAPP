@php($pageTitle = 'Clientes - Admin')
@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Clientes</span>
                    <h1 class="mb-0 mt-3">Clientes</h1>
                </div>
                <div class="text-end text-muted">
                    Cadastro unificado com mascara, CEP e endereco automatico.
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
                            <h3 class="card-title fw-bold">Formulario do cliente</h3>
                        </div>
                        <div class="card-body">
                            <form
                                id="customer-form"
                                method="POST"
                                action="{{ route('admin.customers.store') }}"
                                data-ajax-form
                                data-form-mode="create"
                                data-success-reset="true"
                                data-table-selector="#customers-table"
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

                                <div>
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Telefone</label>
                                        <input type="text" name="phone" class="form-control" data-mask="(99) 99999-9999">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Tipo</label>
                                        <select name="document_type" class="form-select">
                                            <option value="">Selecione</option>
                                            <option value="cpf">CPF</option>
                                            <option value="cnpj">CNPJ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Documento</label>
                                        <input type="text" name="document_number" class="form-control">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">CEP</label>
                                        <input type="text" name="zipcode" class="form-control" data-mask="99999-999" data-via-cep>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Endereco</label>
                                        <input type="text" name="address_line" class="form-control">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Numero</label>
                                        <input type="text" name="address_number" class="form-control">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Complemento</label>
                                        <input type="text" name="address_extra" class="form-control">
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Bairro</label>
                                        <input type="text" name="district" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Cidade</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">UF</label>
                                        <input type="text" name="state" class="form-control" maxlength="2">
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Observacoes</label>
                                    <textarea name="notes" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill" data-submit-label>Criar cliente</button>
                                    <button type="button" class="btn btn-outline-secondary" data-reset-form>Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Lista de clientes</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable id="customers-table">
                                    <thead>
                                        <tr>
                                            <th>Tenant</th>
                                            <th>Cliente</th>
                                            <th>Telefone</th>
                                            <th>Documento</th>
                                            <th class="text-end">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            @include('admin.customers.partials.row', ['customer' => $customer])
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
