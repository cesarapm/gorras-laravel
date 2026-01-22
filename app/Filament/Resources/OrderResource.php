<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Pedidos';

    protected static ?string $pluralModelLabel = 'Pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Cliente')
                    ->schema([
                        Forms\Components\TextInput::make('customer_first_name')
                            ->label('👤 Nombre')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('customer_last_name')
                            ->label('Apellido')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('customer_email')
                            ->label('📧 Email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('customer_phone')
                            ->label('📱 Teléfono')
                            ->tel()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Dirección de Envío')
                    ->schema([
                        Forms\Components\Textarea::make('shipping_address')
                            ->label('📍 Dirección')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('shipping_city')
                            ->label('Ciudad')
                            ->required(),

                        Forms\Components\TextInput::make('shipping_state')
                            ->label('Estado')
                            ->required(),

                        Forms\Components\TextInput::make('shipping_zip_code')
                            ->label('Código Postal')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Detalles del Pedido')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('# Orden')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('💰 Subtotal')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01),

                        Forms\Components\TextInput::make('shipping_cost')
                            ->label('📦 Envío')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01),

                        Forms\Components\TextInput::make('tax')
                            ->label('Impuestos')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->default(0),

                        Forms\Components\TextInput::make('total')
                            ->label('💵 Total')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01),

                        Forms\Components\Select::make('payment_method')
                            ->label('💳 Método de Pago')
                            ->options([
                                'card' => '💳 Tarjeta',
                                'cash' => '💵 Efectivo',
                                'transfer' => '🏦 Transferencia',
                                'mobile' => '📱 Pago móvil'
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('status')
                            ->label('📊 Estado')
                            ->options([
                                'pending' => '⏳ Pendiente',
                                'processing' => '🔄 Procesando',
                                'shipped' => '📦 Enviado',
                                'delivered' => '✅ Entregado',
                                'cancelled' => '❌ Cancelado',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('notes')
                            ->label('📝 Notas')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('# Orden')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('customer_full_name')
                    ->label('Cliente')
                    ->getStateUsing(fn (Order $record) => $record->customer_full_name)
                    ->searchable(['customer_first_name', 'customer_last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('MXN', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pago')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'card' => '💳 Tarjeta',
                        'cash' => '💵 Efectivo',
                        'transfer' => '🏦 Transferencia',
                        'mobile' => '📱 Pago móvil',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'card' => 'info',
                        'cash' => 'success',
                        'transfer' => 'warning',
                        'mobile' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => '⏳ Pendiente',
                        'processing' => '🔄 Procesando',
                        'shipped' => '📦 Enviado',
                        'delivered' => '✅ Entregado',
                        'cancelled' => '❌ Cancelado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => '⏳ Pendiente',
                        'processing' => '🔄 Procesando',
                        'shipped' => '📦 Enviado',
                        'delivered' => '✅ Entregado',
                        'cancelled' => '❌ Cancelado',
                    ]),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Método de Pago')
                    ->options([
                        'card' => '💳 Tarjeta',
                        'cash' => '💵 Efectivo',
                        'transfer' => '🏦 Transferencia',
                        'mobile' => '📱 Pago móvil'
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
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
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
