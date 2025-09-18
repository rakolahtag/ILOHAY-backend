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
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->nullable()->after('name');
            $table->string('cin')->nullable()->after('prenom');
            $table->string('telephone')->nullable()->after('cin');
            $table->string('adresse')->nullable()->after('telephone');
            $table->string('pays_origine')->nullable()->after('adresse');
            $table->string('nationalite')->nullable()->after('pays_origine');
            $table->enum('genre', ['Homme', 'Femme', 'Autre'])->nullable()->after('nationalite');

            $table->enum('role', ['admin', 'formateur', 'participant', 'stagiaire'])
                  ->default('participant')
                  ->after('email'); // 🔒 sécurise : jamais admin par défaut
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'prenom',
                'cin',
                'telephone',
                'adresse',
                'pays_origine',
                'nationalite',
                'genre',
                'role',
            ]);
        });
    }
};
