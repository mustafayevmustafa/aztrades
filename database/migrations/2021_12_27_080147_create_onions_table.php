<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onions', function (Blueprint $table) {
            $table->id();
            $table->string("from_whom")->nullable();
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->string("supply_cost")->nullable();
            $table->string("cost")->nullable();
            $table->string("type")->nullable();
            $table->integer("red_bag_number")->nullable();
            $table->integer("yellow_bag_number")->nullable();
            $table->integer("lom_bag_number")->nullable();
            $table->integer("total_weight")->nullable();
            $table->integer("price")->nullable();
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
        Schema::dropIfExists('onions');
    }
}
