<?php

namespace Tests\Feature\Jobs;

use App\Jobs\SendBillingReminderJob;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendBillingReminderJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_can_be_dispatched(): void
    {
        Queue::fake();

        $tenant = Tenant::factory()->create();
        $customer = Customer::factory()->create(['tenant_id' => $tenant->id]);
        $invoice = Invoice::factory()->create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        SendBillingReminderJob::dispatch($invoice);

        Queue::assertPushed(SendBillingReminderJob::class);
    }

    public function test_job_sends_email_for_pending_invoice(): void
    {
        Mail::fake();

        $tenant = Tenant::factory()->create();
        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
            'email' => 'customer@example.com',
        ]);
        $invoice = Invoice::factory()->create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        $job = new SendBillingReminderJob($invoice);
        $job->handle();

        Mail::assertSent(function ($mail) use ($customer) {
            return $mail->hasTo($customer->email);
        });
    }

    public function test_job_does_not_send_for_paid_invoice(): void
    {
        Mail::fake();

        $tenant = Tenant::factory()->create();
        $customer = Customer::factory()->create(['tenant_id' => $tenant->id]);
        $invoice = Invoice::factory()->create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'status' => 'paid',
        ]);

        $job = new SendBillingReminderJob($invoice);
        $job->handle();

        Mail::assertNothingSent();
    }
}
