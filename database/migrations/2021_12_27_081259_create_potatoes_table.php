<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePotatoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('potatoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id")->nullable();
            $table->string("from_whom")->nullable();
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->integer("driver_cost")->nullable();
            $table->integer("custom_cost")->nullable();
            $table->integer("cost")->nullable();
            $table->integer("market_cost")->nullable();
            $table->integer("other_cost")->nullable();
            $table->integer("potato_price")->nullable();
            $table->integer("total_weight")->nullable();
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
        Schema::dropIfExists('potatoes');
    }
}
