<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveMedicineIdsFromOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['medicine_id_1', 'medicine_id_2']);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('medicine_id_1')->nullable();
            $table->unsignedBigInteger('medicine_id_2')->nullable();
        });
    }
}