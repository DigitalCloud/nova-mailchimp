<?php

namespace Digitalcloud\NovaMailchimp\Http\Middleware;

use Digitalcloud\NovaMailchimp\NovaMailchimp;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaMailchimp::class)->authorize($request) ? $next($request) : abort(403);
    }
}
