<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'FirstName'=>['required'],
            'LastName'=>['required'],
            'Email'=>['required','email'],
            'password'=>['required', Password::min(6),'confirmed']
        ]);

        $attributes['Role'] = 'User';
        
       $user =  User::create($attributes);

       Auth::login($user);

       return redirect('/');

    }
}
