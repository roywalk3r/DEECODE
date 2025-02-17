<?php

namespace App\Filament\Widgets;

use App\Models\Invoice; // Ensure this matches your Invoice model's namespace
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected ?string $heading = 'Analytics';
    protected ?string $description = 'An overview of market analysis based on Invoices.';
    protected static ?int $sort = 0;

    protected function getStats(): array
    {

        // Query invoices where status is 'refund' and calculate the total
        $totalRefunds = Invoice::where('status', 'refund')->sum('total');

        // Query invoices where status is 'refund' and calculate the total for this year
        $thisYearTotalRefunds = Invoice::where('status', 'refund')
            ->whereYear('date', now()->year)
            ->sum('total');
        // Query invoices and calculate the total for this year after refunds
         $totalAfterRefunds = Invoice::where('status', '!=', 'refund')
            ->whereYear('date', now()->year)
            ->sum('total');

      //Query invoices to calculate the total for this year
        $thisYearTotalSum = Invoice::whereYear('date', now()->year)->sum('total');
        return [

           Stat::make('This Year Total After Refunds', number_format($totalAfterRefunds, 2))
               ->description('This Year Total After Refunds')
               ->descriptionIcon('heroicon-o-currency-dollar')
               ->chart([7, 2, 10, 3, 15, 4, 17])
               ->color('danger'),
            Stat::make('This Year', number_format($thisYearTotalSum, 2))
                ->description('The total money from invoices made this year')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Total Refunds', number_format($totalRefunds,2))
                ->description('The total funds made this year')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
        ];
    }
}
