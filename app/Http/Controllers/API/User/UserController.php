<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
      public function get(){
        $users = User::all();

        return response()->json([
          'status' => true,
          'users'  =>  UserResource::collection($users),
          // 'users'  => $users,
        ]);
      }
}
