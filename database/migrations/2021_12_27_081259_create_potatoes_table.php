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
            $table->integer("country_id")->nullable()->index();
            $table->string("from_whom")->nullable();
            $table->string("party")->nullable();
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->float("driver_cost")->nullable();
            $table->float("custom_cost")->nullable();
            $table->float("cost")->nullable();
            $table->float("market_cost")->nullable();
            $table->float("other_cost")->nullable();
            $table->integer("total_weight")->nullable()->default(0);
            $table->boolean("status")->default(true);
            $table->timestamps();
            $table->softDeletes();
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
