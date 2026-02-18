<?php

namespace App\Http\Middleware;

use Closure;

class EnsureContextIsSelected
{
    public function handle($request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // اگر context قبلا انتخاب شده
        if (session()->has('active_context')) {
            return $next($request);
        }

        // ابتدا تلاش می‌کنیم assignment قبلی آخرین انتخاب شده را پیدا کنیم
        $last = \App\Models\InstituteUser::with('role')
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->where('is_last_selected', true)
            ->first();

        if ($last) {
            $this->setContext($last);

            return $next($request);
        }

        // اگر assignment آخرین انتخاب وجود نداشت → همه assignmentهای فعال
        $assignments = \App\Models\InstituteUser::with('role')
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        if ($assignments->isEmpty()) {
            auth()->logout();
            abort(403, 'هیچ نقش فعالی برای شما تعریف نشده است.');
        }

        if ($assignments->count() === 1) {
            $this->setContext($assignments->first());

            return $next($request);
        }

        // چند assignment دارد → هدایت به صفحه انتخاب نقش
        return redirect()->route('context.select');
    }

    private function setContext($assignment): void
    {
        session([
            'active_context' => [
                'assignment_id' => $assignment->id,
                'role_id' => $assignment->role_id,
                'scope' => $assignment->role->scope,
                'institute_id' => $assignment->institute_id,
                'branch_id' => $assignment->branch_id,
            ],
        ]);

        // ست کردن is_last_selected در DB
        \App\Models\InstituteUser::where('user_id', auth()->id())
            ->update(['is_last_selected' => false]);

        $assignment->is_last_selected = true;
        $assignment->save();
    }
}
