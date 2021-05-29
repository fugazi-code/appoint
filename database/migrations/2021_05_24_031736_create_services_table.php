<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->text('desc')->nullable();
            $table->float('cost')->nullable();
            $table->integer('time')->nullable();
            $table->integer('buffer')->nullable();
            $table->string('private_service', 200)->nullable();
            $table->string('color', 200)->nullable();
            $table->string('video_meeting', 200)->nullable();
            $table->string('created_by', 200)->nullable();
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
        Schema::dropIfExists('services');
    }
}
