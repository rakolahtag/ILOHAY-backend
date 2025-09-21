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
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->renameColumn('pays_origine', 'paysOrigine');
        });
    }

    public function down(): void
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->renameColumn('paysOrigine', 'pays_origine');
        });
    }
};
