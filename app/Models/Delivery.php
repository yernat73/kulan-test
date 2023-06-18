<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model
{
    protected $fillable = [
        'status',
        'departure_city_id',
        'destination_city_id',
        'date',
    ];

    public function departureCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(DeliveryUser::class)
            ->withTimestamps();
    }
}