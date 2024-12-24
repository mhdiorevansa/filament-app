<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Items';
    protected static ?string $slug = 'items';

    public static ?string $label = 'Item';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->placeholder("Masukan Nama Barang")
                    ->required()
                    ->maxLength(100),
                TextInput::make('kode_barang')
                    ->label('Kode Barang')
                    ->placeholder("Masukan Kode Barang")
                    ->required()
                    ->maxLength(100),
                TextInput::make('harga_barang')
                    ->label('Harga Barang')
                    ->placeholder("Masukan Harga Barang")
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')->searchable()->label('Nama Barang')->sortable(),
                TextColumn::make('kode_barang')->searchable()->label('Kode Barang')->copyable(),
                TextColumn::make('harga_barang')->searchable()->label('Harga Barang'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
