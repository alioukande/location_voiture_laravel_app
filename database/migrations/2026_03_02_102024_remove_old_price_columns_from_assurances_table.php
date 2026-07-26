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
        Schema::table('assurances', function (Blueprint $table) {
         $table->dropColumn([ 'prix_tous_risques', 'prix_au_tiers']);

            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assurances', function (Blueprint $table) {
            $table->float('prix_tous_risques')->nullable();
            $table->float('prix_au_tiers')->nullable();
            //
        });
    }
};
