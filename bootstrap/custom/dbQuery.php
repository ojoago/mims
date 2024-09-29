<?php 

use Illuminate\Support\Facades\DB;

    function getDepartment($user_pid){
        try {
            return DB::table('staff')->where('user_pid',$user_pid)->pluck('department_pid')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function loadAllEmails(){
        try {
            return DB::table('users as u')->join('staff as s','s.user_pid','u.pid')->where('u.status',1)->pluck('u.email')->all();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    function loadAllStaffEmails(){
        try {
            return DB::table('users as u')->join('staff as s','s.user_pid','u.pid')->where('u.status',1)->select('u.email','u.pid')->get();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function loadEmailsByPids($pids){
        try {
            return DB::table('users')->where('status',1)->whereIn('pid',$pids)->pluck('email')->all();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    function loadEmailByDepartment($departments){
        try {
            return DB::table('users as u')->join('staff as s','u.pid','s.user_pid')->where('u.status',1)->whereIn('s.department_pid',$departments)->pluck('u.email')->all();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getDepartmentByPid($pid){
        try {
            return DB::table('departments')->where('pid', $pid)->pluck('department')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getSubDepartmentByPid($pid){
        try {
            return DB::table('sub_departments')->where('pid', $pid)->pluck('name')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getEmailByPid($pid){
        try {
            return DB::table('users')->where('pid', $pid)->pluck('email')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getTravelRequestCreatorEmail($travel_pid){
        try {
            return DB::table('travel_requests as t')
                                ->join('users as u','t.user_pid','u.pid')
                                ->where('t.pid',$travel_pid)
                                ->first(['u.email', 't.title', 'destination']);
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function loadShiftDetail($shift_pid){
        try {
            return DB::table('shifts')
                                ->where('pid', $shift_pid)
                                ->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function staffHasRole($role='staff'){
        try {
            return DB::table('roles as r')->join('user_roles as ur','ur.role_id','r.id')->join('users as u','u.id','ur.user_id')->where(['u.pid' => getUserPid() , 'r.name' => $role])->exists();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }
    function staffRoles($id){
        try {
            return DB::table('roles as r')->join('user_roles as u','u.role_id','r.id')->where(['u.user_id' => $id])->where('name','<>','HOD')->orderBy('order')->pluck('name')->all();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }


    function getStaffLineManger($pid){
        try {
            return DB::table('staff as s')->join('departments as d','d.pid','s.department_pid')->where('s.user_pid',$pid)->pluck('head_pid')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function loadNextApprovalLevel($level){
        try {
            return DB::table('users')->where('approval_level',$level)->select('email')->get();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function leaveDays($pid){
        try {
            return DB::table('leaves')->where('pid',$pid)->pluck('days')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getStaffDepartment($pid){
        try {
            return DB::table('staff')->where('user_pid',$pid)->pluck('department_pid')->first();
            // return DB::table('leaves')->where('pid',$pid)->pluck('days')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }

    function getStaffByPid($pid){
        try {
            return DB::table('users as u')->join('vehicles as v','v.driver','u.pid')->where('v.pid',$pid)->pluck('u.username')->first();
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return false;
        }
    }