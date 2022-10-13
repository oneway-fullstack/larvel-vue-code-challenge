<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\AddressView as AddressViewResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Return a list of all addresses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $addresses = Address::all();

        return response()->json(AddressResource::collection($addresses), 200);
    }

    /**
     * Return a single address.
     *
     * @param Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Address $address): JsonResponse
    {
        return response()->json(new AddressViewResource($address));
    }

    /**
     * Store an address.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $address = Address::create($request->all());

        return response()->json($address, 201);
    }

    /**
     * Update an address.
     *
     * @param Request $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        $address->update($request->all());

        return response()->json($address, 200);
    }

    /**
     * Delete an address.
     *
     * @param Address $address
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Address $address): JsonResponse
    {
        $address->delete();

        return response()->json(null, 204);
    }
}
