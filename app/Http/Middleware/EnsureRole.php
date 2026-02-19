<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! auth()->check()) {
            abort(401);
        }

        $context = session('active_context');

        if (! $context) {
            abort(403, 'کانتکست فعال وجود ندارد.');
        }

        if ((int) $context['role_id'] !== (int) \App\Models\Role::where('slug', $role)->value('id')) {
            abort(403, 'شما دسترسی به این بخش را ندارید.');
        }

        return $next($request);
    }
}
