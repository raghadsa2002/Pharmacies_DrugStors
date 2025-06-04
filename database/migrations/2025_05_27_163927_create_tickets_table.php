<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // /
    //  * Run the migrations.
    //  */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
             
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('storehouse_id')->constrained()->onDelete('cascade');
            $table->foreignId('pharmacy_id')->constrained()->onDelete('cascade');            
            $table->text('message');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();


        });
    }

    // /
    //  * Reverse the migrations.
    //  */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};