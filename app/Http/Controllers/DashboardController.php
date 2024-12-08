<?php

namespace App\Http\Controllers;

use App\Models\GlassFactory;
use App\Models\Inspection;
use App\Models\RecyclePlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function getInspections(): \Illuminate\Http\JsonResponse
    {
        // Fetch inspections with status 'open'
        $openInspections = DB::table('inspections')
            ->join('glass_factories', 'inspections.glassfactory', '=', 'glass_factories.id')
            ->join('recycle_plants', 'inspections.recycleplant', '=', 'recycle_plants.id')
            ->where('inspections.status', '=', 'open')
            ->select(
                'inspections.*',
                'glass_factories.company as glass_factory_company',
                'recycle_plants.company as recycle_plant_company'
            )
            ->get();

        // Fetch inspections with status 'closed'
        $closedInspections = DB::table('inspections')
            ->join('glass_factories', 'inspections.glassfactory', '=', 'glass_factories.id')
            ->join('recycle_plants', 'inspections.recycleplant', '=', 'recycle_plants.id')
            ->where('inspections.status', '=', 'closed')
            ->select(
                'inspections.*',
                'glass_factories.company as glass_factory_company',
                'recycle_plants.company as recycle_plant_company'
            )
            ->get();

        // Return both datasets in a JSON response
        return response()->json([
            'openInspections' => $openInspections,
            'closedInspections' => $closedInspections,
        ]);
    }


    public function getAllGlassFactory(): \Illuminate\Http\JsonResponse
    {
        // Use the Inspection model to fetch all data
        $data = GlassFactory::all();  // Model is queried here

        return response()->json($data);
    }

    public function getAllRecyclePlant(): \Illuminate\Http\JsonResponse
    {
        // Use the Inspection model to fetch all data
        $data = RecyclePlant::all();  // Model is queried here

        return response()->json($data);

    }

    public function getAllTestType(): \Illuminate\Http\JsonResponse
    {
        // Use the Inspection model to fetch all data
        $data = Testtype::all();  // Model is queried here

        return response()->json($data);

    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        // Extract full URL sent from the frontend
        $fullUrl = $request->input('url', '');

        // Parse the URL to extract the query string parameters
        $parsedUrl = parse_url($fullUrl);
        $queryString = $parsedUrl['query'] ?? '';

        // Extract 'id' from the query string
        parse_str($queryString, $queryParams);
        $id = $queryParams['id'] ?? null;

        if ($id) {
            $cleanedid = trim($id, '='); // Trim trailing '=' if it exists
        } else {
            $cleanedid = null;
        }

        return response()->json(['id' => $cleanedid]);
        }

}
