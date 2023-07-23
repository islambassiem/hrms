<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class GoogleController extends Controller
{

  public function googleRedirect()
  {
    return Socialite::driver('google')->redirect();
  }

  public function googleCallback()
  {
    $user = Socialite::driver('google')->user();

    $employee = User::where('email', $user->email)->first();

    // dd($employee);

    try {
      Auth::login($employee);
      return redirect('/dashboard');
    } catch (\Throwable $th) {
      return view('404');
    }

  }
}
