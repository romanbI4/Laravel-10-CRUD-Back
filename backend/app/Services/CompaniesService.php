<?php

namespace App\Services;

use App\Repositories\CompaniesRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CompaniesService
{
    private CompaniesRepository $companiesRepository;

    public function __construct(CompaniesRepository $companiesRepository)
    {
        $this->companiesRepository = $companiesRepository;
    }

    /**
     * @return Collection
     */
    public function getList(): Collection
    {
        return $this->companiesRepository->getList();
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function create(Request $request): mixed
    {
        $company = $request->only(['user_id', 'title', 'phone', 'description']);

        return $this->companiesRepository->create($company);
    }

    /**
     * @param  string  $column
     * @param  string  $params
     * @return mixed
     */
    public function getOneByParams(string $column, string $params): mixed
    {
        return $this->companiesRepository->getOneByParams($column, $params);
    }

    /**
     * @param  int  $id
     * @param  array  $params
     * @return mixed
     */
    public function updateOneByParams(int $id, array $params): mixed
    {
        return $this->companiesRepository->updateOneByParams($id, $params);
    }

    /**
     * @param  int  $id
     * @return int
     */
    public function destroy(int $id): int
    {
        return $this->companiesRepository->destroy($id);
    }

}
