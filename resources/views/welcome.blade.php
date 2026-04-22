@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0">Inicio</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-4 p-lg-5">
                            <span class="eyebrow">Financeiro Pro Whats</span>
                            <h1>SaaS multi-tenant para cobrancas, contratos e operacao financeira.</h1>
                            <p>
                                Base inicial preparada com AdminLTE 4, DataTables, Summernote, React, PWA,
                                gateways e automacoes de WhatsApp.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modulos previstos</h3>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Tenancy e planos</li>
                                <li>Financeiro e cobrancas</li>
                                <li>WhatsApp, e-mail e templates</li>
                                <li>CRM, Kanban e agenda</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
