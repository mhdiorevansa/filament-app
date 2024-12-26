<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Faktur;
use App\Models\Penjualan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $totalBarang = Barang::count();
        $totalFaktur = Faktur::count();
        $totalPenjualan = Penjualan::count();

        $barangChange = $this->calculateChange(Barang::class, $totalBarang);
        $fakturChange = $this->calculateChange(Faktur::class, $totalFaktur);
        $penjualanChange = $this->calculateChange(Penjualan::class, $totalPenjualan);

        return [
            Stat::make('Total Barang', $totalBarang)
                ->description($barangChange['description'])
                ->descriptionIcon($barangChange['icon'])
                ->color($barangChange['color']),
            Stat::make('Total Faktur', $totalFaktur)
                ->description($fakturChange['description'])
                ->descriptionIcon($fakturChange['icon'])
                ->color($fakturChange['color']),
            Stat::make('Total Penjualan', $totalPenjualan)
                ->description($penjualanChange['description'])
                ->descriptionIcon($penjualanChange['icon'])
                ->color($penjualanChange['color']),
        ];
    }

    protected function calculateChange(string $model, int $currentCount): array
    {
        $lastWeekCount = $model::where('created_at', '>=', now()->subWeek())->count();
        $change = $currentCount - $lastWeekCount;
        if ($change > 0) {
            return [
                'description' => abs($change) . ' increase',
                'icon' => 'heroicon-m-arrow-trending-up',
                'color' => 'primary',
            ];
        } elseif ($change < 0) {
            return [
                'description' => abs($change) . ' decrease',
                'icon' => 'heroicon-m-arrow-trending-down',
                'color' => 'danger',
            ];
        }
        return [
            'description' => 'No change',
            'icon' => 'heroicon-m-minus-circle',
            'color' => 'gray',
        ];
    }
}
