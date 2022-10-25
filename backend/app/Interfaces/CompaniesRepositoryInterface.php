<?php

namespace App\Interfaces;

interface CompaniesRepositoryInterface
{
    public function create(array $details);

    public function getOneByParams($column, $params);

    public function updateOneByParams($id, $params);

    public function destroy($id);

    public function getList();
}
