<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('status')->default('draft');
            $table->string('description')->nullable();
            $table->date('due_date');
            $table->decimal('total', 12, 2)->default(0);
            $table->string('gateway')->nullable();
            $table->text('payment_url')->nullable();
            $table->string('external_reference')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
