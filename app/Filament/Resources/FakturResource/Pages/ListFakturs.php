<?php

namespace App\Filament\Resources\FakturResource\Pages;

use App\Filament\Resources\FakturResource;
use App\Models\Faktur;
use App\Models\Penjualan;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListFakturs extends ListRecords
{
    protected static string $resource = FakturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data): Model {
                    $faktur = Faktur::create($data);
                    Penjualan::create([
                        'kode' => $faktur->faktur,
                        'tanggal' => $faktur->tanggal_faktur,
                        'jumlah' => $faktur->total,
                        'customer_id' => $faktur->customer_id,
                        'faktur_id' => $faktur->id,
                        'keterangan' => $faktur->keterangan,
                        'status' => 0,
                    ]);
                    return $faktur;
                }),
        ];
    }
}
