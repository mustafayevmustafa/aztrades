<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellingsTable extends Migration
{
    public function up()
    {
        Schema::create('sellings', function (Blueprint $table) {
            $table->id();
            $table->string("customer")->nullable();
            $table->string("type")->nullable();
            $table->morphs('sellingable');
            $table->float("weight", '8', '2')->nullable();
            $table->float("price", '8', '2')->nullable();
            $table->string("sac_name")->nullable();
            $table->integer("sac_count")->nullable();
            $table->integer("status")->nullable();
            $table->string("content")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sellings');
    }
}
