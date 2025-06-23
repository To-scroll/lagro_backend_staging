<?php

namespace App\Http\Middleware;
use Closure;

class Staff {
   public function handle($request, Closure $next) {
      if(\Auth::check())
      {
        if (\Auth::user()->user_type != 'staff')
        {
                \Auth::logout();
                return redirect('login');
        }
         return $next($request);
      }
      return redirect('login');
     
   }
}