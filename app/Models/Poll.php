<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
   public function user()
   {
       //Relacion donde una encuesta pertenece a un Usuario
       return $this->belongsTo(User::class);
   }
}
