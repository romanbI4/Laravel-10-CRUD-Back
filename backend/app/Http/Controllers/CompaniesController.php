<?php

namespace App\Http\Controllers;

use App\Services\CompaniesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function auth;

class CompaniesController extends Controller
{
    private CompaniesService $companiesService;

    public function __construct(CompaniesService $companiesService)
    {
        $this->companiesService = $companiesService;
    }

    public function index(): JsonResponse
    {
        return response()
            ->json([
                'status' => 'success',
                'data' => $this->companiesService->getList()
            ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->merge(['user_id' => auth()->user()->getId()]);

        $this->validate($request, [
            'title' => 'required|string|max:50',
            'phone' => 'required|unique:companies,phone|string|digits:10',
            'description' => 'required|string|max:255'
        ]);

        return response()
            ->json([
                'status' => 'success',
                'data' => $this->companiesService->create($request)
            ]);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()
            ->json([
                'status' => 'success',
                'data' => $this->companiesService->getOneByParams('id', $id)
            ]);
    }

    /**
     * @param  int  $id
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $request->merge(['user_id' => auth()->user()->getId()]);

        $this->validate($request, [
            'title' => 'required|string|max:50',
            'phone' => 'required|unique:companies,phone|string|digits:10',
            'description' => 'required|string|max:255'
        ]);

        $response = $this->companiesService->updateOneByParams($id, $request->toArray());

        if ($response) {
            return response()
                ->json([
                    'status' => 'success',
                ]);
        } else {
            return response()
                ->json([
                    'status' => 'error',
                ]);
        }
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $response = $this->companiesService->destroy($id);

        if ($response) {
            return response()
                ->json([
                    'status' => 'success'
                ]);
        } else {
            return response()
                ->json([
                    'status' => 'error'
                ]);
        }
    }
}
