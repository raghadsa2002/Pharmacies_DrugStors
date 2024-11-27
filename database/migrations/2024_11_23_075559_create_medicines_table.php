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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2); 
            $table->unsignedBigInteger('category_id'); 
            $table->text('description')->nullable();
            $table->string('manufacturer')->nullable(); //الشركة المصنعة 
            $table->string('status')->default('available'); 
            $table->integer('stock')->default(0); //الكمية
            $table->string('image')->nullable(); 
            $table->timestamps();
    
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};