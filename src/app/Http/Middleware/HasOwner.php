<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasOwner
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

        if($request->route('listing') && gettype($request->route('listing')) != 'string'){
            if(!$request->user()->is($request->route('listing')->user()->first())){
                abort(403, 'Access denied.');
             }
        }
    
          return $next($request);
    }
}
