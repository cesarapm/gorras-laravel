<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $pluralModelLabel = 'Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                Forms\Components\Select::make('category')
                    ->label('Categoría')
                    ->options([
                        'clasica' => '🎩 Clásica',
                        'deportiva' => '⚡ Deportiva',
                        'vintage' => '🎨 Vintage'
                    ])
                    ->required()
                    ->native(false),

                FileUpload::make('image')
                    ->label('Imagen')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                    ->maxSize(1024)
                    ->disk('public')
                    ->directory('products')
                    ->nullable(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'clasica' => '🎩 Clásica',
                        'deportiva' => '⚡ Deportiva',
                        'vintage' => '🎨 Vintage',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'clasica' => 'gray',
                        'deportiva' => 'success',
                        'vintage' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn(int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activo'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoría')
                    ->options([
                        'clasica' => '🎩 Clásica',
                        'deportiva' => '⚡ Deportiva',
                        'vintage' => '🎨 Vintage'
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activo')
                    ->placeholder('Todos')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
