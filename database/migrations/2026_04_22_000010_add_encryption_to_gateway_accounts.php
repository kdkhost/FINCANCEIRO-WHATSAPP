<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_gateway_accounts', function (Blueprint $table) {
            // Adicionar coluna para indicar que as chaves estão encriptadas
            $table->boolean('keys_encrypted')->default(true)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('payment_gateway_accounts', function (Blueprint $table) {
            $table->dropColumn('keys_encrypted');
        });
    }
};
