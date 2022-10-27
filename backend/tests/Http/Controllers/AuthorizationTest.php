<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * A test registration.
     *
     * @return void
     */
    public function test_registration(): void
    {
        $user = [
            "first_name" => "111",
            "last_name" => "222",
            "email" => "test@gmail.com",
            "password" => "555",
            "phone" => "0668888888"
        ];

        $response = $this->json(
            'POST',
            'api/user/register',
            $user
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }

    /**
     * A test login.
     *
     * @return void
     */
    public function test_login(): void
    {
        $user = [
            "email" => "test@gmail.com",
            "password" => "555",
        ];

        $response = $this->json(
            'POST',
            'api/user/sign-in',
            $user
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }
}
