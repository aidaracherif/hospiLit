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
    Schema::table('personnels', function (Blueprint $table) {
        $table->string('password')->after('serviceId')->nullable(); 
        // 👆 ou pas nullable si tu veux forcer une valeur immédiate
    });
}

public function down()
{
    Schema::table('personnels', function (Blueprint $table) {
        $table->dropColumn('password');
    });
}

};
