<?php

namespace App\DTO;

use App\Http\Requests\CompanyRequest;

class CompanyDto
{
    public string $title;
    public string $description;
    public string $phone;
    public int $userId;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param CompanyRequest $request
     * @return CompanyDto
     */
    public static function fromRequest(CompanyRequest $request): CompanyDto
    {
        $dto = new self();

        $dto->setTitle($request->input('title'));
        $dto->setDescription($request->input('description'));
        $dto->setPhone($request->input('phone'));
        $dto->setUserId($request->user()->id);

        return $dto;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'phone' => $this->getPhone(),
            'user_id' => $this->getUserId(),
        ];
    }
}
