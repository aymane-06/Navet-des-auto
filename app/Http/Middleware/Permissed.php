<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permissed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (auth()->check()&& auth()->user()->role_id != 1) {
        //     // dd($request->route()->getActionName());
        //     // dd(auth()->user()->role->permissions->pluck('action'),$request->route()->getActionName());
        // //    dd(auth()->user()->role->permissions->pluck('action')->contains($request->route()->getActionName()));
        //     if (!auth()->user()->role->permissions->pluck('action')->contains($request->route()->getActionName())) {
        //         abort(403,'You are not allowed to access this action');
        //         return back();
        //     }
        //     // return redirect()->route('login');
        // }
        return $next($request);
    }
}
