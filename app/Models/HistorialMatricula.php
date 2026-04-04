<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialMatricula extends Model
{
    protected $table = 'historial_matriculas';

    protected $fillable = [
        'matricula_anterior',
        'matricula_nueva',
        'usuario_id'
    ];
}