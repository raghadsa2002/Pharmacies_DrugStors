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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('pharmacy_id')->nullable();
            $table->unsignedBigInteger('storehouse_id')->nullable();
            $table->text('message');
            $table->timestamps();
    
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            // إذا بدك تضيف علاقات مع جدول الصيادلة والمستودعات:
            // $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('set null');
            // $table->foreign('storehouse_id')->references('id')->on('storehouses')->onDelete('set null');
        });
    }
};
