<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->decimal('calificacion', 3, 2)->default(0)->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('calificacion');
        });
    }
};
