@php($pageTitle = 'Templates - Admin')
@extends('layouts.admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <span class="badge-soft">Mensageria</span>
                    <h1 class="mb-0 mt-3">Templates e previews</h1>
                </div>
                <div class="text-end text-muted">
                    Templates por tenant com edicao, preview em tempo real e ativacao individual.
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-12 col-xxl-6">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Template de WhatsApp</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <form
                                        id="whatsapp-template-form"
                                        method="POST"
                                        action="{{ route('admin.templates.whatsapp.store') }}"
                                        data-ajax-form
                                        data-form-mode="create"
                                        data-success-reset="true"
                                        data-table-selector="#whatsapp-templates-table"
                                        data-template-preview-form="whatsapp"
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
                                            <label class="form-label">Tipo</label>
                                            <input type="text" name="type" class="form-control" value="invoice_due" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Nome interno</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Mensagem</label>
                                            <textarea
                                                name="body"
                                                class="form-control"
                                                rows="6"
                                                data-summernote
                                                data-template-preview-source="body"
                                                required
                                            ></textarea>
                                        </div>

                                        <label class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Ativo</span>
                                        </label>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary flex-fill" data-submit-label>Criar template</button>
                                            <button type="button" class="btn btn-outline-secondary" data-reset-form>Limpar</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-6">
                                    <div class="template-preview-card">
                                        <div class="template-preview-label">Preview do WhatsApp</div>
                                        <div class="whatsapp-preview">
                                            <div class="whatsapp-preview__bubble" data-template-preview-target="body">
                                                Ola {{nome}}, sua fatura de {{valor}} vence em {{data_vencimento}}.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable id="whatsapp-templates-table">
                                    <thead>
                                        <tr>
                                            <th>Tenant</th>
                                            <th>Template</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th class="text-end">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($whatsappTemplates as $template)
                                            @include('admin.templates.partials.whatsapp-row', ['template' => $template])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xxl-6">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h3 class="card-title fw-bold">Template de e-mail</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <form
                                        id="email-template-form"
                                        method="POST"
                                        action="{{ route('admin.templates.email.store') }}"
                                        data-ajax-form
                                        data-form-mode="create"
                                        data-success-reset="true"
                                        data-table-selector="#email-templates-table"
                                        data-template-preview-form="email"
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
                                            <label class="form-label">Tipo</label>
                                            <input type="text" name="type" class="form-control" value="invoice_due" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Nome interno</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Assunto</label>
                                            <input type="text" name="subject" class="form-control" data-template-preview-source="subject" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Corpo do e-mail</label>
                                            <textarea
                                                name="body"
                                                class="form-control"
                                                rows="6"
                                                data-summernote
                                                data-template-preview-source="body"
                                                required
                                            ></textarea>
                                        </div>

                                        <label class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                                            <span class="form-check-label">Ativo</span>
                                        </label>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary flex-fill" data-submit-label>Criar template</button>
                                            <button type="button" class="btn btn-outline-secondary" data-reset-form>Limpar</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-6">
                                    <div class="template-preview-card">
                                        <div class="template-preview-label">Preview do e-mail</div>
                                        <div class="email-preview">
                                            <div class="email-preview__subject" data-template-preview-target="subject">
                                                Sua fatura vence em {{data_vencimento}}
                                            </div>
                                            <div class="email-preview__body" data-template-preview-target="body">
                                                <p>Ola {{nome}}, sua fatura de {{valor}} esta pronta.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="table-responsive">
                                <table class="table table-striped align-middle" data-datatable id="email-templates-table">
                                    <thead>
                                        <tr>
                                            <th>Tenant</th>
                                            <th>Template</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th class="text-end">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($emailTemplates as $template)
                                            @include('admin.templates.partials.email-row', ['template' => $template])
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
