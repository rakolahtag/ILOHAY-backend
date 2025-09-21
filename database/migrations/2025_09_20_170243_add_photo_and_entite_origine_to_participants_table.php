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
    Schema::table('participants', function (Blueprint $table) {
        $table->string('photo')->nullable()->after('id');
        $table->string('entiteOrigine')->nullable()->after('paysOrigine');
    });
}

public function down(): void
{
    Schema::table('participants', function (Blueprint $table) {
        $table->dropColumn(['photo', 'entiteOrigine']);
    });
}
};
