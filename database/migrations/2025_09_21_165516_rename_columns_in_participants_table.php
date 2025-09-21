<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            if (Schema::hasColumn('participants', 'paysOrigine')) {
                $table->renameColumn('paysOrigine', 'pays_origine');
            }

            if (Schema::hasColumn('participants', 'entiteOrigine')) {
                $table->renameColumn('entiteOrigine', 'entite_origine');
            }
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            if (Schema::hasColumn('participants', 'pays_origine')) {
                $table->renameColumn('pays_origine', 'paysOrigine');
            }

            if (Schema::hasColumn('participants', 'entite_origine')) {
                $table->renameColumn('entite_origine', 'entiteOrigine');
            }
        });
    }
};
