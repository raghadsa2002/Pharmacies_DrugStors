<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['medicine_id_1', 'medicine_id_2', 'discount_price']);
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('medicine_id_1')->nullable();
            $table->unsignedBigInteger('medicine_id_2')->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
        });
    }
};