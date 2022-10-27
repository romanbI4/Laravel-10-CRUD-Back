<?php

namespace Tests\Http\Traits;

use Tests\TestCase;

class ResetsPasswordsTest extends TestCase
{
    /**
     * A test Send Reset Link Email.
     *
     * @return void
     */
    public function testSendResetLinkEmail()
    {
        $user = [
            "email" => "vdov.romanoff_test1112345@gmail.com",
        ];

        $response = $this->json(
            'POST',
            'api/user/recover-password/link',
            $user
        );

        $response->assertResponseStatus(200);
    }

    /**
     * A test Reset Password.
     *
     * @return void
     */
    public function testReset()
    {
        $user = [
            "email" => "vdov.romanoff_test1112345@gmail.com",
            "password" => "123456",
            "password_confirmation" => "123456",
            "token" => "519d6af34941d52f97ebf9c3d18ee05f467c1cffa9e5b07b8467885b0d5d70fa"
        ];

        $response = $this->json(
            'POST',
            'api/user/recover-password/submit',
            $user
        );

        $response->assertResponseStatus(200);
    }

}
