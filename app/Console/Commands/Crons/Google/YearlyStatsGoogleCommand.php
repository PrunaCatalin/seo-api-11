<?php

namespace App\Console\Commands\Crons\Google;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Tenants\Entities\Stats\MonthlyStatsGoogle;
use Modules\Tenants\Entities\Stats\YearlyStatsGoogle;

class YearlyStatsGoogleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron-start:google-yearly-stats-start';

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
        $sessions = MonthlyStatsGoogle::select(
            DB::raw('year'),
            'associated_domain_id',
            'tenant_id'
        )
            ->groupBy('year', 'associated_domain_id', 'tenant_id')
            ->get();

        foreach ($sessions as $session) {
            $topKeyword = $this->getTopValue(
                'top_keyword',
                $session->year,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topCountry = $this->getTopValue(
                'top_country',
                $session->year,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topRegion = $this->getTopValue(
                'top_region',
                $session->year,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topLanguage = $this->getTopValue(
                'top_language',
                $session->year,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topAgent = $this->getTopValue(
                'top_agent',
                $session->year,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );

            YearlyStatsGoogle::insert([
                'year' => $session->year,
                'associated_domain_id' => $session->associated_domain_id,
                'tenant_id' => $session->tenant_id,
                'sessions_count' => MonthlyStatsGoogle::where('year', $session->year)->count(),
                'unique_visitors' => MonthlyStatsGoogle::where('year', $session->year)->distinct(
                    'tenant_id'
                )->count(),
                'page_views' => MonthlyStatsGoogle::where('year', $session->year)->sum('page_views'),
                'events_count' => MonthlyStatsGoogle::where('year', $session->year)->count('events_count'),
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
        $query = MonthlyStatsGoogle::whereYear('year', $year)
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('month', $month);
            })
            ->where('associated_domain_id', $associated_domain_id)
            ->where('tenant_id', $tenant_id)
            ->select($field, DB::raw('COUNT(' . $field . ') as count'))
            ->groupBy($field)
            ->orderBy('count', 'DESC')
            ->first();

        return $query ? $query->$field : null;
    }
}
