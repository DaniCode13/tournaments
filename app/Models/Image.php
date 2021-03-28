<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=['user_id','image_url'];

    public function user(){
        return $this->belogsTo(User::class);
    }
}
