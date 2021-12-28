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
            $table->foreignId('city_id')->nullable()->index()->constrained()->onDelete('SET NULL');
            $table->string("from_whom");
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->integer("driver_cost")->nullable();
            $table->integer("supply_cost")->nullable();
            $table->integer("cost")->nullable();
            $table->integer("red_bag_number")->nullable();
            $table->integer("yellow_bag_number")->nullable();
            $table->integer("lom_bag_number")->nullable();
            $table->integer("total_weight")->nullable();
            $table->integer("is_trash")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('onions');
    }
}
