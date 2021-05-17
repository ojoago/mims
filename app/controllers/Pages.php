<?php
    class Pages extends Controller{
        public function __construct(){
           
        }
       
        public function index(){
    
           $data = ['title'=>'MAP','description'=>'t7 map system'];
           $this->view('pages/index', $data);
        }
        public function about(){
            $data = ['title'=>'welcome to about','description'=>'map project backend software'];
            $this->view('pages/about', $data);
        }
    }