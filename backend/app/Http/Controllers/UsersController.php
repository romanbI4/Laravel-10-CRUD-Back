<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Traits\ResetsPasswords;

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
     */
    public function register(Request $request): JsonResponse
    {
       return response()
            ->json([
                'status' => 'success',
                'data' => $this->usersService->create($request)
            ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function signIn(Request $request): JsonResponse
    {
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
                    ->json(['status' => 'error', 'errors' => 'Invalid credentials'], 401);
            }
        }

    }
}
