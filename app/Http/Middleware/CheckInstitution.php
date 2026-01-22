<?php

namespace App\Http\Middleware;

use App\Services\InstitutionContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstitution
{
    public function __construct(protected InstitutionContext $context)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('Administrador')) {
            return $next($request);
        }

        if (!$this->context->check()) {
            // If user has no institution selected, check if they have any institutions
            if ($user && $user->institutions()->exists()) {
                // Redirect to selection page (Inertia/Web) or Error (API)
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Institution context required.'], 403);
                }
                return to_route('institution.select'); // We need to create this route
            }

            // If user has no institutions at all, handled by app logic (e.g. create one or be invited)
            // For now, let's allow them to proceed only if they are on specific excluded routes?
            // Or strictly block.
            // Let's redirect to selection/creation.
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No institution found.'], 403);
            }
            return to_route('institution.create'); // Or selection page which handles "create new"
        }

        return $next($request);
    }
}
