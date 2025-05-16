<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\Subscription;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = User::with(['purchases.film','subscriptions'])
        ->where('UserID', Auth::id())
        ->first();  
        
        return view('user.dashboard', [
            'user' => $user,
            'purchases' => $user->purchases()->with('film','series')->paginate(5),
            'subscriptions' => $user->subscriptions
        ]);
    }
    
    public function update(Request $request, User $user)
    {
        if ($user->UserID !== Auth::id()) {
            abort(403);
        }
        
        $attributes = $request->validate([
            'FirstName' => ['sometimes', 'string', 'max:50'],
            'LastName'  => ['sometimes', 'string', 'max:50'],
            'Email'     => [
                'sometimes',
                'email',
                'max:100',
                Rule::unique('Users')->ignore($user->UserID, 'UserID') 
            ],
            'password'  => ['sometimes',Password::min(6)],
            
        ]);
        
        
        try {
            $user->fill($attributes)->save();
            return redirect()->back()->with('success', 'Profil je ažuriran!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' , 'Greška pri ažuriranju!']);
        }
    }
    
    
    public function cancelPurchase(Purchase $purchase)
    {
        if ($purchase->UserID !== Auth::id()) {
            abort(403);
        }
        
        $purchase->delete();
        
        return back()->with('success', 'Kupovina je otkazana!');
    }
    
    
    public function destroy(Subscription $subscription)
    {
        if ($subscription->UserID !== Auth::id()) {
            abort(403);
        }
        
        $subscription->delete();
        
        return back()->with('success', 'Pretplata uspešno otkazana!');
    }
}


