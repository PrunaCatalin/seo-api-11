<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Tenants\App\Services\Order\OrderService;

class OrderOverview extends BaseWidget
{

    protected static ?string $pollingInterval = '5s';
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Pending', $this->orderService->totalStatsPending(null)),
            Stat::make('Completed', $this->orderService->totalStatsCompleted(null)),
            Stat::make('Canceled', $this->orderService->totalStatsCancel(null)),
        ];
    }
}
