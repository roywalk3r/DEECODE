<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaidStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = "Invoices Status";
    protected ?string $description = 'An overview of paid and what is left after refund.';
    protected function getStats(): array
    {
    //Query invoices to get all invoices with the status of paid
        $totalPaidInvoices = Invoice::where('status', 'paid')->sum('total');

        //Query invoices to get all invoices with the status of refunded
        $totalRefunds = Invoice::where('status', 'refund')->sum('total');

        //Subtract the total amount refunded from the total paid invoices to get the total paid invoices after refunds
        $totalPaidInovicesAfterRefund = Invoice::where('status', 'paid')->sum('total') - $totalRefunds;

        //Query invoices to get the total money for the last month
//        $totalMoneyForLastMonth = Invoice::whereBetween('date', [
//            now()->startOfMonth()->subMonth(),
//            now()->endOfMonth()->subMonth()
//        ])->sum('total');
        return [
            Stat::make('Paid Invoices', number_format($totalPaidInvoices, 2))
                ->description('All Paid Invoices total')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Paid Invoices After Refunds', number_format($totalPaidInovicesAfterRefund))
                ->description('All Paid Invoices total')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('secondary'),

            ];
    }
    public function  getColumns():int
    {
        return 2;
    }
}
