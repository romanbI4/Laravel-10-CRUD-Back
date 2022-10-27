<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;

class CompaniesCrudTest extends TestCase
{
    public function getToken()
    {
        $user = [
            "email" => "test@gmail.com",
            "password" => "555",
        ];

        $auth = $this->json(
            'POST',
            'api/user/sign-in',
            $user
        );

        return $auth->response->json()['api_token'];
    }

    public function testShow()
    {
        $response = $this->json(
            'GET',
            'api/user/companies/20',
            [],
            ['token' => $this->getToken()]
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }

    public function testUpdate()
    {
        $company = [
            "title" => "sad",
            "phone" => "0666888881",
            "description" => "123456"
        ];

        $response = $this->json(
            'PUT',
            'api/user/companies/20',
            $company,
            ['token' => $this->getToken()]
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }

    public function testStore()
    {
        $company = [
            "title" => "sad",
            "phone" => "0666888888",
            "description" => "123456"
        ];

        $response = $this->json(
            'POST',
            'api/user/companies',
            $company,
            ['token' => $this->getToken()]
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }

    public function testIndex()
    {
        $response = $this->json(
            'GET',
            'api/user/companies',
            [],
            ['token' => $this->getToken()]
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }

    public function testDestroy()
    {
        $response = $this->json(
            'DELETE',
            'api/user/companies/20',
            [],
            ['token' => $this->getToken()]
        );

        $response->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }
}
