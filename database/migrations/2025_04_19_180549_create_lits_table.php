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
        Schema::create('lits', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->foreignId('serviceId')->constrained('services')->onDelete('cascade');
            $table->string('etage');
            $table->string('status');
            $table->date('dateOccupation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lits');
    }
};
