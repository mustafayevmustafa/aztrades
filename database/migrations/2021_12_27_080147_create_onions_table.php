<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnionsTable extends Migration
{
    public function up()
    {
        Schema::create('onions', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id')->nullable()->index();
            $table->string("from_whom");
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->float("driver_cost")->nullable();
            $table->float("supply_cost")->nullable();
            $table->float("cost")->nullable();
            $table->integer("red_bag_number")->nullable();
            $table->integer("yellow_bag_number")->nullable();
            $table->integer("lom_bag_number")->nullable();
            $table->float("total_weight")->nullable();
            $table->boolean("is_trash")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('onions');
    }
}
