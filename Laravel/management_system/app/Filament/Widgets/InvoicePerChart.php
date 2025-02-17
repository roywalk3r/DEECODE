<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoicePerChart extends ChartWidget
{
    protected static ?string $heading = 'Invoices Per Month';

    protected static string $color = 'info';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';
protected int | string | array $columnSpan = 'full';
    // Define the default filter as the current year
    public ?string $filter = null;

    public function mount(): void
    {
        // Initialize the filter with the current year
        $this->filter = Carbon::now()->year;
    }
    protected function getFilters(): ?array
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 5, $currentYear);

        $yearFilters = [];
        foreach ($years as $year) {
            $yearFilters[(string) $year] = $year;
        }

        return $yearFilters;
    }
    protected function getMonthlyInvoiceData(): array
    {
        // Use the selected year for filtering, defaulting to the current year
        $selectedYear = $this->filter ?? now()->year;

        // Query to get the total for each month of the selected year
        $monthlyOrders = Invoice::query()
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(total) as total'))
            ->whereYear('date', $selectedYear)
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total', 'month')
            ->toArray();

        // Populate the data array with monthly totals, or 0 for months with no data
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $data[] = $monthlyOrders[$month] ?? 0; // No need to pad the month key
        }

        return $data;
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Invoices Per Month',
                    'data' => $this->getMonthlyInvoiceData(),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

}
