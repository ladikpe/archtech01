<?php

namespace App\Http\Middleware;

use Closure;

class VoteReportMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(\Auth::user()->role->permissions->contains('constant', 'view_result')){
            return $next($request);
        }
        if(request()->ajax()){
            return ('You dont have permission to view this page.');
        }
        return  redirect('/home')->with('error','You dont have permission to view this page.');
    }
}
