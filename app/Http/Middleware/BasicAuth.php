<?php

namespace App\Http\Middleware;

use Closure;
use HttpException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws HttpException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('Authorization') === false) {
            header('WWW-Authenticate: Basic realm="HiBit"');
            exit;
        }

        $credentials = base64_decode(substr($request->header('Authorization'), 6));
        list($username, $password) = explode(':', $credentials);

        if ($username !== config('auth.basic_auth.user') || $password !== config('auth.basic_auth.password')) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }


}
