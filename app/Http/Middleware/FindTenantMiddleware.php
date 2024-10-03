<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use App\Models\Pms\PmsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FindTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $token = $user->currentAccessToken()->abilities;
        $subdomain = $token['subdomain'];

        $tenant = Tenant::find($subdomain);
        $response = $tenant->run(function () use ($request, $tenant) {
            $email = auth()->user()->email;
            $user = PmsUser::where('email', $email)->first();
            if ($user) {
                $request->merge(['authenticatedUser' => $user]);
                $request->merge(['tenantData' => $tenant]);
                return $user;
            }
            return false;
        });

        if (!$response) {
            return response()->json(['error' => 'Subdomain not define.'], 401);
        }

        return $next($request);
    }
}
