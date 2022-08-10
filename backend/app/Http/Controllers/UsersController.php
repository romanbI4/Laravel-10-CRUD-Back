<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
                ->json(['status' => 'Invalid data'],401);
        }
    }

    public function signIn(Request $request)
    {
        $validation = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validation) {

            $user = $this->usersService->getOneByParams('email', $request->input('email'));

            if (Hash::check($request->password, $user->password)){

                $apiToken = Str::random(40);
                $this->usersService->updateOneByParams($user->id, ["api_token" => $apiToken]);

                return response()
                    ->json([
                        'status' => 'success',
                        'api_token' => $apiToken
                    ]);

            } else {

                return response()
                    ->json(['status' => 'Invalid credentials'],401);

            }
        }
    }

    public function recoverPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
    }

}
