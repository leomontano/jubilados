<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $table = 'generals';

    protected $fillable = ['asociacion','presidente','cuota','timezone'];


}
