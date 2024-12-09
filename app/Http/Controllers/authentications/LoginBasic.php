<?php

namespace App\Http\Controllers\authentications;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request){
    //dd($request);
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/')->withSuccess('Signed in');
    }

    return redirect("/auth/login-basic")->withSuccess('Login details are not valid');
  }

  public function redirect() {
    return Socialite::driver('google')->redirect();
  }

  public function callback() {
    $google_user = Socialite::driver('google')->stateless()->user();
    //dd($google_user);
    $user = User::where('email', $google_user->email)->first();

    if ($user->role() == 2) {
      Auth::login($user);
      return redirect()->route('dashboard');
    } else {
    return redirect()->route('login');
    }

  }
}
