<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::orderByDesc("id")->get();
        $subscriptions = $subscriptions->unique('user_id');
    
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function renew(Request $request)
    {
        $user = User::find($request->id);
        

        if(!is_null($user)) {
            if(!is_null($user->group_id)) {
                if(count(Subscription::where('user_id', $user->id)->where('expired', 0)->get()) == 0) {

                    $subscriptionStart = \Helper::nextGroupSession(User::find($request->id)->group_id);
                    $subscriptionEnd = $subscriptionStart->copy()->addMonth();
                    
                    Subscription::create([
                        'user_id' => $request->id,
                        'start_day' => $subscriptionStart,
                        'end_day' => $subscriptionEnd,
                        'payment_method' => 'renew',
                        'amount' => 0
                    ]);
    
                    return Redirect::back();
    
                } else {
                    return Redirect::back()->withErrors(['msg' => 'This User is already subscribed']);
                }
            } else {
                return Redirect::back()->withErrors(['msg' => 'This user does not belong to any group']);
            }
            
        } else {
            return Redirect::back()->withError('msg', 'This User doesn\'t exists');
        }
        
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $subscription = Subscription::find($id);
        if(!boolval($subscription->expired)) {
            
            $subscription->update([
                'expired' => 1
            ]);

            return Redirect::back();

        } else {
            return Redirect::back()->withErrors(['msg' => 'This subscription is already expired']);
        }
    }
        
    
}
