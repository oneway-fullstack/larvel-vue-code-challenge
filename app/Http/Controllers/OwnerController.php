<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Http\Resources\Owner as OwnerResource;
use App\Http\Resources\OwnerView as OwnerViewResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    /**
     * Return a list of all owners.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $owners = Owner::all();

        return response()->json(OwnerResource::collection($owners), 200);
    }

    /**
     * Return a single owner.
     *
     * @param Owner $owner
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Owner $owner): JsonResponse
    {
        return response()->json(new OwnerViewResource($owner), 200);
    }

    /**
     * Store an owner.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $owner = Owner::create($request->all());

        return response()->json($owner, 201);
    }

    /**
     * Update an owner.
     *
     * @param Request $request
     * @param Owner $owner
     * @return JsonResponse
     */
    public function update(Request $request, Owner $owner): JsonResponse
    {
        $owner->update($request->all());

        return response()->json($owner, 200);
    }

    /**
     * Delete an owner.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Owner $owner): JsonResponse
    {
        $owner->delete();

        return response()->json(null, 204);
    }
}
