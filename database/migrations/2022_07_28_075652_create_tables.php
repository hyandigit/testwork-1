<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
        });
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->integer('temperature');
            $table->bigInteger('location_id', false, true);
            $table->foreign('location')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 12);
            $table->primary('id');
            $table->timestamps();
            $table->integer('size');
            $table->integer('temperature');
            $table->integer('date_start');
            $table->integer('date_end');
            $table->bigInteger('block_id', false, true);
            $table->foreign('block')->references('id')->on('blocks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('orders');
    }
}
