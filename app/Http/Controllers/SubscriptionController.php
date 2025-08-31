<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    
    public function create()
    {
        return view('subscription.sub');
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'duration_months' => ['required', 'integer', 'min:1', 'max:12']
        ]);
        
        try {
            $user = Auth::user();
            
            
            Subscription::where('UserID', $user->UserID)
            ->update(['Status' => 'Expired']);
            
        
            Subscription::create([
                'UserID' => $user->UserID,
                'StartDate' => now(),
                'EndDate' => now()->addMonths((int) $request->duration_months),
                'Status' => 'Active',
                'Price' => $request->duration_months * 499
            ]);
            
            return redirect()->route('user.dashboard')
            ->with('success', 'Претплата успешно активирана!');
            
        } catch (\Exception $e) {
            return redirect()->back()
            ->withErrors(['error' => 'Грешка: '.$e->getMessage()]);
        }
    }
    
   
    public function index()
    {
        $subscriptions = Subscription::where('UserID', Auth::id())
        ->orderBy('EndDate', 'desc')
        ->get();
        
        return view('subscription.list', compact('subscriptions'));
    }
    
}
