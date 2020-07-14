<?php

namespace App\Utils;

use App\Models\Poll;

 class CheckDuplication
{

    public function get_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function check_duplication($request, $poll)
    {
        switch ($poll->type_poll_id) {
            case 1:
                return $this->validate_ip($poll);
                break;
            case 2:
                return $this->validate_cookie($request, $poll);
                break;
            case 3:
                return 0;
                break;
        }
    }

    public function validate_cookie($request, $poll)
    {
        $cookie = $request->cookie("POLL");
        if (isset($cookie)) {
            $polls = explode(",", $cookie);
            $poll_cookie_exists = in_array($poll->id, $polls);
            return $poll_cookie_exists ? 1 : 0;
        } else {
            return 0;
        }

    }
    public function validate_ip($poll){
        $votes = Poll::findOrFail($poll->id)->votes->where('ip','=',$this->get_ip())->first();
        if ($votes){
            return 1;
        }else{
            return 0;
        }
    }
}

