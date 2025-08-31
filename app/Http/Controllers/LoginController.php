<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }
    
    public function store()
    {
        $attributes = request()->validate([
            'Email'=>['required','email'],
            'password' =>['required']
        ]);
        
        if( ! Auth::attempt($attributes))
        {
          throw ValidationException::withMessages([
            'Email' => 'Izvinite, morate uneti validne podatke.'
          ]);
        }
        
        request()->session()->regenerate();

        if (Auth::user()->Role === 'Administrator') {
            return redirect()->route('admin.dashboard');  
        }
        
        return redirect('/');
    }
    
    public function destroy()
    {
        Auth::logout();
        
        return redirect('/');
    }
}
