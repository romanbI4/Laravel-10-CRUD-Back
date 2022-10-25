<?php

namespace App\Repositories;

use App\Interfaces\CompaniesRepositoryInterface;
use App\Models\Companies;
use Illuminate\Database\Eloquent\Collection;

class CompaniesRepository implements CompaniesRepositoryInterface
{
    public function getList(): Collection
    {
        return Companies::all();
    }

    public function create(array $details)
    {
        return Companies::create($details);
    }

    public function getOneByParams($column, $params)
    {
        return Companies::where($column, $params)->first();
    }

    public function updateOneByParams($id, $params)
    {
        return Companies::whereId($id)->update($params);
    }

    public function destroy($id): int
    {
        return Companies::destroy($id);
    }
}
