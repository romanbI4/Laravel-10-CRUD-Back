<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{

    private UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $validation = $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required|string|unique:users'
        ]);

        if ($validation) {
            return response()
                ->json([
                    'status' => 'success',
                    'data' => $this->usersService->create($request)
                ]);
        } else {
            return response()
                ->json([
                    'status' => 'error'
                ],401);
        }
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    public function recoverPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
    }

}
