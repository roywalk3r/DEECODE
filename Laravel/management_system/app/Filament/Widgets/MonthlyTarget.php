<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyTarget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected  ?string $heading = 'Sales of this month and total Invoices';
    protected  ?string $description = 'Including refunds';
    protected function getStats(): array
    {
        //Get this month's sum
        $thisMonthsSum = Invoice::query()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total');
        //Get Last Year Sum
        $lastYearsSum = Invoice::query()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year - 1)
            ->sum('total');

        $totalInvoices = Invoice::sum('total') - Invoice::where('status', 'refund')->sum('total');
        //Return the stats array
        return [
            Stat::make('This month', number_format($thisMonthsSum, 2))
                ->description('Invoice Sum for this month' )
                ->descriptionIcon('heroicon-o-wallet')
                ->chart([7, 12, 5, 2, 1, 8, 14])
                ->color('secondary'),
            Stat::make('Total Invoice', number_format($totalInvoices, 2))
            ->description('Invoice Sum minus total refund' )
            ->descriptionIcon('heroicon-o-wallet')
            ->chart([3, 10, 1, 5, 9, 6, 11])
            ->color('primary'),
//            Stat::make('Monthly Target', '500,000')
//                ->description('Monthly Target' )
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
//                ->chart([3, 10, 1, 5, 9, 6, 11])
//                ->color('success'),
        ];
    }
    public function getColumns():int
    {
        return 2;
    }
}
