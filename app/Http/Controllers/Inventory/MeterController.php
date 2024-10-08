<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Imports\ImportMeterList;
use App\Models\Inventory\MeterList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class MeterController extends Controller
{
    // names of t7 item
    public function index(){
        try {
            $data = MeterList::paginate(20);
            return Inertia::render('Inventory/MeterList',['data' => $data]);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return pushData([],ERR_EMT);
        }
    }

  
    public function addMeterList(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new ImportMeterList,$request->file('file'));
            return back()->with('message', 'File imported successfully!');
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return back()->with('error', 'Failed to import file!');
        }
    }
}
