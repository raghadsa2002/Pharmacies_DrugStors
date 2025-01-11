<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToStoreHousesTable extends Migration
{
    public function up()
    {
        Schema::table('store_houses', function (Blueprint $table) {
            $table->string('password')->nullable(); // إضافة عمود كلمة السر
        });
    }

    public function down()
    {
        Schema::table('store_houses', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
}