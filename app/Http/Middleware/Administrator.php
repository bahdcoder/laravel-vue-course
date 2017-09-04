<?php

namespace Bahdcasts\Http\Middleware;

use Closure;

class Administrator
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
        if(auth()->check()) {
            if(auth()->user()->isAdmin()) {
                return $next($request);
            } else {
                session()->flash('error', 'You are not authorized to perform this action');
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
        
    }
}
