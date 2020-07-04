<?php

namespace App\Http\Controllers;

use App\Models\TypePoll;

use Illuminate\Http\Request;
use App\Http\Controllers\URL;


class PollsController extends Controller
{
    // redirigir a la pagina de login si no tiene iniciado sesion
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(){
        return view('polls.create');
    }

    public function store(Request $request){
        $url_base= url('/');
        $random = "dasdsa";
        $data =$request->validate([
            "title"=>"required",
            "options" => "required",
            "type_poll_id"=>"required"
        ]);
        $data['url'] = $url_base.'/'.$random;
       return auth()->user()->polls()->create($data);

    }

    public function types_polls(){
       return TypePoll::all();
    }
}
