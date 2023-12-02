<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 45);
            $table->string('address1', 255);
            $table->string('no_hp', 15);
            $table->string('province', 255);
            $table->string('city', 255);
            $table->string('state', 45)->nullable();
            $table->string('postcode', 45);
            $table->boolean('isMain')->default(1);
            $table->string('country_code', 3);
            $table->integer('city_id')->nullable();
            $table->integer('prov_id')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
