<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('category_id'); // إضافة الحقل
            $table->foreign('company_id')->references('id')->on('pharmaceutical_companies')->onDelete('cascade'); // إضافة العلاقة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};