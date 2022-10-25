<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Traits\ResetsPasswords;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    use ResetsPasswords;

    private UsersService $usersService;
    private string $broker;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
        $this->broker = 'users';
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:users,email|string',
            'password' => 'required|string',
            'phone' => 'required|unique:users,phone|string|digits:10'
        ]);

        return response()
            ->json([
                'status' => 'success',
                'data' => $this->usersService->create($request)
            ]);
    }

    /**
     * @throws ValidationException
     */
    public function signIn(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|exists:users,email|string',
            'password' => 'required|string'
        ]);

        if ($request->email) {
            $user = $this->usersService->getOneByParams('email', $request->email);
        }

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $apiToken = Str::random(40);
                $this->usersService->updateOneByParams($user->id, ["api_token" => $apiToken]);

                return response()
                    ->json([
                        'status' => 'success',
                        'api_token' => $apiToken
                    ]);
            } else {
                return response()
                    ->json(['status' => 'Invalid credentials'], 401);
            }
        } else {
            return response()
                ->json(['status' => 'Not found user with this email'], 401);
        }
    }
}
