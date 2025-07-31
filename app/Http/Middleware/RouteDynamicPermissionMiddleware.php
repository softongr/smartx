<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
class RouteDynamicPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('web')->user();
        $currentRouteName = $request->route()->getName(); // Παίρνουμε το όνομα του route
        // Αν είναι super-admin, έχει πλήρη πρόσβαση
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }


        // Αν το route δεν έχει permission στη βάση, επιτρέπεται για όλους τους admins
        if (!Permission::where('name', $currentRouteName)->exists()) {
            return $next($request);
        }

        // Αν ο admin δεν έχει το permission, μπλοκάρεται
        if (!$admin->hasPermissionTo($currentRouteName)) {
            abort(403, 'Δεν έχετε δικαίωμα πρόσβασης.');
        }

        return $next($request);
    }
}
