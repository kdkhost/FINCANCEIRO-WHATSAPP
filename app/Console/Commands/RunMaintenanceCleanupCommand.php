<?php

namespace App\Console\Commands;

use App\Models\CronExecution;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RunMaintenanceCleanupCommand extends Command
{
    protected $signature = 'financeiro:maintenance-cleanup';

    protected $description = 'Executa limpeza de manutenção do sistema';

    public function handle(): int
    {
        $startTime = now();
        $cronName = 'maintenance_cleanup';

        try {
            $this->info('Iniciando limpeza de manutenção...');

            // 1. Limpar arquivos temporários
            $this->cleanTemporaryFiles();

            // 2. Limpar cache
            $this->cleanCache();

            // 3. Otimizar banco de dados
            $this->optimizeDatabase();

            $this->info('Limpeza de manutenção concluída com sucesso.');
            Log::info("Maintenance cleanup executed successfully");

            // Registrar execução bem-sucedida
            CronExecution::create([
                'name' => $cronName,
                'status' => 'success',
                'started_at' => $startTime,
                'finished_at' => now(),
                'output' => 'Maintenance cleanup executed successfully',
            ]);

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error running maintenance cleanup: {$e->getMessage()}");
            Log::error("Maintenance cleanup failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Registrar execução com erro
            CronExecution::create([
                'name' => $cronName,
                'status' => 'failed',
                'started_at' => $startTime,
                'finished_at' => now(),
                'output' => $e->getMessage(),
            ]);

            return self::FAILURE;
        }
    }

    private function cleanTemporaryFiles(): void
    {
        try {
            $tempPath = storage_path('app/temp');
            if (is_dir($tempPath)) {
                $files = glob($tempPath . '/*');
                $count = 0;
                foreach ($files as $file) {
                    if (is_file($file) && filemtime($file) < now()->subHours(24)->timestamp) {
                        unlink($file);
                        $count++;
                    }
                }
                $this->info("Deleted {$count} temporary files");
            }
        } catch (\Exception $e) {
            Log::warning("Error cleaning temporary files: {$e->getMessage()}");
        }
    }

    private function cleanCache(): void
    {
        try {
            $this->call('cache:clear');
            $this->info("Cache cleared successfully");
        } catch (\Exception $e) {
            Log::warning("Error clearing cache: {$e->getMessage()}");
        }
    }

    private function optimizeDatabase(): void
    {
        try {
            // Otimizar tabelas MySQL
            $connection = \DB::connection();
            $tables = $connection->select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $count = 0;

            foreach ($tables as $table) {
                $tableName = $table->{'Tables_in_' . $dbName} ?? null;
                if ($tableName) {
                    $connection->statement("OPTIMIZE TABLE {$tableName}");
                    $count++;
                }
            }

            $this->info("Optimized {$count} database tables");
        } catch (\Exception $e) {
            Log::warning("Error optimizing database: {$e->getMessage()}");
        }
    }
}
