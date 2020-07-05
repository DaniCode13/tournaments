<?php

namespace App\Http\Controllers;

use App\Models\TypePoll;
use App\Models\Poll;
use Illuminate\Http\Request;
use App\Http\Controllers\URL;
use Illuminate\Support\Str;




class PollsController extends Controller
{
    // redirigir a la pagina de login si no tiene iniciado sesion
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('polls.create');
    }
    public function index()
    {
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            "title" => "required",
            "options" => "required",
            "type_poll_id" => "required"
        ]);
        // $data['url']= Str::random(40);
        return auth()->user()->polls()->create($data);
    }
    public function show(Poll $poll)
    {
        return view('polls.show', compact('poll'));
    }

    public function get_poll(){
        
        $query= Poll::findOrFail(request()->route('id'));
         dd($query);
    }

    public function types_polls()
    {
        return TypePoll::all();
    }
}
