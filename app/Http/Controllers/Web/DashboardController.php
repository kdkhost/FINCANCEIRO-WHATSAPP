<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $hasBaseTables = Schema::hasTable('tenants')
            && Schema::hasTable('users')
            && Schema::hasTable('customers')
            && Schema::hasTable('invoices');

        $metrics = [
            'tenants' => $hasBaseTables ? Tenant::query()->count() : 0,
            'users' => $hasBaseTables ? User::query()->count() : 0,
            'customers' => $hasBaseTables ? Customer::query()->count() : 0,
            'invoices_total' => $hasBaseTables ? (float) Invoice::query()->sum('total') : 0.0,
        ];

        $latestCustomers = $hasBaseTables
            ? Customer::query()->with('tenant')->latest()->limit(8)->get()
            : new Collection();

        $latestInvoices = $hasBaseTables
            ? Invoice::query()->with(['tenant', 'customer'])->latest()->limit(8)->get()
            : new Collection();

        return view('admin.dashboard', compact('metrics', 'latestCustomers', 'latestInvoices'));
    }
}
