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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');
        $table->unsignedBigInteger('pharmacy_id');
        $table->tinyInteger('rating'); // بين 1 و 5
        $table->text('comment')->nullable(); // ملاحظة
        $table->timestamps();

        // علاقات
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
