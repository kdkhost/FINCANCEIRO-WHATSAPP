<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? config('app.name').' - Admin' }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <span class="navbar-toggler-icon"></span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Ver site</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link border-0">Sair</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="/admin/dashboard" class="brand-link">
                    <span class="brand-text fw-light">Financeiro Pro Whats</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-3">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                        <li class="nav-item">
                            <a href="/admin/dashboard" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/crons" class="nav-link {{ request()->routeIs('admin.crons.*') ? 'active' : '' }}">
                                <p>Central de Crons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.tenants.index') }}" class="nav-link {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">
                                <p>Tenants</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                                <p>Clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.invoices.index') }}" class="nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
                                <p>Cobrancas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gateways.index') }}" class="nav-link {{ request()->routeIs('admin.gateways.*') ? 'active' : '' }}">
                                <p>Gateways</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.templates.index') }}" class="nav-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}">
                                <p>Templates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.webhooks.logs.index') }}" class="nav-link {{ request()->routeIs('admin.webhooks.logs.*') ? 'active' : '' }}">
                                <p>Logs de Webhook</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
