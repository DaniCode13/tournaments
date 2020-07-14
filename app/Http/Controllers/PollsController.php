<?php

namespace App\Http\Controllers;

use App\Models\TypePoll;
use App\Models\Poll;
use App\Models\Result;
use App\Models\User;
use App\Utils\CheckDuplication;
use Illuminate\Http\Request;
use App\Http\Controllers\URL;
use Illuminate\Support\Str;


class PollsController extends Controller
{
    // redirigir a la pagina de login si no tiene iniciado sesion
    public function __construct()
    {
//        $this->middleware('auth')->except('show');
//        $this->middleware('auth');
    }
    public function index(Request $request){
        $user= auth()->user()->id;
        return User::find($user)->polls;
    }

    public function create()
    {
        return view('polls.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required",
            "options" => "required",
            "type_poll_id" => "required"
        ]);
        // $data['url']= Str::random(40);
        if (auth()->user()){
            $poll = auth()->user()->polls()->create($data);

        }else{
            $poll = Poll::create($data);
        }
        if ($poll->exists) {
            //crear e inizializar un objeto resultado y relacionarlo con la encuesta
            $result = new Result;
            $results = $this->initialize_results($poll->options);
            $result->vote_count = $results;
            $result->poll_id = $poll->id;
            $result->save();
        }
        return $poll;

    }

    public function show(Request $request, Poll $poll)
    {
        $chek=new CheckDuplication();
        $duplication = $chek->check_duplication($request, $poll);
        return view('polls.show', ['poll' => $poll, 'duplication' => $duplication]);
    }


    public function get_poll()
    {
        return Poll::findOrFail(request()->route('id'));
    }

    public function types_polls()
    {
        return TypePoll::all();
    }

    private function initialize_results($data)
    {
        $options = json_decode($data);
        $init_results = [];
        foreach ($options as $index => $value) {
            $init_results[$index] = [
                "id" => $value->id,
                "option" => $value->option,
                "votes" => 0
            ];
        }
        $init_results = json_encode($init_results);
        return json_encode($init_results);
    }



}
