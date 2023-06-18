<?php

namespace App\Filament\Pages;

use App\Filament\Resources\DeliveryResource;
use App\Models\Delivery;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected function form(Form $form): Form
    {
        return $form->schema([

            Select::make('departure_city_id')
                ->default(auth()->user()->city_id)
                ->relationship('departureCity', 'name')
                ->required(),

            Select::make('destination_city_id')
                ->relationship('destinationCity', 'name')
                ->required(),

            DatePicker::make('date')
                ->required()
                ->minDate(today()),
        ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use($data): Delivery{

            $delivery = parent::handleRecordCreation($data);
            /** @var Delivery $delivery*/

            $delivery->users()->attach(auth()->id());
            return $delivery;
        });
    }

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('page_CreateDelivery'), 403);
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('page_CreateDelivery');
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

}
