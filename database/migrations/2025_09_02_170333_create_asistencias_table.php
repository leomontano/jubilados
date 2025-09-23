<?php

use App\Models\Asociado;
use App\Models\Asistencia;
use App\Models\Recibo;

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
        Schema::create('asistencias', function (Blueprint $table) {
       
          //  $table->foreignIdFor(Asociado::class)->constrained()->cascadeOnDelete();
            
            $table->id();
            $table->integer('matricula');
            $table->date('fecha');
            
        // Relación con la tabla asociados
            $table->foreign('matricula')
                  ->references('matricula')
                  ->on('asociados')
                  ->onDelete('cascade');

            // Índice único para evitar duplicados en el mismo día
            $table->unique(['matricula', 'fecha']);

            $table->boolean('cancelado')->default(false);

            $table->timestamps();
        });

// Tabla pivote

        Schema::create('asistencia_recibo', function (Blueprint $table) {
            $table->foreignIdFor(Asistencia::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Recibo::class)->constrained()->cascadeOnDelete();

           // $table->primary(['asistencia_id','recibo_id']);

            $table->primary([
                (new Asistencia)->getForeignKey(),
                (new Recibo)->getForeignKey()
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_recibo');
        Schema::dropIfExists('asistencias');
    }
};
