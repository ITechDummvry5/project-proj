<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUserRequest;


class AuthUserController extends Controller
{
    public function ShowRegisterForm(){
 return view('auth.register');
    }
       public function ShowLoginForm(){
 return view('auth.login');
    }
    public function PostRegisterInfo(RegisterUserRequest $request){
      // Handle the registration request
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'USER',
            'ban_status' => 0, 
        ]);
        // After registration, redirect to some route, or login page with login tab active
        return redirect()->route('GoLogin')->with('success', 'Registration successful!');
    }

        public function PostLoginInfo(Request $request){
      // Handle the registration request

            $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);
     if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();

        
        // Check if the user is banned
  if (Auth::user()->ban_status === 1) {
    Auth::logout();
    return redirect()->route('GoLogin')->with('banned', 'Your account is currently Banned');
}
        // Redirect based on role
        $user = Auth::user();

        switch ($user->role) {
            case 'ADMIN':
                return redirect()->route('GotoDashboard')->with('success', 'Login successful!');
            case 'USER':
                return redirect()->route('GotoMain')->with('success', 'Login successful!');
            default:
                Auth::logout();
                return redirect()->route('GoLogin')->withErrors('Unauthorized role');
        }
    }
    // If authentication fails, redirect back with an error message
    return redirect()->back()
        ->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])
        ->withInput($request->except('password'));
   }

   //logout function
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('GotoLogin')->with('message', 'You have been logged out successfully!');
    }
}
