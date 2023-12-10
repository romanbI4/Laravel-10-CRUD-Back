<?php

namespace App\DTO;

use App\Http\Requests\RegistrationRequest;

class RegistrationDto
{
    public string $firstName;
    public string $lastName;
    public string $password;
    public string $email;
    public string $phone;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return void
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return void
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

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
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param RegistrationRequest $request
     * @return RegistrationDto
     */
    public static function fromRequest(RegistrationRequest $request): RegistrationDto
    {
        $dto = new self();

        $dto->setFirstName($request->input('first_name'));
        $dto->setLastName($request->input('last_name'));
        $dto->setEmail($request->input('email'));
        $dto->setPhone($request->input('phone'));
        $dto->setPassword($request->input('password'));

        return $dto;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'phone' => $this->getPhone()
        ];
    }
}
