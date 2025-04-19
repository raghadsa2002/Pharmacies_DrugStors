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
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('medicine_id_1')->nullable();
            $table->unsignedBigInteger('medicine_id_2')->nullable();
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->string('offer_type')->default('discount'); // أو 'free'
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            //
        });
    }
};
