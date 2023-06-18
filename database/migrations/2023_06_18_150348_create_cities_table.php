<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('city_id')
                ->nullable()
                ->constrained('cities')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
        });

        Schema::dropIfExists('cities');
    }
};
