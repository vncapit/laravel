<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;

class ExpectedJson
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
