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
        Schema::create('store_houses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique(); 
            $table->string('phone');
            $table->tinyInteger('status');
            $table->string('city');
            $table->string('address');
            $table->foreignId('created_by')->references('id')->on('admins');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_houses');
    }
};
