<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return $this->index();
    }

    public function index()
    {
        $tenant = Auth::user()->tenant;

        // Estatísticas gerais
        $stats = [
            'total_customers' => Customer::where('tenant_id', $tenant->id)->count(),
            'total_invoices' => Invoice::where('tenant_id', $tenant->id)->count(),
            'pending_invoices' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'pending')
                ->count(),
            'overdue_invoices' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'overdue')
                ->count(),
            'paid_invoices' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'paid')
                ->count(),
        ];

        // Receita total
        $revenue = [
            'total' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'paid')
                ->sum('total'),
            'pending' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'pending')
                ->sum('total'),
            'overdue' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'overdue')
                ->sum('total'),
        ];

        // Últimas faturas
        $recentInvoices = Invoice::where('tenant_id', $tenant->id)
            ->with('customer')
            ->latest()
            ->limit(10)
            ->get();

        // Clientes recentes
        $recentCustomers = Customer::where('tenant_id', $tenant->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'revenue' => $revenue,
            'recentInvoices' => $recentInvoices,
            'recentCustomers' => $recentCustomers,
            'tenant' => $tenant,
        ]);
    }
}
