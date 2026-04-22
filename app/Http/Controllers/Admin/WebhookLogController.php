<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebhookLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class WebhookLogController extends Controller
{
    public function index(): View
    {
        $hasWebhookTable = Schema::hasTable('webhook_logs');

        $logs = $hasWebhookTable
            ? WebhookLog::query()->with('tenant')->latest('processed_at')->limit(100)->get()
            : new Collection();

        return view('admin.webhook-logs.index', compact('logs', 'hasWebhookTable'));
    }
}
