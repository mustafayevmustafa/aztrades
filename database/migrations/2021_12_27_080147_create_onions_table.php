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
            $table->string("from_whom")->nullable();
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->double("driver_cost", 8, 2)->nullable();
            $table->double("supply_cost", 8, 2)->nullable();
            $table->double("cost", 8, 2)->nullable();
            $table->integer("red_bag_number")->nullable()->default(0);
            $table->integer("yellow_bag_number")->nullable()->default(0);
            $table->integer("lom_bag_number")->nullable()->default(0);
            $table->string('old_bag_numbers')->nullable();
            $table->float("total_weight")->nullable()->default(0);
            $table->float("old_total_weight")->nullable()->default(0);
            $table->boolean("status")->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('onions');
    }
}
