<?php

// use App\Models\User; 
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
        Schema::create('asociados', function (Blueprint $table) {
            $table->id();
            $table->integer('matricula')->unique();
            // $table->foreignIdFor(User::class)->unique()->constrained()->cascadeOnDelete();
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->enum('puesto', ['J', 'P'])->default('J');
            $table->enum('sexo', ['M', 'F']);
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->date('fecha_jubilacion')->nullable();
            $table->integer('edad_jubilacion')->nullable();
            $table->string('celular', 12)->nullable();
            $table->boolean('activo')->default(true); // Valor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asociados');
    }
};
