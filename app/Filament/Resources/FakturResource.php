<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FakturResource\Pages;
use App\Filament\Resources\FakturResource\RelationManagers;
use App\Models\Faktur;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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
                    ->required(),
                DatePicker::make('tanggal_faktur')
                    ->label('Tanggal Faktur')
                    ->required(),
                TextInput::make('kode_customer')
                    ->label('Kode Customer')
                    ->placeholder("Masukan Kode Customer")
                    ->required(),
                Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'nama_customer')
                    ->required(),
                TextInput::make('ket_faktur')
                    ->label('Keterangan Faktur')
                    ->placeholder("Masukan Keterangan Faktur")
                    ->required(),
                TextInput::make('total')
                    ->label('Total Faktur')
                    ->placeholder("Masukan Total Faktur")
                    ->required(),
                TextInput::make('nominal_charge')
                    ->label('Nominal Charge')
                    ->placeholder("Masukan Nominal Charge")
                    ->required(),
                TextInput::make('charge')
                    ->label('Charge')
                    ->placeholder("Masukan Charge")
                    ->required(),
                TextInput::make('total_final')
                    ->label('Total Final')
                    ->placeholder("Masukan Total Final")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('faktur')->label('Kode Faktur'),
                TextColumn::make('tanggal_faktur')->label('Tanggal Faktur'),
                TextColumn::make('kode_customer')->label('Kode Customer'),
                TextColumn::make('customer_id')->label('Customer'),
                TextColumn::make('ket_faktur')->label('Keterangan Faktur'),
                TextColumn::make('total')->label('Total Faktur'),
                TextColumn::make('nominal_charge')->label('Nominal Charge'),
                TextColumn::make('charge')->label('Charge'),
                TextColumn::make('total_final')->label('Total Final'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // 'create' => Pages\CreateFaktur::route('/create'),
            // 'edit' => Pages\EditFaktur::route('/{record}/edit'),
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
