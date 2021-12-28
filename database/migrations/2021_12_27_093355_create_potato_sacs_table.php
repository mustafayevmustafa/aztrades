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
            $table->string("name")->unique();
            $table->integer("sac_count")->default(0);
            $table->float("sac_weight", '8', '2')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('potato_sacs');
    }
}
