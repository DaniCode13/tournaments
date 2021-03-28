<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable =['title','participants'];
    //relacion entre un torneo pertenece a un usuario
    public function user()
    {
        return $this->belognsTo(User::class);
    }


}
