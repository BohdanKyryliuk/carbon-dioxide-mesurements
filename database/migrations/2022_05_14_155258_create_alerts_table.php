<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->smallInteger('mesurement1');
            $table->smallInteger('mesurement2');
            $table->smallInteger('mesurement3');
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
        Schema::dropIfExists('alerts');
    }
};
