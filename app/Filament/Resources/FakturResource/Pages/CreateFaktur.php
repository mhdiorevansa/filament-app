<?php

namespace App\Filament\Resources\FakturResource\Pages;

use App\Filament\Resources\FakturResource;
use App\Models\Penjualan;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFaktur extends CreateRecord
{
    protected static string $resource = FakturResource::class;
}
