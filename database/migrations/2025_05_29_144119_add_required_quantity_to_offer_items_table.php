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
    {Schema::table('offer_items', function (Blueprint $table) {
    $table->integer('required_quantity')->default(1)->after('value');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('offer_items', function (Blueprint $table) {
    $table->dropColumn('required_quantity');
});
    }
};
