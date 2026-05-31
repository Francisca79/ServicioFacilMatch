<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('email');
            $table->string('ciudad', 100)->nullable()->after('telefono');
            $table->enum('tipo_usuario', ['cliente', 'profesional', 'admin'])->default('cliente')->after('ciudad');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'ciudad', 'tipo_usuario']);
        });
    }
};
