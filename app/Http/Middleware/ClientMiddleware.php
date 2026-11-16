<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $request->expectsJson()
                ? response()->json(['ok' => false, 'message' => 'Требуется авторизация'], 401)
                : redirect()->route('login');
        }
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.orders');
        }
        return $next($request);
    }
}