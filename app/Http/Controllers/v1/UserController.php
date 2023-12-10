<?php

namespace App\Http\Controllers\v1;

use App\DTO\LoginDto;
use App\DTO\RegistrationDto;
use App\Exceptions\UnauthorizeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Utils\Token;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
    * @param RegistrationRequest $request
    * @return JsonResponse
    */
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $registrationDto = RegistrationDto::fromRequest($request);

        User::create($registrationDto->toArray());

        return response()->json([], 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UnauthorizeException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = LoginDto::fromRequest($request);

        if (Auth::attempt($credentials->toArray())) {
            $user = $request->user();

            $token = Token::create($user);

            return response()->json([
                'token' => $token
            ]);
        } else {
            throw new UnauthorizeException();
        }
    }

    /**
    * @return void
    */
    public function logout(): void
    {
        Auth::guard('web')->logout();
    }

}
