<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->decimal('precio_min', 10, 2)->nullable()->after('precio_estimado');
            $table->decimal('precio_max', 10, 2)->nullable()->after('precio_min');
        });

        Schema::create('servicios_adquiridos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('profesional_id')->constrained('profesionales')->cascadeOnDelete();
            $table->boolean('verificado')->default(false);
            $table->foreignId('verificado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'profesional_id']);
        });

        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remitente_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('destinatario_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('profesional_id')->nullable()->constrained('profesionales')->nullOnDelete();
            $table->string('asunto', 200);
            $table->text('cuerpo');
            $table->string('tipo', 30)->default('normal');
            $table->boolean('leido')->default(false);
            $table->timestamps();
        });

        Schema::create('resenas_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profesional_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('calificacion');
            $table->text('comentario');
            $table->timestamps();
            $table->unique(['profesional_user_id', 'cliente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas_clientes');
        Schema::dropIfExists('mensajes');
        Schema::dropIfExists('servicios_adquiridos');

        Schema::table('profesionales', function (Blueprint $table) {
            $table->dropColumn(['precio_min', 'precio_max']);
        });
    }
};
