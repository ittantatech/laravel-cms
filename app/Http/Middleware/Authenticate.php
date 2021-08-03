<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
class Authenticate extends Middleware
{
    /**
     * Check the unauthentication for which type of user logged out and redirect to gurd base url
     */
    protected function unauthenticated($request, array $guards)
    {
        if($guards[0]=='admin'){
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectAdminTo($request)
            );    
        }
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Get the path the admin should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectAdminTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }
}
