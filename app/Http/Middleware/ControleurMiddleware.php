<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class ControleurMiddleware
{
  public function handle($request, Closure $next)
  {
    if (Sentinel::check() && Sentinel::getUser()->roles()->first()->slug == 'controleur') {
      return $next($request);
    } else
    return redirect()->route('login');
  }
}
