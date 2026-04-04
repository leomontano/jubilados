<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // TABLA RECIBOS
        Schema::table('recibos', function (Blueprint $table) {

            // eliminar foreign key actual
            $table->dropForeign(['matricula']);

        });

        Schema::table('recibos', function (Blueprint $table) {

            // crear nueva con ON UPDATE CASCADE
            $table->foreign('matricula')
                ->references('matricula')
                ->on('asociados')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });


        // TABLA ASISTENCIAS
        Schema::table('asistencias', function (Blueprint $table) {

            $table->dropForeign(['matricula']);

        });

        Schema::table('asistencias', function (Blueprint $table) {

            $table->foreign('matricula')
                ->references('matricula')
                ->on('asociados')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        // regresar al estado anterior

        Schema::table('recibos', function (Blueprint $table) {

            $table->dropForeign(['matricula']);

        });

        Schema::table('recibos', function (Blueprint $table) {

            $table->foreign('matricula')
                ->references('matricula')
                ->on('asociados')
                ->onDelete('cascade');

        });


        Schema::table('asistencias', function (Blueprint $table) {

            $table->dropForeign(['matricula']);

        });

        Schema::table('asistencias', function (Blueprint $table) {

            $table->foreign('matricula')
                ->references('matricula')
                ->on('asociados')
                ->onDelete('cascade');

        });
    }
};