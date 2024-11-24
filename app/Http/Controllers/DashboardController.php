<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getInspections()
    {
        //get inspections
        $data = DB::table('inspections')
//            ->where('votes', '>', 100)
//            ->sharedLock()
            ->get();

        return response()->json($data);
    }
}
