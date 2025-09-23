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
        Schema::create('generals', function (Blueprint $table) {
            $table->id();

            $table->string('asociacion', 100)->default('Asociación');
            $table->string('presidente', 50);
            $table->integer('cuota')->default(100);
            $table->string('aniomes', 6);
            $table->integer('foliomes')->defalt(0);
            $table->integer('folio')->defalt(0);
            $table->string('timezone')->default('America/Mazatlan');
            $table->timestamps();
        });

        // Insertar un registro inicial
        DB::table('generals')->insert([
            'asociacion' => 'Asociación de Jubilados y Pensionados Nuevos Horizontes Sección Sinaloa',
            'presidente' => 'A',
            'cuota' => 100,
            'aniomes' => date("Ym"),
            'foliomes' => 0,
            'folio' => 0,
            'timezone' => 'America/Mazatlan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generals');
    }
};
