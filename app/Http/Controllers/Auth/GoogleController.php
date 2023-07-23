<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;

class GoogleController extends Controller
{

  public function googleRedirect()
  {
    return Socialite::driver('google')->redirect();
  }

  public function googleCallback()
  {
    $user = Socialite::driver('google')->user();
    dd($user);

    // Auth::login($user);

    // return redirect('/dashboard');
  }
}
