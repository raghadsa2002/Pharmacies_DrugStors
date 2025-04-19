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
    Schema::table('orders', function (Blueprint $table) {
        $table->unsignedBigInteger('offer_id')->nullable()->after('pharmacy_id');

        $table->foreign('offer_id')->references('id')->on('offers')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropForeign(['offer_id']);
        $table->dropColumn('offer_id');
    });
}
};
