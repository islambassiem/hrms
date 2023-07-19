<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  public function index()
  {
    return view('index');
  }

  public function login(Request $request)
  {
    $request->validate([
      'empid' => 'required',
      'password' => 'required'
    ]);
    $employee = Employee::where('empid', $request->empid)->first();
    if($employee){
      if(Hash::check($request->password, $employee->password)){
        $request->session()->put('empid', $employee->empid);
        return view('dashboard', compact('employee'));
      }else{
        return back()->with('Credentials are not correct');
      }
    }else{
      return back()->with('Credentials are not correct');
    }
  }

  public function logout()
  {
    if(session()->has('empid')){
      session()->pull('empid');
      return redirect('login');
    }
  }
}
