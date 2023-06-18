<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use App\Filament\Resources\DeliveryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ListDeliveries extends ListRecords
{
    protected static string $resource = DeliveryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->when(
                !auth()->user()->hasRole('super_admin') && auth()->user()->hasRole('user'),
                fn(Builder $query) => $query
                    ->whereHas('users', fn(Builder $belongsToMany) => $belongsToMany->where('user_id', auth()->id()))
            );
    }
}
