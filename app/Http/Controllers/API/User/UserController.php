<?php

namespace App\Http\Controllers\API\User;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function get()
  {
    $users = User::all();

    return response()->json([
      'status' => true,
      'users' => UserResource::collection($users),
      // 'users'  => $users,
    ]);
  }

  public function info(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id'
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => $validation->errors()->first(),
        //'message' => 'Invalid coupon',
        //'errors' => $validation->errors()
      ], 422);
    }

    try {

      $user = User::find($request->user_id);
      $data = [
        "name" => $user->name,
        "image" => is_null($user->image) ? null : url($user->image),
        "role" => $user->role,
      ];

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $data
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function deactivate(Request $request){
    try{

      $user = $request->user();

      $user->update(['status' => 'DELETED' , 'email' => 'deleted_user#'.$user->id.'@mail.com' , 'fcm_token' => null]);

      $user->tokens()->delete();

      //$user->delete();

      return response()->json([
        'status'=> 1,
        'message' => 'success',
      ]);
    }catch(Exception $e){
      return response()->json([
        'status'=> 0,
        'message' => $e->getMessage(),
      ]);
    }

  }
}
