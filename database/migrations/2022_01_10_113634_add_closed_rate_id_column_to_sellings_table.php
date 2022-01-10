<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClosedRateIdColumnToSellingsTable extends Migration
{
    public function up()
    {
        Schema::table('sellings', function (Blueprint $table) {
            $table->foreignId('closed_rate_id')->after('content')->nullable()->index()->constrained();
        });
    }

    public function down()
    {
        Schema::table('sellings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('closed_rate_id');
        });
    }
}
