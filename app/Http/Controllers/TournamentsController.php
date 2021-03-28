<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\ParticipantTournament;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->id;
        return User::findOrFail($user)->tournaments;
    }

    public function create()
    {
        return view('tournaments.create');
    }

    public function edit(Request $request, Tournament $tournament)
    {
        return view('tournaments.edit', ['tournament' => $tournament,]);
    }

    public function tournament_preview(Tournament $tournament){
        return view('tournaments.preview',['tournament'=> $tournament]);
    }

    public function create_tournament(Request $request)
    {

        // $tournament = json_encode($request->participants);
        $data = $request->validate([
            "title" => "required",
            'participants' => 'required'
        ]);
        if (auth()->user()) {
            $tournament = auth()->user()->tournaments()->create([
                'title' => $data['title'],
                'participants' => json_encode($data['participants'])
            ]);
        }
        return response()->json($tournament, 201);
    }


    public function update_tournament(Request $request, Tournament $tournament)
    {
        $tournament->update((['title'=>$request['title'],
            'participants'=> json_encode($request['participants'])
        ]));

        return response()->json($tournament, 200);
    }
}
