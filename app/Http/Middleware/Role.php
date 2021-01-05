<?php

namespace App\Http\Middleware;
use Closure;
use Error;
use Illuminate\Support\Facades\Auth;


class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
       $roles = array_slice(func_get_args(),2);

        if(!Auth::check()){
            return redirect()->route('login');
        }

        if(!count($roles)){
            throw new Error('The role middleware is empty');
        }

        if(!Auth::user()->hasRoles($roles)){
            return redirect()->route('home')->with('right',trans('access.right'));
        }

        return $next($request);

    }
}
