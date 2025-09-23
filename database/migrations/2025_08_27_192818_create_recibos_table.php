<?php

use App\Models\Asociado;

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
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->integer('matricula')->nullable();
            $table->integer('importe');


            // Relación con la tabla asociados

            $table->foreign('matricula')
                  ->references('matricula')
                  ->on('asociados')
                  ->nullOnDelete(); // esto permite eliminar el asociado

            $table->string('aniomes', 6); 
            $table->integer('foliomes');  
            $table->integer('folio');

            $table->boolean('asistio')->default(true);
            $table->integer('matricula_a')->nullable();  // se crea esta por si se borra un asociado que se conserve la matricula en el recibio
            $table->boolean('cancelado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::table('recibos', function (Blueprint $table) {
            $table->dropForeign(['matricula']); // elimina la restricción
        });

        Schema::dropIfExists('recibos');
    }
};
