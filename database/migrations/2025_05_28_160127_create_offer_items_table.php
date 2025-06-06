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
        Schema::create('offer_items', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('offer_id');
    $table->unsignedBigInteger('medicine_id');
    $table->enum('type', ['discount', 'free'])->default('discount');
    $table->decimal('value', 8, 2)->nullable(); // قيمة الخصم إذا كان نوع العرض "خصم"
    $table->timestamps();

    $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
    $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
});}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_items');
    }
};
