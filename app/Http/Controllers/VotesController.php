<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Utils\CheckDuplication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VotesController extends Controller
{
    public function get_results_from_poll(Poll $poll)
    {
        $results = Poll::findOrFail($poll->id)->result;
        $results = json_decode($results->vote_count);
        return json_decode($results);
    }

    public function make_vote(Request $request, Poll $poll)
    {

        $data = $request->validate([
            "vote" => "required",
        ]);
//        valida si ya se realizo una votacion con la cookie del navegador
        $check = new CheckDuplication();
        $duplication = $check->check_duplication($request, $poll);
        if ($duplication ==  0) {
            $result = $this->increment_vote($poll, $data);
            if ($result->save()) {
                $data['ip'] = $check->get_ip();
                $new_record = $poll->votes()->create($data);
                $response = new Response($new_record);
                $old_cookie = $request->cookie("POLL");
                $response->withCookie(cookie("POLL", $old_cookie . $poll->id . ","));
                return $response;
            }
        }
    }

    private function increment_vote($poll, $data)
    {
        $result = Poll::findOrFail($poll->id)->result;
        //la columna vote_count almacena las opciones de la encuesta y lleva el conteo de votos
        //se retornara el nuevo registro con la cantidad de votos actualizada
        //el valor de $data['vote'] es el id de la opcion que se voto
        $vote_count = json_decode(json_decode($result->vote_count));
        foreach ($vote_count as $index => $value) {
            if ($value->id === $data['vote']) {
                $vote_count[$index]->votes++;
            }
        }
        $result->vote_count = json_encode(json_encode($vote_count));
        return $result;
    }


}
