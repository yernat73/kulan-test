<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('status')
                ->default(0);

            $table->foreignId('departure_city_id')
                ->constrained('cities')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('destination_city_id')
                ->constrained('cities')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->date('date');

            $table->timestamps();
        });

        Schema::create('delivery_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('delivery_id')
                ->constrained('deliveries')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unique([
                'delivery_id',
                'user_id',
            ]);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_user');
        Schema::dropIfExists('deliveries');
    }
};
