<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_type_id')->nullable()->index();
            $table->string('goods_type')->nullable()->index();
            $table->integer('goods_type_id')->nullable()->index();
            $table->double('expense', 8, 2)->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_returned')->default(false);
            $table->foreignId("debt_selling_id")->nullable()->index()->constrained('sellings');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
