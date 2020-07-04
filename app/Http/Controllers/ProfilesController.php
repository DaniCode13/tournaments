<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::where('username', '=', $user)->firstOrFail();
        //se puede indicar la ruta como profiles/index
        return view('profiles.index');
    }
}
