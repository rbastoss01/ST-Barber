<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peluqueros', function (Blueprint $table) {
            $table->boolean('ausente')->default(false)->after('activo');
        });
    }

    public function down(): void
    {
        Schema::table('peluqueros', function (Blueprint $table) {
            $table->dropColumn('ausente');
        });
    }
};
