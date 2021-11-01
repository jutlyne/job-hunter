<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuth
{
    protected $auth;

    public function __construct(\Tymon\JWTAuth\JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function checkForToken(Request $request)
    {
        if (!$this->auth->parser()->setRequest($request)->hasToken()) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token not provided');
        }
    }

    public function authenticate(Request $request)
    {
        $this->checkForToken($request);
        try {
            if (!$user = $this->auth->parseToken()->authenticate()) {
                throw new UnauthorizedHttpException('jwt-auth', 'User not found');
            }
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }
    }

    public function handle($request, Closure $next, $role = null)
    {
        $this->authenticate($request);
        if (isset($role)) {
            if (auth('api')->user()->role->name != $role) {
                throw new AccessDeniedHttpException('Forbidden');
            }
        }

        return $next($request);
    }
}
