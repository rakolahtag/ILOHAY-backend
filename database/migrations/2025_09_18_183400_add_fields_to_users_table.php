<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'telephone')) {
                $table->string('telephone')->nullable()->after('prenom');
            }
            if (!Schema::hasColumn('users', 'genre')) {
                $table->enum('genre', ['masculin', 'feminin'])->nullable()->after('telephone');
            }
            if (!Schema::hasColumn('users', 'cin')) {
                $table->string('cin')->nullable()->after('genre');
            }
            if (!Schema::hasColumn('users', 'nationalite')) {
                $table->string('nationalite')->nullable()->after('cin');
            }
            if (!Schema::hasColumn('users', 'adresse')) {
                $table->string('adresse')->nullable()->after('nationalite');
            }
            if (!Schema::hasColumn('users', 'paysOrigine')) {
                $table->string('pays_origine')->nullable()->after('adresse');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'prenom')) {
                $table->dropColumn('prenom');
            }
            if (Schema::hasColumn('users', 'telephone')) {
                $table->dropColumn('telephone');
            }
            if (Schema::hasColumn('users', 'genre')) {
                $table->dropColumn('genre');
            }
            if (Schema::hasColumn('users', 'cin')) {
                $table->dropColumn('cin');
            }
            if (Schema::hasColumn('users', 'nationalite')) {
                $table->dropColumn('nationalite');
            }
            if (Schema::hasColumn('users', 'adresse')) {
                $table->dropColumn('adresse');
            }
            if (Schema::hasColumn('users', 'pays_origine')) {
                $table->dropColumn('pays_origine');
            }
        });
    }
};
