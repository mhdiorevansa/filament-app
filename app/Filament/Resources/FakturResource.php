<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FakturResource\Pages;
use App\Filament\Resources\FakturResource\RelationManagers;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Faktur;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FakturResource extends Resource
{
    protected static ?string $model = Faktur::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Manage Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('faktur')
                    ->label('Kode Faktur')
                    ->placeholder("Masukan Kode Faktur")
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                DatePicker::make('tanggal_faktur')
                    ->label('Tanggal Faktur')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                Select::make('customer_id')
                    ->reactive()
                    ->label('Customer')
                    ->relationship('customer', 'nama_customer')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->afterStateUpdated(function ($state, Set $set) {
                        $customer = Customer::find($state);
                        if ($customer) {
                            $set('kode_customer', $customer->kode_customer);
                        }
                    })
                    ->required(),
                TextInput::make('kode_customer')
                    ->label('Kode Customer')
                    ->placeholder("Masukan Kode Customer")
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                Repeater::make('detail')
                    ->relationship()
                    ->schema([
                        Select::make('barang_id')
                            ->reactive()
                            ->label('Barang')
                            ->relationship('barang', 'nama_barang')
                            ->afterStateUpdated(function ($state, Set $set) {
                                $barang = Barang::find($state);
                                if ($barang) {
                                    $set('nama_barang', $barang->nama_barang);
                                    $set('harga', $barang->harga_barang);
                                }
                            })
                            ->required(),
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder("Masukan Nama Barang")
                            ->required(),
                        TextInput::make('harga')
                            ->label('Harga')
                            ->disabled()
                            ->dehydrated()
                            ->prefix('Rp ')
                            ->placeholder("Masukan Harga")
                            ->numeric()
                            ->required(),
                        TextInput::make('qty')
                            ->reactive()
                            ->label('Qty')
                            ->placeholder("Masukan Qty")
                            ->numeric()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $harga = $get('harga');
                                $set('hasil_qty', intval($state * $harga));
                            })
                            ->required(),
                        TextInput::make('hasil_qty')
                            ->label('Total Qty')
                            ->disabled()
                            ->dehydrated()
                            ->prefix('Rp ')
                            ->placeholder("Masukan Total Qty")
                            ->numeric()
                            ->required(),
                        TextInput::make('diskon')
                            ->reactive()
                            ->label('Diskon')
                            ->placeholder("Masukan Diskon")
                            ->numeric()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $hasilQty = $get('hasil_qty');
                                $diskon = $hasilQty * $state / 100;
                                $hasil = $hasilQty - $diskon;
                                $set('sub_total', intval($hasil));
                            })
                            ->required(),
                        TextInput::make('sub_total')
                            ->label('Subtotal')
                            ->prefix('Rp ')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder("Masukan Subtotal")
                            ->numeric()
                            ->required(),
                    ])->columns(2)->columnSpan(2),
                TextInput::make('total')
                    ->label('Total Faktur')
                    // jika reactivenya berkaitan dengan repeater, gunakan di placeholder
                    ->placeholder(function (Get $get, Set $set) {
                        $detail = collect($get('detail'))->pluck('sub_total')->sum();
                        $set('total', \intval($detail));
                    })
                    ->prefix('Rp ')
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                TextInput::make('nominal_charge')
                    ->label('Nominal Charge')
                    ->placeholder("Masukan Nominal Charge")
                    ->reactive()
                    ->prefix('Rp ')
                    ->afterStateUpdated(function ($state, Set $set, Get $get){
                        $total = $get('total');
                        $charge = $total * $state / 100;
                        $hasil = $total + $charge;
                        $set('total_final', intval($hasil));
                        $set('charge', intval($charge));
                    })
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                TextInput::make('charge')
                    ->label('Charge')
                    ->prefix('Rp ')
                    ->placeholder("Masukan Charge")
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                TextInput::make('total_final')
                    ->label('Total Final')
                    ->placeholder("Masukan Total Final")
                    ->disabled()
                    ->dehydrated()
                    ->prefix('Rp ')
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->required(),
                Textarea::make('ket_faktur')
                    ->label('Keterangan Faktur')
                    ->placeholder("Masukan Keterangan Faktur")
                    ->columnSpan([
                        'default' => 2,
                        'md' => 2,
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('faktur')->label('Kode Faktur')->searchable(),
                TextColumn::make('tanggal_faktur')->label('Tanggal Faktur'),
                TextColumn::make('kode_customer')->label('Kode Customer'),
                TextColumn::make('customer.nama_customer')->label('Customer'),
                TextColumn::make('ket_faktur')->label('Keterangan Faktur'),
                TextColumn::make('total')->label('Total Faktur')->formatStateUsing(fn (Faktur $record): string => 'Rp ' . number_format($record->total, 0 ,'.')),
                TextColumn::make('nominal_charge')->label('Nominal Charge')->formatStateUsing(fn (Faktur $record): string => 'Rp ' . number_format($record->nominal_charge, 0 ,'.')),
                TextColumn::make('charge')->label('Charge')->formatStateUsing(fn (Faktur $record): string => 'Rp ' . number_format($record->charge, 0 ,'.')),
                TextColumn::make('total_final')->label('Total Final')->formatStateUsing(fn (Faktur $record): string => 'Rp ' . number_format($record->total_final, 0 ,'.')),
            ])
            ->emptyStateHeading('Tidak ada data faktur')
            ->emptyStateDescription('Silahkan tambah faktur terlebih dahulu')
            ->emptyStateIcon('heroicon-o-exclamation-circle')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->mutateRecordDataUsing(function (array $data): array {
                    return $data;
                })
                ->using(function (Faktur $record, array $data): Faktur {
                    $record->update($data);
                    $penjualan = Penjualan::where('faktur_id', $record->id)->first();
                    if ($penjualan) {
                        $penjualan->update([
                            'kode' => $record->faktur,
                            'tanggal' => $record->tanggal_faktur,
                            'jumlah' => $record->total,
                            'customer_id' => $record->customer_id,
                            'keterangan' => $record->ket_faktur,
                        ]);
                    }
                    return $record;
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFakturs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
