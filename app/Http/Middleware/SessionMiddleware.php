<?php

namespace App\Http\Middleware;

use Closure;
use Constants;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Http\Request;
class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      if ($request->session()->has(Constants::CONSTANTS_SESSION_LOGIN())) {
          return $next($request);
      }else{
        Log::warn(Constants::SYS_MSG_SESSION_EXPIRED());
        $request->session()->forget(Constants::CONSTANTS_SESSION_LOGIN());
        $validator = Validator::make($request->all(), [
        ]);
        $validator->errors()->add(Constants::SYS_RC_SESSION_EXPIRED(), Constants::SYS_MSG_SESSION_EXPIRED());
        return redirect('/')->withErrors($validator);
      }

    }
}
