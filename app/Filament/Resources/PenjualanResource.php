<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use App\Models\Penjualan;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationGroup = 'Manage Data';
    protected static ?string $navigationLabel = 'Penjualan';
    protected static ?string $slug = 'penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->sortable()
                    ->date('d F Y')
                    ->label('Tanggal'),
                TextColumn::make('kode')
                    ->sortable()
                    ->searchable()
                    ->label('Kode Faktur'),
                TextColumn::make('jumlah')
                    ->sortable()
                    ->searchable()
                    ->label('Jumlah')
                    ->formatStateUsing(fn (Penjualan $record): string => 'Rp ' . number_format($record->jumlah, 0 ,'.')),
                TextColumn::make('customer.nama_customer')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Customer'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(Penjualan $record): string => $record->status == false ? 'Belum Lunas' : 'Lunas')
                    ->color(fn(Penjualan $record): string => $record->status == false ? 'danger' : 'success'),
            ])
            ->emptyStateHeading('Tidak ada data penjualan')
            ->emptyStateDescription('Silahkan tambah faktur terlebih dahulu')
            ->emptyStateIcon('heroicon-o-exclamation-circle')
            ->emptyStateActions([
                Action::make('create')
                ->label('Buat Faktur')
                ->icon('heroicon-o-plus')
                ->url(route('filament.admin.resources.fakturs.index'))
                ->button()
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPenjualans::route('/'),
            // 'create' => Pages\CreatePenjualan::route('/create'),
            // 'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
