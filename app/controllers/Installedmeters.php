<?php
  class Installedmeters extends Controller{
    public function __construct(){
      !isLoggedIn() ? redirect('pages') : '';
      $this->meterModel=$this->model('Meter');
    }
    // load installed customers page
    public function index(){
      $data=$this->meterModel->installedCustomer();
        $this->view('meters/installed',$data);
    }

    public function GetRange(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
          'from'=>escapeString($_POST['from']),
          'to'=>escapeString($_POST['to'])
        ];
      }
     $data=$this->meterModel->findInstalledCustomerByDateRange($data);
      $this->view('meters/installed',$data);
    }
    public function column(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
          'num'=>escapeString($_POST['day']),
          'to'=>escapeString($_POST['criteria'])
        ];
      }
      $data=$this->meterModel->findInstalledCustomerByColumn($data);
      $this->view('meters/installed',$data);
    }
    public function companyrange(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
          'company'=>escapeString($_POST['company']),
          'from'=>escapeString($_POST['from']),
          'to'=>escapeString($_POST['to'])
        ];
      }
      $data=$this->meterModel->companyrByDateRange($data);
      $this->view('meters/installed',$data);
    }
    public function justcompany(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
      }
      $data=$this->meterModel->bycompany(escapeString($_POST['company']));
      $this->view('meters/installed',$data);
    }
    function findBynumber(){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $num =escapeString($_POST['num']);
        if(!empty($num)){
            $num=$this->meterModel->findnum($num);
            if(!empty($num)){
                $data='<ul class="list-unstyled">';
                foreach ($num as $r) {
                $data.="<a href='". URLROOT."/Installedmeters/fetchSingle/".$r->id."'><li class = 'list-group-item pointer' >".ucwords($r->cust_names). "</li></a>";
                }
                $data.='</ul>';
            }
        }else {
            $data="Empty Result set";
        }
        // echo var_dump($data);
        echo jsonDecode($data);
    }
    public function fetchSingle($id=0){
      $_SESSION['search']=true;
      if(is_numeric($id) and $id>0){
      $id = floor($id);
      $data=$this->meterModel->findId($id);
      $this->view('meters/installed',$data);
      }else {
        // code...
        echo "nopage";
      }
    }
  }
