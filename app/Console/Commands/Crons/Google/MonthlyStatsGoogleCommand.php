<?php

namespace App\Console\Commands\Crons\Google;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Tenants\Entities\Stats\DailyStatsGoogle;
use Modules\Tenants\Entities\Stats\MonthlyStatsGoogle;

class MonthlyStatsGoogleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron-start:google-monthly-stats-start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sessions = DailyStatsGoogle::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            'associated_domain_id',
            'tenant_id'
        )
            ->groupBy('year', 'month', 'associated_domain_id', 'tenant_id')
            ->get();

        foreach ($sessions as $session) {
            // Exemplu pentru top_keyword, aceeași logică poate fi aplicată pentru celelalte câmpuri "top"
            $topKeyword = $this->getTopValue(
                'top_keyword',
                $session->year,
                $session->month,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topCountry = $this->getTopValue(
                'top_country',
                $session->year,
                $session->month,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topRegion = $this->getTopValue(
                'top_region',
                $session->year,
                $session->month,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topLanguage = $this->getTopValue(
                'top_language',
                $session->year,
                $session->month,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topAgent = $this->getTopValue(
                'top_agent',
                $session->year,
                $session->month,
                $session->associated_domain_id,
                $session->tenant_id
            );

            MonthlyStatsGoogle::insert([
                'year' => $session->year,
                'month' => $session->month,
                'associated_domain_id' => $session->associated_domain_id,
                'tenant_id' => $session->tenant_id,
                'sessions_count' => DailyStatsGoogle::whereYear('date', $session->year)->whereMonth(
                    'date',
                    $session->month
                )->count(),
                'unique_visitors' => DailyStatsGoogle::whereYear('date', $session->year)->whereMonth(
                    'date',
                    $session->month
                )->distinct('tenant_id')->count(),
                'page_views' => DailyStatsGoogle::whereYear('date', $session->year)->whereMonth(
                    'date',
                    $session->month
                )->sum('page_views'),
                'events_count' => DailyStatsGoogle::whereYear('date', $session->year)->whereMonth(
                    'date',
                    $session->month
                )->count('events_count'),
                'top_keyword' => $topKeyword,
                'top_country' => $topCountry,
                'top_region' => $topRegion,
                'top_language' => $topLanguage,
                'top_agent' => $topAgent,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function getTopValue($field, $year, $month, $associated_domain_id, $tenant_id)
    {
        $query = DailyStatsGoogle::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('associated_domain_id', $associated_domain_id)
            ->where('tenant_id', $tenant_id)
            ->select($field, DB::raw('COUNT(' . $field . ') as count'))
            ->groupBy($field)
            ->orderBy('count', 'DESC')
            ->first();

        return $query ? $query->$field : null;
    }
}
