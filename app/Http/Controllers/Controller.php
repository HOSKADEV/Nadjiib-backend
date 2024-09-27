<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Laravel\Sanctum\PersonalAccessToken;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Kreait\Firebase\Exception\FirebaseException;
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

    function random_phone_number()
    {
      $alphabet = '1234567890';
      $pass = array();
      $alphaLength = strlen($alphabet) - 1;
      for ($i = 0; $i < 9; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
      return '0' . implode($pass);
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

    public function send_fcm_device($title, $content, $fcm_token)
  {
    try {
      $messaging = app('firebase.messaging');

      $notification = \Kreait\Firebase\Messaging\Notification::fromArray([
        'title' => $title,
        'body' => $content,
        //'image' => $imageUrl,
      ]);

      $deviceToken = $fcm_token;

      if(!empty($deviceToken)){

        $message = CloudMessage::withTarget('token', $deviceToken)
          ->withNotification($notification) // optional
          //->withData($data) // optional
        ;

        $messaging->send($message);
      }

      return;
    } catch (FirebaseException $e) {
      return $e;
    }


  }
  public function send_fcm_multi($title, $content, $fcm_tokens)
  {
    try {
      $messaging = app('firebase.messaging');

      $notification = \Kreait\Firebase\Messaging\Notification::fromArray([
        'title' => $title,
        'body' => $content,
        //'image' => $imageUrl,
      ]);

      $deviceTokens = $fcm_tokens;

      $message = CloudMessage::new()
        ->withNotification($notification) // optional
        //->withData($data) // optional
      ;

      $messaging->sendMulticast($message, $deviceTokens);

      return;
    } catch (FirebaseException $e) {
      return $e;
    }

  }

    public static function standard_bonus_amount(){
    $standard_bonus = Setting::where('name','standard_bonus')->value('value');
    return empty($standard_bonus) ? 0 : $standard_bonus;
    }

    public static function cloud_bonus_amount(){
      $cloud_bonus = Setting::where('name','cloud_bonus')->value('value');
      return empty($cloud_bonus) ? 0 : $cloud_bonus;
    }

    public static function community_bonus_amount(){
      $community_bonus = Setting::where('name','community_bonus')->value('value');
      return empty($community_bonus) ? 0 : $community_bonus;
    }

    public static function invitation_bonus_amount(){
      $invitation_bonus = Setting::where('name','invitation_bonus')->value('value');
      return empty($invitation_bonus) ? 0 : $invitation_bonus;
    }

    public static function invitation_discount_amount(){
      $invitation_discount = Setting::where('name','invitation_discount')->value('value');
      return empty($invitation_discount) ? 0 : $invitation_discount;
    }
}
