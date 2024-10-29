<?php

namespace App\Http\Controllers;

use App\Models\Region\Region;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

   public function managementDashboard(){
        $data = $this->loadRegions();
        return Inertia::render('ManagementDashboard' ,['data' => $data]);
    }

    public function adminDashboard(){
        $data = $this->loadRegions();
        return Inertia::render('AdminDashboard', ['data' => $data]);
    }

    public function loginRegion(Request $request){
        loadActiveRegion($request->region);
        // return Inertia::render('Dashboard');
        return redirect()->intended(route('dashboard', absolute: false));
    }
    public function logOutRegion(){
        setRegionPid();
        setRegionName();

        if (auth()->user()->hasRole('super admin')) {
            // The user has the 'writer' role
            return redirect()->route('admin.dashboard')->with('success','Welcome back');
        }

        return redirect()->intended(route('management.dashboard', absolute: false));
    }

    private function loadRegions(){
        try {
            // setRegionPid() ;
            return Region::get();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }

}
