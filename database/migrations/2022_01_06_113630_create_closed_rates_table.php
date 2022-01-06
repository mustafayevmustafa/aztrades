<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosedRatesTable extends Migration
{
    public function up()
    {
        Schema::create('closed_rates', function (Blueprint $table) {
            $table->id();
            $table->float('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('closed_rates');
    }
}
