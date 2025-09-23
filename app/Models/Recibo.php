<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Recibo extends Model
{
    use HasFactory;

    protected $fillable = ['matricula','importe','asistio','folio','foliomes'];


    public function asociado() : belongsTo
    {
        return $this->belongsTo(Asociado::class, 'matricula', 'matricula')->withDefault(['nombre' => 'No Registrado']);
    }

// en plural por que un recibo puede tener varias asistencias

    public function asistencias(): BelongsToMany {
        return $this->BelongsToMany(Asistencia::class);
    }
}
