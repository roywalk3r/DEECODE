<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Chart Overview';
    protected static ?int $sort = 5;
    protected static ?string $maxHeight = '300px';

    protected static ?array $options = [
        'plugins' => [
            'scales' => [
                'display' => false,
            ],
        ],
    ];

    protected  function getStatusCount():array
    {
        return Invoice::query()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->toArray();
    }
    protected function getData(): array
    {



        return [
            'labels' => array_map(fn ($item) => $item['status'], $this->getStatusCount()),
            'datasets' => [
                [
                    'label' => 'Status Count',
                    'backgroundColor' => ['#4CAF50', '#f44336', '#ff9800', '#3f51b5', '#00bcd4','00bc8d' ],
                    'data' => array_map(fn ($item) => $item['count'], $this->getStatusCount()),
                    'borderWidth' => 1,
                    'borderColor' => 'rgba(75,192,192,1)',
                    'borderCapStyle' => 'butt',
                    'borderDash' => [],
                    'borderDashOffset' => 0.0,
                    'borderJoinStyle' =>'miter',
                    'hoverOffset'=>4,
                ],

            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

}
