<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    //
    use HasFactory;

  //  protected $table = 'asistencias';
  //  protected $fillable = ['matricula', 'fecha'];

// en plural por que un recibo puede tener varias asistencias

    public function recibos(): BelongsToMany {
        return $this->BelongsToMany(Recibo::class);
    }

    public function asociado() : belongsTo
    {
        return $this->belongsTo(Asociado::class, 'matricula', 'matricula');
    }
}
