<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Imports\ImportScheduleList;
use App\Models\Region\Schedule;
use Maatwebsite\Excel\Facades\Excel;

class DependencyController extends Controller
{
    
    public function index(){
        
        try {
            return Inertia::render('SuperAdmin/Dependency');
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }
    
    public function schedules(){
        
        try {
            $data = Schedule::where('region_pid',getRegionPid())->paginate(20);
            return Inertia::render('Region/Schedule', ['data' => $data]);
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }

    public function scheduleList(){
        
        try {
            $data = Schedule::where('region_pid',getRegionPid())->limit(50)->get();
           return pushData($data);
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }

    public function uploadSchedule(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new ImportScheduleList, $request->file('file'));
            return back()->with('message', 'File imported successfully!');
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return back()->with('error', 'Failed to import file!');
        }
    }
}
