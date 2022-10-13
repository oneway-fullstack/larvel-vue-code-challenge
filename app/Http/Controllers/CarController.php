<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Resources\Car as CarResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Return a list of all cars.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $cars = Car::all();

        return response()->json(CarResource::collection($cars), 200);
    }

    /**
     * Return a single car.
     *
     * @param Car $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Car $car): JsonResponse
    {
        return response()->json(new CarResource($car), 200);
    }

    /**
     * Store an car.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $car = Car::create($request->all());

        return response()->json($car, 201);
    }

    /**
     * Update an car.
     *
     * @param Request $request
     * @param Car $car
     * @return JsonResponse
     */
    public function update(Request $request, Car $car): JsonResponse
    {
        $car->update($request->all());

        return response()->json($car, 200);
    }

    /**
     * Delete an car.
     *
     * @param Car $car
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Car $car): JsonResponse
    {
        $car->delete();

        return response()->json(null, 204);
    }
}
