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
            $table->decimal('prix_tous_risques', 10, 2)->default(0);
             $table->decimal('prix_au_tiers', 10, 2)->default(0);
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assurances', function (Blueprint $table) {
         $table->dropColumn(['prix_tous_risques', 'prix_au_tiers']);

            //
        });
    }
};
