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
            $table->foreignId("country_id")->index()->nullable()->constrained()->onDelete('SET NULL');
            $table->string("from_whom");
            $table->string("party")->nullable();
            $table->string("car_number")->nullable();
            $table->string("driver_name")->nullable();
            $table->float("driver_cost", '8', '2')->nullable();
            $table->float("custom_cost", '8', '2')->nullable();
            $table->float("cost", '8', '2')->nullable();
            $table->float("market_cost", '8', '2')->nullable();
            $table->float("other_cost", '8', '2')->nullable();
            $table->integer("total_weight")->nullable();
            $table->integer("is_trash")->nullable();
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
