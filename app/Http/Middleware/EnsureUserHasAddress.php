<?php

namespace App\Http\Middleware;

use App\Models\Address;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Address::where('user_id', auth()->id())->exists()) {
            return redirect()
                ->route('addresses.index')
                ->with('error', 'Please add an address to add items to your cart.');
        }
        return $next($request);
    }
}
