<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteInspectionRequest;
use App\Http\Requests\InitialInspectionRequest;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    // Handle POST request to store a new post
    public function store(InitialInspectionRequest $request): \Illuminate\Http\JsonResponse
    {
        // The request is already validated at this point
        // Access the validated data like this
        $validatedData = $request->validated();

        // Handle the validated data (e.g., save to database)

        Inspection::createInspection($validatedData);

        // For demonstration, return a JSON response with the validated data
        return response()->json([
            'success' => true,
            'data' => $validatedData,
            'message' => 'Post successfully created!'
        ]);
    }

    // Handle POST request to store a new post
    public function delete(DeleteInspectionRequest $request): \Illuminate\Http\JsonResponse
    {
        // The request is already validated at this point
        // Access the validated data like this
        $validatedData = $request->validated();

        // Handle the validated data (e.g., save to database)

        Inspection::deleteInspection($validatedData['id']);

        // For demonstration, return a JSON response with the validated data
        return response()->json([
            'success' => true,
            'data' => $validatedData,
            'message' => 'Post successfully created!'
        ]);
    }

    public function update(InitialInspectionRequest $request): \Illuminate\Http\JsonResponse
    {
        // The request is already validated at this point
        // Access the validated data like this
        $validatedData = $request->validated();

        // Handle the validated data (e.g., save to database)

        Inspection::updateInspection($validatedData['id'],$validatedData);

        // For demonstration, return a JSON response with the validated data
        return response()->json([
            'success' => true,
            'data' => $validatedData,
            'message' => 'Post successfully created!'
        ]);
    }
}
