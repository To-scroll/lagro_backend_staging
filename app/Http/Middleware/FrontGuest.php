<?php

namespace App\Http\Middleware;
use Closure;

class FrontGuest{
   public function handle($request, Closure $next) {
      if(\Auth::check())
      {
        if (\Auth::user()->user_type == 'admin')
        {
                \Auth::logout();
                 return redirect('/');
        } 
        return $next($request); 
      }
      return $next($request); 
      
   }
}