<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicios_adquiridos', function (Blueprint $table) {
            $table->string('estado_solicitud', 20)->default('pendiente')->after('verificado');
            $table->foreignId('mensaje_id')->nullable()->after('estado_solicitud')->constrained('mensajes')->nullOnDelete();
            $table->boolean('cliente_confirmo_pago')->default(false)->after('estado_pago');
            $table->boolean('profesional_confirmo_cobro')->default(false)->after('cliente_confirmo_pago');
            $table->string('metodo_pago', 30)->nullable()->after('profesional_confirmo_cobro');
            $table->timestamp('fecha_cobro')->nullable()->after('metodo_pago');
        });
    }

    public function down(): void
    {
        Schema::table('servicios_adquiridos', function (Blueprint $table) {
            $table->dropForeign(['mensaje_id']);
            $table->dropColumn([
                'estado_solicitud',
                'mensaje_id',
                'cliente_confirmo_pago',
                'profesional_confirmo_cobro',
                'metodo_pago',
                'fecha_cobro',
            ]);
        });
    }
};
