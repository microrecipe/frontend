<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSessionAuth
{
  public function handle(Request $request, Closure $next)
  {
    if (is_null($request->session()->get('access_token', null))) {
      return redirect()->route('auth.view.signin');
    }

    if (!$request->session()->get('is_admin')) {
      abort(403);
    }

    return $next($request);
  }
}
