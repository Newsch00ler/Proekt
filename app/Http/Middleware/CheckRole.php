<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        if ($user->role === 'Администратор'){
            return redirect('/admin/dashboard');
        }
        else if ($user->role === 'Автор') {
            return redirect('/my-works');
        }
        else if ($user->role === 'Эксперт') {
            return redirect('/e-show-works');
        }
        else if ($user->role === 'Председатель') {
            return redirect('/show-works');
        }
        else if ($user->role === 'Секретарь') {
            return redirect('/show-works');
        }
    }
}
