<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOfferIdFromOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // أول نحذف الـ foreign key
            $table->dropForeign(['offer_id']);
            
            // بعدين نحذف العمود
            $table->dropColumn('offer_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_id')->nullable();

            // ونرجع القيد إذا احتجناه في الرجوع
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('set null');
        });
    }
};