<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanOldLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'logs:clean {--days=30 : Number of days to keep logs}';

    /**
     * The console command description.
     */
    protected $description = 'Clean old log files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Cleaning logs older than {$days} days...");

        $logsPath = storage_path('logs');
        $files = File::files($logsPath);
        $deletedCount = 0;

        foreach ($files as $file) {
            $fileTime = Carbon::createFromTimestamp(File::lastModified($file));

            if ($fileTime->lt($cutoffDate)) {
                File::delete($file);
                $deletedCount++;
                $this->line("Deleted: {$file->getFilename()}");
            }
        }

        $this->info("✅ Cleaned {$deletedCount} old log files.");

        return Command::SUCCESS;
    }
}
