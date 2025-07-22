<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            $requiredFields = ['first_name', 'last_name', 'phone', 'city'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (empty($user->$field)) {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields) && !$request->routeIs('profile.*')) {
                return redirect()->route('profile.edit')
                    ->with('warning', __('Please complete your profile to access all APWAP features.'))
                    ->with('missing_fields', $missingFields);
            }
        }

        return $next($request);
    }
}
