<?php

namespace App\Http\Controllers\v1;

use App\DTO\CompanyDto;
use App\Exceptions\PermissionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Utils\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $companies = $request->user()->companies;

        return CompanyResource::collection($companies);
    }

    /**
     * @param CompanyRequest $request
     * @return CompanyResource
     */
    public function store(CompanyRequest $request): CompanyResource
    {
        $companyDto = CompanyDto::fromRequest($request);

        return new CompanyResource(Company::create($companyDto->toArray()));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return CompanyResource|JsonResponse
     * @throws PermissionException
     */
    public function show(int $id, Request $request): CompanyResource|JsonResponse
    {
        $company = Company::findOrFail($id);

        $user = $request->user();

        if (Permission::available('view', $user, $company)) {
            return new CompanyResource($company);
        } else {
            throw new PermissionException();
        }
    }

    /**
     * @param int $id
     * @param CompanyRequest $request
     * @return CompanyResource|JsonResponse
     * @throws PermissionException
     */
    public function edit(int $id, CompanyRequest $request): CompanyResource|JsonResponse
    {
        $companyDto = CompanyDto::fromRequest($request);

        $company = Company::findOrFail($id);

        $user = $request->user();

        if (Permission::available('update', $user, $company)) {
            $company->update($companyDto->toArray());

            return new CompanyResource($company);
        } else {
            throw new PermissionException();
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws PermissionException
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        $company = Company::findOrFail($id);

        $user = $request->user();

        if (Permission::available('delete', $user, $company)) {
            $company->delete();

            return response()->json([], 204);
        } else {
            throw new PermissionException();
        }
    }

}
