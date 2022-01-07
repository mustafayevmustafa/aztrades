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
            $table->double('pocket', 8, 2)->nullable();
            $table->double('turnover', 8, 2)->nullable();
            $table->double('waiting_debts', 8, 2)->nullable();
            $table->double('expenses', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('closed_rates');
    }
}
