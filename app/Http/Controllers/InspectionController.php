<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteInspectionRequest;
use App\Http\Requests\InitialInspectionRequest;
use App\Http\Requests\InspectionResultsRequest;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
    public function excelTest(InspectionResultsRequest $request): BinaryFileResponse|\Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();




        return response()->json([
            'success' => true,
            'data' => $validatedData,
            'message' => 'Post successfully created!'
        ]);



//        $filePath = base_path('test.xlsm');
//        $modifiedPath = base_path('modified_test.xlsm');
//
//        try {
//            Log::info('Starting Excel test process');
//
//            // Check if original file exists
//            if (!file_exists($filePath)) {
//                Log::error('Original file not found at: ' . $filePath);
//                return response()->json(['error' => true, 'message' => 'Original file not found']);
//            }
//
//            Log::info('Loading the spreadsheet');
//            $spreadsheet = IOFactory::load($filePath);
//            $sheet = $spreadsheet->getActiveSheet();
//
//            Log::info('Setting cell A5 to new value');
//            $sheet->setCellValue('S28', '10');
//
//            Log::info('Saving the file');
//            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//            $writer->save($modifiedPath);
//
//            if (!file_exists($modifiedPath)) {
//                Log::error('Failed to save the modified file at: ' . $modifiedPath);
//                return response()->json(['error' => true, 'message' => 'Failed to save the modified file']);
//            }
//
//            Log::info('Serving the file download');
//            return response()->file($modifiedPath, [
//                'Content-Type' => 'application/vnd.ms-excel',
//                'Content-Disposition' => 'attachment; filename="modified_test.xlsm"'
//            ])->deleteFileAfterSend(true);
//
//        } catch (\Exception $e) {
//            Log::error('Exception occurred', ['exception' => $e]);
//            return response()->json([
//                'error' => true,
//                'message' => $e->getMessage()
//            ], 500);
//        }

//                    return response()->json([
//                'error' => true,
//                'message' => $e->getMessage()
//            ], 500);
    }

}
