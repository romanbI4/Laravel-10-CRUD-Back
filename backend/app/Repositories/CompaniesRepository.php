<?php

namespace App\Repositories;

use App\Interfaces\CompaniesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CompaniesRepository implements CompaniesRepositoryInterface
{
    public function getList(): Collection
    {
        return Auth::user()->companies;
    }

    public function create(array $details)
    {
        return Auth::user()->companies()->create($details);
    }

    public function getOneByParams($column, $params)
    {
        return Auth::user()->companies->where($column, $params)->first();
    }

    public function updateOneByParams($id, $params)
    {
        return Auth::user()->companies()->update($params);
    }

    public function destroy($id): int
    {
        return Auth::user()->companies->first()->destroy($id);
    }
}
