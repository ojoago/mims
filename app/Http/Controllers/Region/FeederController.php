<?php

namespace App\Http\Controllers\Region;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Feeder\Feeder33;
use Illuminate\Support\Facades\Validator;

class FeederController extends Controller
{
    //

    public function index(){

        return Inertia::render('SuperAdmin/Feeders');

    }

    
    public function load33kvFeeder(){

        try {
            $data = Feeder33::get();
            return pushData($data, '33 kv feeders loaded');
        } catch (\Throwable $th) {
            //throw $th;
        }

    }


    public function create33kvFeeder(Request $request){

        $validator =  Validator::make($request->all(), [
            'state' => 'required|string',
            'region' => 'required|string',
            'feeder.*.name' => 'required|string',
        ]);

        if (!$validator->fails()) {
            try {
              $result = false;
                $count = count($request->feeder);
                if ($count > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $data  = [
                            'name' => $request->feeder[$i]['name'],
                            'pid' => public_id(),
                            'creator' => getUserPid(),
                            'region_pid' => $request->region,
                        ];
                        logError($data);
                        $result = $this->addOrEditRegion($data);
                    }
                }
                return pushResponse($result, "Feeder(s) Added");
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return responseMessage(status: 204, data: [], msg: STS_500);
            }
        }
        return responseMessage(data: $validator->errors()->toArray(), status: 422, msg: STS_422);
    }


    private function addOrEditRegion(array $data){
        try {
            return Feeder33::updateOrCreate(['pid' => $data['pid']], $data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

}
