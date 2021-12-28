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
            $table->string("from_sell")->nullable();
            $table->morphs('sellingable');
            $table->integer("weight")->nullable();
            $table->integer("price")->nullable();
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
