<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropDownController extends Controller
{
    //

    // load regions 
    public function loadStateRegion()
    {
        try {
            $result = DB::table('regions')->distinct('state')
                ->get(['state as id', 'state as text']); //
            return responseMessage(status: 200, data: $result, msg: 'data loaded');
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }
    // load regions 
    public function loadRegions($state)
    {
        try {
            $result = DB::table('regions')->where('state',$state)
                ->get(['pid as id', 'region as text']); //
            return responseMessage(status: 200, data: $result, msg: 'data loaded');
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }
   
    // load regions 
    public function loadRegionsAdmin()
    {
        try {
            $result = DB::table('regions')
                ->get(['pid as id', 'region as text']); //
            return responseMessage(status: 200, data: $result, msg: 'data loaded');
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
    }

    // load regions 
    public function loadRegion33KvFeeder($region)
    {
        try {
            $result = DB::table('feeder33s')->where('region_pid', $region)
                ->get(['pid as id', 'name as text']); //
            return responseMessage(status: 200, data: $result, msg: 'data loaded');
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return response()->json([]);
        }
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
