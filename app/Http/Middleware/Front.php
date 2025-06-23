<?php

namespace App\Http\Middleware;
use Closure;

class Front {
   public function handle($request, Closure $next) {
      if(\Auth::check())
      {
        if (\Auth::user()->user_type != 'customer')
        {
                \Auth::logout();
                return redirect('login');
        }
        return $next($request);
      }
      return redirect('login');
      
   }
}