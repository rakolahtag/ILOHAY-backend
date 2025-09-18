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
    Schema::table('stagiaires', function (Blueprint $table) {
        $table->string('nationalite')->nullable()->after('cin');
        $table->string('adresse')->nullable()->after('nationalite');
        $table->string('pays_origine')->nullable()->after('adresse');
        $table->string('photo')->nullable()->after('pays_origine'); // stocke le chemin de l'image
        $table->string('niveau_en_classe')->nullable()->after('photo');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropColumn(['nationalite', 'adresse', 'pays_origine', 'photo', 'niveau_en_classe']);
        });
    }
};
