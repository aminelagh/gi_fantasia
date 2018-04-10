<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class OuvrierMiddleware
{
  public function handle($request, Closure $next)
  {
    if (Sentinel::check() && Sentinel::getUser()->roles()->first()->slug == 'ouvrier') {
      return $next($request);
    } else
    return redirect()->route('login');
  }
}
