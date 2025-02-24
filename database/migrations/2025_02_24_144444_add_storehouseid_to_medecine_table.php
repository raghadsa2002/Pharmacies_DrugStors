<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('store_houses_id'); // إضافة الحقل
            $table->foreign('store_houses_id')->references('id')->on('store_houses')->onDelete('cascade'); // إضافة العلاقة
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            //
            $table->dropForeign(['store_houses_id']);
            $table->dropColumn('store_houses_id');
        });
    }
};
