<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DependencyController extends Controller
{
    
    public function index(){
        
        try {
            return Inertia::render('SuperAdmin/Dependency');
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }
}
