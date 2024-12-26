<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Notifications\BarangCreatedNotification;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListBarangs extends ListRecords
{
    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->successNotification(
                Notification::make()
                    ->title('Barang berhasil ditambahkan wak')
                    ->icon('heroicon-o-check-circle')
                    ->success()
            ),
        ];
    }
}
