<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;
}