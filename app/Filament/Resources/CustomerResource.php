<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manage Customers';
    protected static ?string $navigationLabel = 'Customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_customer')
                    ->label('Nama Customer')
                    ->placeholder("Masukan Nama Customer")
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('kode_customer')
                    ->label('Kode Customer')
                    ->placeholder("Masukan Kode Customer")
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('alamat_customer')
                    ->label('Alamat Customer')
                    ->placeholder("Masukan Alamat Customer")
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('telepon_customer')
                    ->label('Telepon Customer')
                    ->placeholder("Masukan Telepon Customer")
                    ->tel()
                    ->numeric()
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_customer')
                    ->searchable()
                    ->label('Nama Customer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_customer')
                    ->searchable()
                    ->label('Kode Customer')
                    ->copyable(),
                Tables\Columns\TextColumn::make('alamat_customer')
                    ->searchable()
                    ->label('Alamat Customer'),
                Tables\Columns\TextColumn::make('telepon_customer')
                    ->searchable()
                    ->label('Telepon Customer'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
