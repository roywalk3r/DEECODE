<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverdueUnpaidAndLastWeekStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected  ?string $heading = 'Sales of certain periods';
    protected  ?string $description = 'Including Unpaid Invoices';

    protected function getStats(): array
    {

        //Query invoices to get the total overdue invoices with the status of overdue
        $overdueInvoices = Invoice::query()
            ->where('status', 'overdue')
            ->count();

        //Query invoices to get the total unpaid invoices with the status of unpaid
        $unpaidInvoices = Invoice::query()
            ->where('status', 'unpaid')
            ->count();
        //Query invoices to the  total sum for the unpaid invoices
        $unpaidTotalSum = Invoice::query()
            ->where('status', 'unpaid')
            ->sum('total');
        //Query invoices to get the total invoices last week
        $lastWeekInvoices = Invoice::query()
            ->whereDate('date', '>=', now()->subDays(7))
            ->count();
        //Query invoices to get the total sum for the last week invoices
        $totalSumLastWeekInvoices = Invoice::query()
            ->whereDate('date', '>=', now()->subDays(7))
            ->sum('total');
        $totalMoneyForLastMonth = Invoice::whereBetween('date', [
            now()->startOfMonth()->subMonth(),
            now()->endOfMonth()->subMonth()
        ])->sum('total');
        return [
//            Stat::make('Overdue Invoices', number_format($overdueInvoices, 2))
//                ->description('All Paid Invoices total')
//                ->descriptionIcon('heroicon-o-currency-dollar')
//                ->chart([7, 2, 10, 3, 15, 4, 17])
//                ->color('secondary'),
            Stat::make('Last Month', number_format($totalMoneyForLastMonth, 2))
                ->description('All Paid Invoices total')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('secondary'),
            Stat::make('Unpaid Invoices', number_format($unpaidTotalSum, 2))
            ->description('Unpaid Invoices total' )
            ->descriptionIcon('heroicon-o-wallet')
            ->chart([7, 12, 5, 2, 1, 8, 14])
            ->color('danger'),
            Stat::make('Last Week Invoices', number_format($totalSumLastWeekInvoices, 2))
            ->description('Invoices last week')
            ->descriptionIcon('heroicon-o-calendar')
            ->chart([7, 12, 5, 2, 1, 8, 14])
            ->color('primary'),
        ];
    }
    public function getColumns(): int
    {
        return 3;
    }
}
