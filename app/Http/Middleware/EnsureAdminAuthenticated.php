<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! (bool) $request->session()->get('portfolio_admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        $admin = User::query()
            ->whereKey($request->session()->get('portfolio_admin_user_id'))
            ->where('is_admin', true)
            ->exists();

        if (! $admin) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
