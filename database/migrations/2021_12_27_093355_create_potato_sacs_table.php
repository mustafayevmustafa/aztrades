<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePotatoSacsTable extends Migration
{
    public function up()
    {
        Schema::create('potato_sacs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("potato_id")->nullable()->index()->constrained();
            $table->string("name");
            $table->integer("sac_count")->nullable();
            $table->integer("sac_weight")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('potato_sacs');
    }
}
