<?php
  /**
   *
   */
  class Dashboards extends Controller{
    public function __construct(){
        isLoggedIn() ?: redirect('pages');
        $this->loadModel=$this->model('Dashboard');
      }
    public function index(){
      $data['company']=$this->loadModel->companyInstallation();
      $data['companyTypeStatus']=$this->loadModel->companyTypeStatus();
      $data['region']=$this->loadModel->region();
      $data['meterNoEdat']=$this->loadModel->meterNoEdat();
      $data['meterStatus']=$this->loadModel->meterStatus();
      $data['meterTech']=$this->loadModel->meterTech();
      $data['invent']=$this->loadModel->inventory();
      $data['srin']=$this->loadModel->srin();
      $data['srcn']=$this->loadModel->srcn();
      $data['regionTypeStatus']=$this->loadModel->regionTypeStatus();
      $data['groupSchedulByEdat']=$this->loadModel->groupSchedulByEdat();
      $data['inOut']=$this->loadModel->inOut();
      $data['lineChartDaily']=$this->loadModel->lineChartDaily();
      $data['lineChartMonth']=$this->loadModel->lineChartMonth();
      $this->view('admin/dashboard',$data);
    }
    public function conditional(){
      $_SESSION['search']=true;
      if($_SERVER['REQUEST_METHOD']=='POST'){
         $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
         $data=[
           'from'=>escapeString($_POST['from']),
           'to'=>escapeString($_POST['to'])
         ];
           // if(empty($date['from']) or empty($date['to'])){
           //   flash('register_success','Select Date range','alert alert-danger');
           //   $this->index();
           //   exit;
           // }else{
             $data['company']=$this->loadModel->companyInstallation($data);
             $data['companyTypeStatus']=$this->loadModel->companyTypeStatus($data);
             $data['region']=$this->loadModel->region($data);
             $data['meterNoEdat']=$this->loadModel->meterNoEdat($data);
             $data['meterStatus']=$this->loadModel->meterStatus($data);
             $data['meterTech']=$this->loadModel->meterTech($data);
             $data['invent']=$this->loadModel->inventory();
             $data['srin']=$this->loadModel->srin($data);
             $data['srcn']=$this->loadModel->srcn($data);
             $data['regionTypeStatus']=$this->loadModel->regionTypeStatus($data);
             $data['groupSchedulByEdat']=$this->loadModel->groupSchedulByEdat($data);
             $data['inOut']=$this->loadModel->inOut($data);
           // }
         }
         $this->view('admin/dashboard',$data);
       }


    public function dashboard($param=''){
      if(empty($param)){
          $data=$this->customerModel->loaddashboard();
      }else {
        // code...
      }
        $this->view('admin/dashboard',$data);
    }
  }
