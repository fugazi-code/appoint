<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('website', 200)->nullable();
            $table->string('phone', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->text('address')->nullable();
            $table->text('photo_url')->nullable();
            $table->string('lat', 200)->nullable();
            $table->string('long', 200)->nullable();
            $table->text('booking_policy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
