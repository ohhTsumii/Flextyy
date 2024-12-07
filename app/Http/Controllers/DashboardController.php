<?php

namespace App\Http\Controllers;

use App\Models\GlassFactory;
use App\Models\Inspection;
use App\Models\RecyclePlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function getInspections(): \Illuminate\Http\JsonResponse
    {
        // Use query builder to join the tables
        $data = DB::table('inspections')
            // Join table_a with inspections on table_a_id
            ->join('glass_factories', 'inspections.glassfactory', '=', 'glass_factories.id')
            // Join table_b with inspections on table_b_id
            ->join('recycle_plants', 'inspections.recycleplant', '=', 'recycle_plants.id')
            // Select the columns you want, including columns from both table_a and table_b
            ->select(
                'inspections.*',
                'glass_factories.company as glass_factory_company', // Alias for company from glass_factories
                'recycle_plants.company as recycle_plant_company' // Alias for company from recycle_plants
            )
            ->get();

        return response()->json($data);
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

    public function index(Request $request): \Inertia\Response
    {
        // Extract ID from the query string
        $id = $request->query('id', null); // Fallback to `null` if not provided.

        if ($id) {
            $cleanedId = trim($id, '='); // Trim trailing '=' if it exists
        } else {
            $cleanedId = null;
        }

        return Inertia::render('Inputresult', [
            'id' => $cleanedId // Pass the ID to your Vue front-end through props
        ]);
    }

}
