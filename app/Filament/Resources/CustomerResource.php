<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manage Data';
    protected static ?string $navigationLabel = 'Customer';
    protected static ?string $slug = 'customer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_customer')
                    ->label('Nama Customer')
                    ->placeholder("Masukan Nama Customer")
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->maxLength(100),
                TextInput::make('kode_customer')
                    ->label('Kode Customer')
                    ->placeholder("Masukan Kode Customer")
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->maxLength(100),
                TextInput::make('alamat_customer')
                    ->label('Alamat Customer')
                    ->placeholder("Masukan Alamat Customer")
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->maxLength(100),
                TextInput::make('telepon_customer')
                    ->label('Telepon Customer')
                    ->placeholder("Masukan Telepon Customer")
                    ->tel()
                    ->numeric()
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'md' => 1,
                    ])
                    ->maxLength(100),
                FileUpload::make('image_customer')
                    ->label('Foto Customer')
                    ->image()
                    ->directory('customer_images')
                    ->columnSpan([
                        'default' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_customer')
                    ->searchable()
                    ->label('Nama Customer')
                    ->sortable(),
                TextColumn::make('kode_customer')
                    ->searchable()
                    ->label('Kode Customer')
                    ->copyable(),
                TextColumn::make('alamat_customer')
                    ->searchable()
                    ->label('Alamat Customer'),
                TextColumn::make('telepon_customer')
                    ->searchable()
                    ->label('Telepon Customer'),
                ImageColumn::make('image_customer')
                    ->disk('public')
                    ->label('Foto Customer'),
            ])
            ->emptyStateHeading('Tidak ada data customer')
            ->emptyStateDescription('Silahkan tambah customer terlebih dahulu')
            ->emptyStateIcon('heroicon-o-exclamation-circle')
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
            // 'create' => Pages\CreateCustomer::route('/create'),
            // 'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
