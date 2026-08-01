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
       if (!Schema::hasColumn('reservations', 'statut')) {

        Schema::table('reservations', function (Blueprint $table) {

            $table->enum('statut', [
                'en attente',
                'confirmee',
                'annulee',
                'terminee'
            ])->default('en attente')->after('end_time');

        });

    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'statut')) {
                $table->dropColumn('statut');
            }
        });
    }
};
