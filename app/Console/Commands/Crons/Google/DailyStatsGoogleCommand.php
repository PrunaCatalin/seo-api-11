<?php

namespace App\Console\Commands\Crons\Google;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Tenants\Entities\Stats\DailyStatsGoogle;
use Modules\Tenants\Entities\Stats\SessionDataGoogle;

class DailyStatsGoogleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron-start:google-daily-stats-start';

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
        $sessions = SessionDataGoogle::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(page_views) as total_page_views'),
            DB::raw('SUM(event) as total_events_count'),
            DB::raw('SUM(unique_visitors) as total_unique_visitors'),
            DB::raw('COUNT(*) as total_sessions_count'),
            'associated_domain_id',
            'tenant_id'
        )
            ->groupBy('date', 'associated_domain_id', 'tenant_id')
            ->get();

        foreach ($sessions as $session) {
            $topKeyword = $this->getTopValue(
                'keyword',
                $session->date,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topCountry = $this->getTopValue(
                'country',
                $session->date,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topRegion = $this->getTopValue(
                'region',
                $session->date,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topLanguage = $this->getTopValue(
                'language',
                $session->date,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );
            $topAgent = $this->getTopValue(
                'agent',
                $session->date,
                null,
                $session->associated_domain_id,
                $session->tenant_id
            );

            DailyStatsGoogle::insert([
                'date' => $session->date,
                'associated_domain_id' => $session->associated_domain_id,
                'tenant_id' => $session->tenant_id,
                'sessions_count' => $session->total_sessions_count,
                'unique_visitors' => $session->total_unique_visitors,
                'page_views' => $session->total_page_views,
                'events_count' => $session->total_sessions_count,
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

    private function getTopValue($field, $date, $month, $associated_domain_id, $tenant_id)
    {
        $query = SessionDataGoogle::whereDate('created_at', $date)
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('created_at', $month);
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
