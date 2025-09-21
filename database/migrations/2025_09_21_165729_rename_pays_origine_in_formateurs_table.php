<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('formateurs', function (Blueprint $table) {
            if (Schema::hasColumn('formateurs', 'paysOrigine')) {
                $table->renameColumn('paysOrigine', 'pays_origine');
            }
        });
    }

    public function down(): void
    {
        Schema::table('formateurs', function (Blueprint $table) {
            if (Schema::hasColumn('formateurs', 'pays_origine')) {
                $table->renameColumn('pays_origine', 'paysOrigine');
            }
        });
    }
};
