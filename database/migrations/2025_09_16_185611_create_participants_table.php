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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->string('genre');
            $table->string('cin');
            $table->string('nationalite');
            $table->string('adresse');
            $table->string('paysOrigine');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
