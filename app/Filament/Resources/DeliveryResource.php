<?php

namespace App\Filament\Resources;

use App\Enums\DeliveryStatus;
use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use App\Services\DeliveryService;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Collection;

class DeliveryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-s-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options(DeliveryStatus::asSelectArray())
                    ->default(DeliveryStatus::PENDING)
                    ->required()
                    ->columnSpanFull()
                    ->hiddenOn('create'),

                Forms\Components\Select::make('departure_city_id')
                    ->relationship('departureCity', 'name')
                    ->default(auth()->user()->city_id)
                    ->required(),

                Forms\Components\Select::make('destination_city_id')
                    ->relationship('destinationCity', 'name')
                    ->required(),

                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->minDate(today()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->options([
                        'heroicon-o-x-circle' => DeliveryStatus::REJECTED,
                        'heroicon-o-check-circle' => DeliveryStatus::APPROVED,
                        'heroicon-o-plus-circle' => DeliveryStatus::PENDING,
                    ])
                    ->colors([
                        'secondary' => DeliveryStatus::PENDING,
                        'danger' => DeliveryStatus::REJECTED,
                        'success' => DeliveryStatus::APPROVED,
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('departureCity.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('destinationCity.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('users_count')->counts('users')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(DeliveryStatus::asSelectArray())
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('merge')
                    ->action(function (Collection $records, Pages\ListDeliveries $livewire) {
                        try {
                            app(DeliveryService::class)->merge($records);
                        } catch (\Throwable $exception) {
                            $livewire->notify('danger', $exception->getMessage());
                        }
                    })
                    ->icon('heroicon-o-paper-clip')
                    ->color('primary')
                    ->visible(fn (): bool => auth()->user()->can('merge_delivery')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'merge',
        ];
    }
}
