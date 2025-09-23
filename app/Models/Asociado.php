<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Asociado extends Model
{
    use HasFactory;

// se crea el fillable para asignacion masiva de los campos en el controlador que se grabaran desde el formulario

    protected $fillable = ['matricula','nombre','apellido','puesto','sexo','fecha_nacimiento','fecha_jubilacion','celular','edad','edad_jubilacion'];



    public function recibos() : hasMany {
        return $this->hasMany(Recibo::class, 'matricula', 'matricula');
    }
    // public function recibos() : hasMany {
    //     return $this->hasMany(Recibo::class);
    // }

    //
    // public function asistencias() : hasMany {
    //     return $this->hasMany(Asistencia::class);
    // }

    public function asistencias() : hasMany
    {
        return $this->hasMany(Asistencia::class, 'matricula', 'matricula');
    }
}
