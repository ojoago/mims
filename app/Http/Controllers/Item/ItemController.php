<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Models\Inventory\Item;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    //


    public function loadItemNames()
    {

        try {
            $data = Item::get();
            return pushData($data, 'Item name Loaded');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function createItemName(Request $request){

        $validator =  Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'unit' => 'required|string',
        ]);



        if (!$validator->fails()) {
            try {
                $data  = [
                    'name' => $request->name ,
                    'description' => $request->description ,
                    'unit' => $request->unit ,
                    'pid' => $request->pid ?? public_id(),
                    'creator' => getUserPid(),
                ];
                $result = $this->addOrEditItemName($data);
                return pushResponse($result, $request->pid ? 'Item name updated' :"Item name added");
            } catch (\Throwable $e) {
                logError($e->getMessage());
                return responseMessage(status: 204, data: [], msg: STS_500);
            }
        }
        return responseMessage(data: $validator->errors()->toArray(), status: 422, msg: STS_422);

    }

    private function addOrEditItemName(array $data){
        try {
            return Item::updateOrCreate(['pid' => $data['pid']],$data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

}
