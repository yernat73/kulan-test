<?php

namespace App\Services;

use App\Enums\DeliveryStatus;
use App\Models\Delivery;
use App\Models\DeliveryUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DeliveryService
{
    private function validateMerge(Collection $records): void
    {
        validator([
            'size' => $records->count(),
            'unique_departure_cities_count' => $records->pluck('departure_city_id', 'departure_city_id')->count(),
            'unique_destinations_cities_count' => $records->pluck('destination_city_id', 'destination_city_id')->count(),
            'unique_dates_count' => $records->pluck('date', 'date')->count(),
        ], [
            'size' => [
                'required',
                'integer',
                'min:2',
            ],
            'unique_departure_cities_count' => [
                'required',
                'integer',
                'size:1'
            ],
            'unique_destinations_cities_count' => [
                'required',
                'integer',
                'size:1'
            ],
            'unique_dates_count' => [
                'required',
                'integer',
                'size:1'
            ]
        ], [
            'size.min' => 'Выберите как минимум 2 записи',
            'unique_departure_cities_count.size' => 'Пункты отправления не совпадают',
            'unique_destinations_cities_count.size' => 'Пункты назначения не совпадают',
            'unique_dates_count.size' => 'Даты доставки не совпадают'
        ])->validate();
    }

    public function merge(Collection $records)
    {
        $this->validateMerge($records);

        DB::transaction(function () use ($records) {
            $deliveryIds = $records->pluck('id');

            $latestDelivery = Delivery::query()
                ->whereIn('id', $deliveryIds->toArray())
                ->latest()
                ->firstOrFail();

            $userIds = DeliveryUser::query()
                ->whereIn('delivery_id', $deliveryIds->toArray())
                ->pluck('user_id', 'user_id');

            $latestDelivery->users()->sync($userIds);
            $latestDelivery->update([
                'status' => DeliveryStatus::PENDING
            ]);

            Delivery::query()
                ->whereIn('id', $deliveryIds->reject($latestDelivery->id))
                ->delete();
        });


    }

}