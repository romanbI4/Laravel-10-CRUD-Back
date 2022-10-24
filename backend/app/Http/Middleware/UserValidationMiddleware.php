<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->firstName || $request->lastName || $request->phone) {
            $validation = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
                'phone' => 'required|string|unique:users'
            ];
        } elseif ($request->email && $request->password) {
            $validation = [
                'email' => 'required|email',
                'password' => 'required|string'
            ];
        } else {
            $validation = [
                'email' => 'required|email'
            ];
        }

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return response('Invalid data.', 401);
        }

        return $next($request);
    }
}
