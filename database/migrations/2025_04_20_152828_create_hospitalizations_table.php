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
        Schema::create('hospitalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('serviceId')->constrained('services')->onDelete('cascade');
            $table->foreignId('litId')->constrained('lits')->onDelete('cascade');
            $table->date('dateAdmission')->nullable();
            $table->date('dateSortie')->nullable();
            $table->string('noteMedical')->nullable();
            $table->string('status')->default('Admis');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalizations');
    }
};
