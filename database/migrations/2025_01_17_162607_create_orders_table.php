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
        $table->foreignId('pharmacy_id')->constrained()->onDelete('cascade'); 
        $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
        $table->foreignId('store_houses_id')->constrained()->onDelete('cascade');
        
        $table->integer('quantity');              
        $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); 
        // علاقات
        $table->timestamps();
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
