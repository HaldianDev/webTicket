<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Layanan;

class ValidLayanan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $nama = $request->query('nama_layanan');

        if ($nama && !Layanan::where('nama_layanan', $nama)->exists()) {
            abort(403, 'Nama layanan tidak valid');
        }

        return $next($request);
    }
}
