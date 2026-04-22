<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $hasBaseTables = Schema::hasTable('tenants')
            && Schema::hasTable('users')
            && Schema::hasTable('invoices');

        $stats = [
            [
                'label' => 'Tenants ativos',
                'value' => (string) ($hasBaseTables ? Tenant::query()->count() : 0),
                'description' => 'Operacoes isoladas por tenant e plano.',
            ],
            [
                'label' => 'Usuarios demo',
                'value' => (string) ($hasBaseTables ? User::query()->count() : 0),
                'description' => 'Administradores e operadores prontos para teste.',
            ],
            [
                'label' => 'Faturas geradas',
                'value' => (string) ($hasBaseTables ? Invoice::query()->count() : 0),
                'description' => 'Base de cobranca populada para demonstracao.',
            ],
        ];

        $highlights = [
            [
                'title' => 'Frontend premium em React',
                'text' => 'Experiencia publica com Tailwind 4, visual editorial e foco em conversao.',
                'badge' => 'Frontend',
            ],
            [
                'title' => 'Painel AdminLTE 4',
                'text' => 'Backoffice administrativo com cara de sistema operacional, tabelas e produtividade.',
                'badge' => 'Backend',
            ],
            [
                'title' => 'Base demo pronta',
                'text' => 'Tenants, clientes, cobrancas e gateways serao criados pelos seeders de demonstracao.',
                'badge' => 'Demo',
            ],
        ];

        return view('frontend.index', compact('stats', 'highlights'));
    }
}
