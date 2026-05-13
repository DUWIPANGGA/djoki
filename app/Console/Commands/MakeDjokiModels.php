<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeDjokiModels extends Command
{
    protected $signature = 'make:djoki-models {--m : Create migration files}';

    protected $description = 'Generate all D\'JOKI platform models';

    protected $models = [
        'User',               // sudah ada, bisa di-skip
        'ServiceCategory',
        'Service',
        'ProviderService',
        'Order',
        'OrderMilestone',
        'OrderFile',
        'Message',
        'Review',
        'Revision',
        'Portfolio',
        'Payment',
        'ProviderStatistic',
        'VerificationDocument',
        'OrderTrackingLog',
        'PrivacySetting',
    ];

    public function handle()
    {
        $withMigration = $this->option('m');

        foreach ($this->models as $model) {
            // Skip User karena sudah ada dari Laravel default
            if ($model === 'User') {
                $this->warn('Skipping User model (already exists).');

                continue;
            }

            $command = "make:model {$model}";
            if ($withMigration) {
                $command .= ' -m';
            }

            $this->info("Creating model: {$model}");
            Artisan::call($command);
            $this->line(Artisan::output());
        }

        $this->info("All D'JOKI models generated successfully.");
    }
}
