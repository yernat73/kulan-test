<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use App\Filament\Resources\DeliveryResource;
use App\Models\Delivery;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data): Delivery {

            $delivery = parent::handleRecordCreation($data);
            /** @var Delivery $delivery */
            if (auth()->user()->hasRole('user')) {
                $delivery->users()->attach(auth()->id());
            }

            return $delivery;
        });
    }
}
