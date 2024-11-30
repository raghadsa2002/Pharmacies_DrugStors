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
        Schema::table('medicines', function (Blueprint $table) {
            $table->unsignedBigInteger('pharmaceutical_company_id')->nullable();
            $table->foreign('pharmaceutical_company_id')->references('id')->on('pharmaceutical_companies')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['pharmaceutical_company_id']);
            $table->dropColumn('pharmaceutical_company_id');
        });
    }
};
