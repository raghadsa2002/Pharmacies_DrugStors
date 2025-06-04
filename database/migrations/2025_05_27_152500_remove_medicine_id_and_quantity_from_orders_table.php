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
        $table->dropForeign(['medicine_id']); // لو فيه foreign key لازم تسقطه أول
        $table->dropColumn(['medicine_id', 'quantity']);
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->unsignedBigInteger('medicine_id');
        $table->integer('quantity');
        $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
    });

    }
};
