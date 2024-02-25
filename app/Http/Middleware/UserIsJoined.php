<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Subscription;
use Illuminate\Http\Request;

class UserIsJoined
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $isAllowedToJoin = Subscription::where(
            "user_id", auth()->user()->id
        )->get();

        if(count($isAllowedToJoin) > 0) {

            return $next($request);

        } else {

            return redirect( route('home') );
            
        }
        abort(403);
    }
}
