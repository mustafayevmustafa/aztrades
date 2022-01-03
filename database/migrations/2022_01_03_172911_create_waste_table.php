<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteTable extends Migration
{
    public function up()
    {
        Schema::create('waste', function (Blueprint $table) {
            $table->id();
            $table->morphs('wastable');
            $table->float('waste_weight')->nullable()->default(0.00);
            $table->string('waste_sac_name')->nullable();
            $table->integer('waste_sac_count')->nullable()->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waste');
    }
}
