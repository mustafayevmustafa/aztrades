<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTypesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('key')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses_types');
    }
}
