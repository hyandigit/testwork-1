<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

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
            $table->string('options', 10)->nullable();
        });
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->integer('temperature')->nullable();
            $table->float('size')->default(0);
            $table->bigInteger('location_id', false, true);
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('options', 10)->nullable();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 12);
            $table->primary('id');
            $table->timestamps();
            $table->float('size');
            $table->integer('temperature')->nullable();
            $table->integer('date_start');
            $table->integer('date_end');
            $table->integer('status')->nullable();
        });
        Schema::create('order_blocks', function (Blueprint $table) {
            $table->string('order_id', 12);
            $table->bigInteger('block_id', false, true);
            $table->float('size')->nullable();
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::unprepared('
            DROP TRIGGER IF EXISTS `laravel`.`orders_AFTER_INSERT`;

            DELIMITER $$
            CREATE DEFINER = CURRENT_USER TRIGGER `laravel`.`orders_AFTER_INSERT` AFTER INSERT ON `order_blocks` FOR EACH ROW
            BEGIN
            UPDATE `blocks` set `size` = new.size where `id` = new.block_id;
            END$$
            DELIMITER ;
        ');
        DB::unprepared('
            DROP TRIGGER IF EXISTS `laravel`.`orders_AFTER_INSERT`;

            DELIMITER $$
            CREATE DEFINER = CURRENT_USER TRIGGER `order_blocks_AFTER_UPDATE` AFTER UPDATE ON `order_blocks` FOR EACH ROW
            BEGIN
            UPDATE `blocks` set `size` = new.size where `id` = new.block_id;
            END$$
            DELIMITER ;
        ');
        DB::unprepared('
            DROP TRIGGER IF EXISTS `laravel`.`orders_AFTER_INSERT`;

            DELIMITER $$
            CREATE DEFINER = CURRENT_USER TRIGGER `order_blocks_AFTER_DELETE` AFTER DELETE ON `order_blocks` FOR EACH ROW
            BEGIN
            UPDATE `blocks` set `size` = `size` - old.size where `id` = old.block_id;
            END$$
            DELIMITER ;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('order_blocks');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('locations');

        DB::unprepared('DROP TRIGGER IF EXISTS `order_blocks_AFTER_INSERT`');
        DB::unprepared('DROP TRIGGER IF EXISTS `order_blocks_AFTER_UPDATE`');
        DB::unprepared('DROP TRIGGER IF EXISTS `order_blocks_AFTER_DELETE`');
    }
}
