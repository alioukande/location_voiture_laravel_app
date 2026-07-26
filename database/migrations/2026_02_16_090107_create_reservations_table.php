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
        Schema::create('reservations', function (Blueprint $table) {
             $table->id();
             $table->foreignId('voiture_id')->constrained('voitures')->onDelete('cascade');

            $table->string('name');
            $table->string('email');

            $table->date('date_reservation');
             $table->date('start_time')->change();
            $table->date('end_time')->change();

            $table->decimal('total_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
