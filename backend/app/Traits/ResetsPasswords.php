<?php

namespace App\Traits;

use App\Models\Users;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait ResetsPasswords
{
    /**
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     * @return Response
     * @throws ValidationException
     */
    public function postLink(Request $request): Response
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     * @return Response
     * @throws ValidationException
     */
    public function sendResetLinkEmail(Request $request): Response
    {
        $this->validateSendResetLinkEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->getSendResetLinkEmailCredentials($request), function (Users $user) use ($request) {
            return Mail::send(
                'email.sendLinkResetPassword',
                ['token' => Password::createToken($user)],
                function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Reset Password');
                }
            );
        }
        );

        return match ($response) {
            Password::RESET_LINK_SENT => $this->getSendResetLinkEmailSuccessResponse($response),
            default => $this->getSendResetLinkEmailFailureResponse($response),
        };
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     *
     * @param  string  $response
     * @return Response
     */
    protected function getSendResetLinkEmailSuccessResponse(string $response): Response
    {
        return response()->json(['success' => true]);
    }

    /**
     * Get the response for after the reset link could not be sent.
     *
     * @param  string  $response
     * @return Response
     */
    protected function getSendResetLinkEmailFailureResponse(string $response): Response
    {
        return response()->json(['success' => false]);
    }

    protected function getSendResetLinkEmailCredentials(Request $request): array
    {
        return $request->only('email');
    }

    /**
     * Validate the request of sending reset link.
     *
     * @param  Request  $request
     * @return void
     * @throws ValidationException
     */
    protected function validateSendResetLinkEmail(Request $request): void
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     * @throws ValidationException
     */
    public function postPassword(Request $request): Response
    {
        return $this->reset($request);
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     * @throws ValidationException
     */
    public function reset(Request $request): Response
    {
        $this->validate(
            $request,
            $this->getResetValidationRules(),
            $this->getResetValidationMessages(),
            $this->getResetValidationCustomAttributes()
        );

        $credentials = $this->getResetCredentials($request);

        $response = $this->broker()->reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        return match ($response) {
            Password::PASSWORD_RESET => $this->getResetSuccessResponse($response),
            default => $this->getResetFailureResponse($request, $response),
        };
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function getResetValidationRules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Get the password reset validation messages.
     *
     * @return array
     */
    protected function getResetValidationMessages(): array
    {
        return [];
    }

    /**
     * Get the password reset validation custom attributes.
     *
     * @return array
     */
    protected function getResetValidationCustomAttributes(): array
    {
        return [];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  Request  $request
     * @return array
     */
    protected function getResetCredentials(Request $request): array
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  CanResetPassword  $user
     * @param  string  $password
     * @return JsonResponse
     */
    protected function resetPassword(CanResetPassword $user, string $password): JsonResponse
    {
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string  $response
     * @return Response
     */
    protected function getResetSuccessResponse(string $response): Response
    {
        return response()->json(['success' => true]);
    }

    /**
     * Get the response for after a failing password reset.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return Response
     */
    protected function getResetFailureResponse(Request $request, string $response): Response
    {
        return response()->json(['success' => false]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        $passwordBrokerManager = new PasswordBrokerManager(app());
        return $passwordBrokerManager->broker();
    }
}
