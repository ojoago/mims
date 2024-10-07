<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropDownController extends Controller
{
    //

    // load regions 
    public function loadRegions(Request $request)
    {
        $result = DB::table('regions')
            ->get(['pid as id', 'name']); //
    }



    public function loadStates()
    {
        try {
            $data = DB::table('states')->select('id', 'state as text')->get();
            return responseMessage(status: 200, data: $data, msg: 'data loaded');

            return response()->json($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }
    public function loadStateLga($id)
    {
        try {
            $data = DB::table('state_lgas')->where('state_id', $id)->select('id', 'lga as text')->get();
            return responseMessage(status: 200, data: $data, msg: 'data loaded');

            return response()->json($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }

}
