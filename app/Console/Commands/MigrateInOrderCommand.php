<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_in_order {db : The database connection to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs migrations in a specified order, optionally targeting a specific database connection';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $database = $this->argument('db') ?? env('DB_DATABASE');

        $this->call('migrate:fresh', [
            '--database' => $database,
        ]);

        $migrations = $database !== 'stats' ? $this->getAppMigrations() : $this->getStatsMigrations();

        foreach ($migrations as $path) {
            $this->call('migrate', [
                '--path' => $path,
                '--database' => $database,
            ]);
        }

        if ($database !== 'stats') {
            $this->call('db:seed', [
                '--database' => $database,
            ]);
        }
    }

    /**
     *
     * @return array
     */
    protected function getAppMigrations(): array
    {
        return [
            'database/migrations/laravel/.*',

            'database/migrations/location/.*',
            'database/migrations/currency/.*',
            'database/migrations/page/.*',
//            "database/migrations/slider/.*",
            'database/migrations/category/.*',
            'database/migrations/product/.*',
//            "database/migrations/filters/.*",
            'database/migrations/subscription/.*',
            'database/migrations/customer/.*',
            'database/migrations/admin/.*',
            'database/migrations/app_menu/.*',
            'database/migrations/order/.*',

        ];
    }

    /**
     * Returnează căile migrărilor pentru stats.
     *
     * @return array
     */
    protected function getStatsMigrations(): array
    {
        return [
            'database/migrations/stats/.*',
        ];
    }
}
