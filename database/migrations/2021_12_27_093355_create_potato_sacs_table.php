<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePotatoSacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('potato_sacs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("potato_id");
            $table->string("name");
            $table->integer("sac_count")->nullable();
            $table->integer("sac_weight")->nullable();
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
        Schema::dropIfExists('potato_sacs');
    }
}
