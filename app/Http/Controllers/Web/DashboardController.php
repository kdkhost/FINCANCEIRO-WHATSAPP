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

        // Métricas para o dashboard
        $metrics = [
            'tenants' => 1, // Tenant atual
            'users' => $tenant->users()->count(),
            'customers' => Customer::where('tenant_id', $tenant->id)->count(),
            'invoices_total' => Invoice::where('tenant_id', $tenant->id)
                ->where('status', 'paid')
                ->sum('total'),
        ];

        // Últimas faturas
        $latestInvoices = Invoice::where('tenant_id', $tenant->id)
            ->with(['customer', 'tenant'])
            ->latest()
            ->limit(10)
            ->get();

        // Clientes recentes
        $latestCustomers = Customer::where('tenant_id', $tenant->id)
            ->with('tenant')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'latestInvoices' => $latestInvoices,
            'latestCustomers' => $latestCustomers,
        ]);
    }
}
