<?php

namespace App\DTO;

use App\Http\Requests\LoginRequest;

class LoginDto
{
    public string $password;
    public string $email;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param LoginRequest $request
     * @return LoginDto
     */
    public static function fromRequest(LoginRequest $request): LoginDto
    {
        $dto = new self();

        $dto->setEmail($request->input('email'));
        $dto->setPassword($request->input('password'));

        return $dto;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword()
        ];
    }
}
