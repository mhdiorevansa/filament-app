<?php

namespace App\Filament\Widgets;

use App\Models\Faktur;
use Filament\Widgets\ChartWidget;

class FakturChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Total Faktur Per Bulan';
    protected static ?string $pollingInterval = '5s';
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 1;
    }

    protected function getData(): array
    {
        $year = now()->year;
        $totals = Faktur::query()
            ->selectRaw('EXTRACT(MONTH FROM tanggal_faktur) as month, SUM(total_final) as total')
            ->whereRaw('EXTRACT(YEAR FROM tanggal_faktur) = ?', [now()->year])
            ->groupByRaw('EXTRACT(MONTH FROM tanggal_faktur)')
            ->orderByRaw('EXTRACT(MONTH FROM tanggal_faktur)')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[] = $totals[$month] ?? 0;
        }
        return [
            'datasets' => [
                [
                    'label' => "Total Faktur Tahun $year",
                    'data' => $monthlyData,
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
