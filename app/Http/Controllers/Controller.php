<?php

namespace App\Http\Controllers;

use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function random()
    {
      $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $pass = array();
      $alphaLength = strlen($alphabet) - 1;
      for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
      return implode($pass);
    }

    public function get_user_from_token($api_token)
    {
      if ($api_token) {
        $api_token = explode('|', $api_token, 2);
        $id = $api_token[0];
        $token = $api_token[1];

        $token = hash('sha256', $token);

        $token = PersonalAccessToken::where('id', $id)->where('token', $token)->first();

        $user = is_null($token) ? null : $token->tokenable;

        return ($user);
      }

      return null;

    }
}
