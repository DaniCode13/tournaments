<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'vote', 'ip'
    ];
    public function poll()
    {
        //Relacion donde una encuesta pertenece a un Usuario
        return $this->belongsTo(Poll::class);
    }

}
