<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !($user->is_admin ?? false)) {
            return redirect('/')->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        return $next($request);
    }
}
