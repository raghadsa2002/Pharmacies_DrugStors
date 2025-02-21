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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pharmacy_id'); 
        $table->unsignedBigInteger('medicine_id'); 
        $table->integer('quantity');              
        $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); 
        $table->timestamps();

        // علاقات
        $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade'); 
        $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
