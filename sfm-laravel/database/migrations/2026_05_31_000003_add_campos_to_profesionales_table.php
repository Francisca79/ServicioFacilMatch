<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('descripcion');
            $table->string('ciudad', 100)->nullable()->after('telefono');
            $table->string('experiencia', 100)->nullable()->after('ciudad');
            $table->string('modalidad', 50)->nullable()->after('experiencia');
            $table->string('disponibilidad', 100)->nullable()->after('modalidad');
            $table->text('foto')->nullable()->after('disponibilidad');
        });
    }

    public function down(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->dropColumn([
                'telefono', 'ciudad', 'experiencia',
                'modalidad', 'disponibilidad', 'foto',
            ]);
        });
    }
};
