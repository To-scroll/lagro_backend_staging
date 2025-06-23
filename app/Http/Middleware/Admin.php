<?php

namespace App\Http\Middleware;
use Closure;

class Admin {
   public function handle($request, Closure $next) {
      if(\Auth::check())
      {
        if (\Auth::user()->user_type != 'admin')
        {
                \Auth::logout();
                return redirect('login');
        }
         return $next($request);
      }
      return redirect('adminlogin');
     
   }
}