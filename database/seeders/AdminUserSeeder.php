<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar tenant admin se não existir
        $tenant = Tenant::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administração',
                'primary_domain' => 'admin.localhost',
                'status' => 'active',
            ]
        );

        // Criar usuário admin
        User::firstOrCreate(
            ['email' => 'admin@financeiroprowhats.com'],
            [
                'name' => 'Administrador',
                'tenant_id' => $tenant->id,
                'password' => Hash::make('admin123'),
                'is_saas_admin' => true,
            ]
        );

        $this->command->info('✅ Usuário admin criado com sucesso!');
        $this->command->info('📧 Email: admin@financeiroprowhats.com');
        $this->command->info('🔑 Senha: admin123');
        $this->command->warn('⚠️  IMPORTANTE: Altere a senha após o primeiro login!');
    }
}
