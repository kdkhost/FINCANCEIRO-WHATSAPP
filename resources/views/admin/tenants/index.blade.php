@php($pageTitle = 'Tenants - Admin')
@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Tenancy</span>
                    <h1 class="mb-0 mt-3">Tenants</h1>
                </div>
                <div class="text-end text-muted">
                    Cadastro e manutencao de empresas do SaaS.
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
                            <h3 class="card-title fw-bold">Formulario do tenant</h3>
                        </div>
                        <div class="card-body">
                            <form
                                id="tenant-form"
                                method="POST"
                                action="{{ route('admin.tenants.store') }}"
                                data-ajax-form
                                data-form-mode="create"
                                data-success-reset="true"
                                data-table-selector="#tenants-table"
                                class="d-grid gap-3"
                            >
                                @csrf
                                <input type="hidden" name="_method" value="POST" data-method-field>

                                <div>
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div>
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control">
                                </div>

                                <div>
                                    <label class="form-label">Dominio principal</label>
                                    <input type="text" name="primary_domain" class="form-control" placeholder="tenant.demo.local">
                                </div>

                                <div>
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="trial">Trial</option>
                                        <option value="active">Ativo</option>
                                        <option value="suspended">Suspenso</option>
                                        <option value="cancelled">Cancelado</option>
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Fim do trial</label>
                                        <input type="date" name="trial_ends_at" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fim da assinatura</label>
                                        <input type="date" name="subscription_ends_at" class="form-control">
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill" data-submit-label>Criar tenant</button>
                                    <button type="button" class="btn btn-outline-secondary" data-reset-form>Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Lista de tenants</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable id="tenants-table">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Slug</th>
                                            <th>Dominio</th>
                                            <th>Status</th>
                                            <th class="text-end">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tenants as $tenant)
                                            @include('admin.tenants.partials.row', ['tenant' => $tenant])
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
