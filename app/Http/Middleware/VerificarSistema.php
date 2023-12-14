<?php

// app/Http/Middleware/VerificarSistema.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificarSistema
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if ($this->usuarioPertenceAoSistemaCorreto()) {
                return $next($request);
            }
        }
    }

    private function usuarioPertenceAoSistemaCorreto()
    {


        return true;
    }
}
