<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Login administrativo</title>
    @vite(['resources/css/admin.css'])
</head>
<body class="auth-page">
    <main class="auth-shell">
        <section class="auth-showcase">
            <span class="badge-soft">Painel do dono do SaaS</span>
            <h1>Controle o financeiro, a operacao e os tenants em um unico painel.</h1>
            <p>
                Ambiente administrativo em AdminLTE 4 com cron manual, cobrancas, clientes,
                operacao interna e base preparada para automacoes.
            </p>
            <div class="auth-grid">
                <article class="auth-mini-card">
                    <strong>Financeiro</strong>
                    <span>Fluxo, cobrancas e recorrencias.</span>
                </article>
                <article class="auth-mini-card">
                    <strong>Mensageria</strong>
                    <span>WhatsApp, notificacoes e filas.</span>
                </article>
                <article class="auth-mini-card">
                    <strong>Tenancy</strong>
                    <span>Planos, trial e operacao SaaS.</span>
                </article>
            </div>
        </section>

        <section class="auth-form-wrap">
            <div class="card auth-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h2 class="mb-2">Entrar no administrativo</h2>
                        <p class="text-muted mb-0">Acesso restrito ao dono do SaaS.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.store') }}" class="d-grid gap-3">
                        @csrf
                        <div>
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div>
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <label class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" value="1">
                            <span class="form-check-label">Manter conectado</span>
                        </label>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Entrar agora</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
