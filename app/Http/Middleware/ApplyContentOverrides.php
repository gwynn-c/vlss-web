<?php

namespace App\Http\Middleware;

use App\Support\SiteContent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyContentOverrides
{
    /**
     * Overlay admin-edited content/settings onto the config defaults for this
     * request, so public controllers and views keep reading config('content.*')
     * and config('site.*') without knowing the database exists.
     */
    public function handle(Request $request, Closure $next): Response
    {
        SiteContent::applyOverrides();

        return $next($request);
    }
}
