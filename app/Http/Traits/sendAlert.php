<?php
namespace App\Http\Traits;

trait sendAlert {
public function alertAdmins($title, $body, $deep_link = null){
  $admins = \App\Models\User::where('role', 0)->where('status','ACTIVE')->pluck('id')->toArray();

      $beamsClient = new \Pusher\PushNotifications\PushNotifications(\App\Models\Setting::pusher_credentials());

      $publishResponse = $beamsClient->publishToUsers(
        array_map('strval', $admins),
        [
          "web" => [
            "notification" => [
              "title" => $title,
              "body" => $body,
              'deep_link' => $deep_link,
            ]
          ]
      ]);
}
}
