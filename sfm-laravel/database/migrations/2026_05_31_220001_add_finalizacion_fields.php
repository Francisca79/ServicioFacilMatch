<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('bloqueado')->default(false)->after('tipo_usuario');
        });

        Schema::table('profesionales', function (Blueprint $table) {
            $table->string('zona', 80)->nullable()->after('ciudad');
        });

        Schema::table('servicios_adquiridos', function (Blueprint $table) {
            $table->decimal('monto_pagado', 10, 2)->nullable()->after('notas');
            $table->string('estado_pago', 20)->default('pendiente')->after('monto_pagado');
        });
    }

    public function down(): void
    {
        Schema::table('servicios_adquiridos', function (Blueprint $table) {
            $table->dropColumn(['monto_pagado', 'estado_pago']);
        });

        Schema::table('profesionales', function (Blueprint $table) {
            $table->dropColumn('zona');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bloqueado');
        });
    }
};
