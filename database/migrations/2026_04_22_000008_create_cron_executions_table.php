<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cron_executions', function (Blueprint $table): void {
            $table->id();
            $table->string('task_key')->index();
            $table->string('group_name');
            $table->string('command');
            $table->string('triggered_by')->default('scheduler');
            $table->string('status')->default('pending');
            $table->longText('output')->nullable();
            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cron_executions');
    }
};
