<?php

namespace App\Http\Controllers\API\Auth;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;


class AuthController extends Controller
{
    private $user;

    public function __construct(UserRepository $user){
      $this->user = $user;
    }


    public function login(Request $request){

      $validator = Validator::make($request->all(), [
        'uid' => 'required|string',
        'fcm_token' => 'sometimes|string',
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first()
          ]
        );
      }

      $auth = Firebase::auth();

      try {

        $firebase_user = $auth->getUser($request->uid);

        $user = $this->user->findByEmail($firebase_user->email);

        if(is_null($user)){
          $user = $this->user->create([
            'name' => $firebase_user->displayName,
            'email' => $firebase_user->email,
            'phone' => $firebase_user->phoneNumber,
            'image' => $firebase_user->photoUrl,
          ]);
        }

        if($request->has('fcm_token')){
          $user->fcm_token = $request->fcm_token;
          $user->save();
        }

        if(empty($user->name)){
          $user->name = 'user#'.$user->id;
          $user->save();
        }

      if($user->status == 'INACTIVE'){
        throw new Exception('blocked account');
      }

        $token = $user->createToken($this->random())->plainTextToken;

        return response()->json([
          'status'=> true,
          'message' => 'success',
          'token' => $token,
          'data' => new UserResource($user),
        ]);

      } catch (Exception $e) {
          return response()->json([
          'status'=> false,
          'message' => $e->getMessage(),
        ]);
      }


    }

    public function logout(Request $request){
      try{
        $user = $request->user();
        $user->update(['fcm_token' => null]);
        $user->currentAccessToken()->delete();

        return response()->json([
          'status'=> true,
          'message' => 'logged out',
        ]);
      }catch(Exception $e){
        return response()->json([
          'status'=> false,
          'message' => $e->getMessage(),
        ]);
      }

    }

    public function home(Request $request){
      try{

        $user = $this->get_user_from_token($request->bearerToken());
        $request->merge(['user' => $user]);

        return response()->json([
          'status'=> 1,
          'message' => 'success',
          'data' => new HomePageResource($user)
        ]);
      }catch(Exception $e){
        return response()->json([
          'status'=> 0,
          'message' => $e->getMessage(),
        ]);
      }
    }

}
