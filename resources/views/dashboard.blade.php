@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Receita recorrente</h3>
                            <p class="display-6 mt-3 mb-0">R$ 0,00</p>
                            <p class="text-muted mt-2">Widget inicial para ApexCharts/Chart.js.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Tenants ativos</h3>
                            <p class="display-6 mt-3 mb-0">0</p>
                            <p class="text-muted mt-2">Indicador inicial para o painel SaaS.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Cobrancas pendentes</h3>
                            <p class="display-6 mt-3 mb-0">0</p>
                            <p class="text-muted mt-2">Resumo inicial para o painel financeiro.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Clientes recentes</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>Telefone</th>
                                        <th>Cidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Nenhum registro carregado ainda.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
