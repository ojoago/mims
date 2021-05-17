<?php
    class Views extends Controller{
        public function __construct(){
          !isLoggedIn() ? redirect('pages') : '';
           $this->viewModel=$this->model('view');
        }

        public function index(){
            $info= $this->viewModel->viewCompleteInfo();
            $data = ['info'=>$info];
            $this->view('view/index', $data);
        }
        public function meter(){
            $meters= $this->viewModel->viewMeter();
            $data = ['meter'=>$meters];
            $this->view('view/meters', $data);
        }
        public function edat(){
            $edat= $this->viewModel->viewEdat();
            $data = ['edat'=>$edat];
            $this->view('view/edats', $data);
        }
        public function customer(){
            $cust= $this->viewModel->viewCustomer();
            $data = ['cust'=>$cust,'title'=>'welcome to about','description'=>'map project backend software'];
            $this->view('view/customers', $data);
        }
        public function paidcustomer(){
            $cust= $this->viewModel->viewCustomer();
            $data = ['cust'=>$cust,'title'=>'welcome to about','description'=>'map project backend software'];
            $this->view('view/readycustomer', $data);
        }

    }
