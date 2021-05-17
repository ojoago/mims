<?php
  class Admins extends Controller{
    public function __construct(){
      isLoggedIn() ?: redirect('pages');
      $this->loadModel=$this->model('Admin');
      // get installation company id
    }
    public function index(){
      redirectAccess('home');// redirect if access not granted
      $data=[
        'company'=>$this->loadModel->countCompany(),
        'paidcustomer'=>$this->loadModel->countPaidCustomer(),
        'monthSummary'=>$this->loadModel->countInstalledByCompanies(),
        'installedmeters'=>$this->loadModel->countCustomerByStatus('installed'),
        'metersWithoutEdat'=>$this->loadModel->CountMetersWithoutEdat('not install'),
        'edatAsigned'=>$this->loadModel->countAsignedEdat(),
        'instlledEdats'=>$this->loadModel->countEdatByStatus('installed'),
        'notinstlledEdats'=>$this->loadModel->countEdatByStatus('not install'),
        'faultyMeters'=>$this->loadModel->countMeterByStatus('faulty'),
        'asignedFaultyEdats'=>$this->loadModel->countEdatByStatus('faulty'),
        'fixedfaultyMeter'=>$this->loadModel->countMeterByStatus('fixed'),
        'fixedFaultyEdat'=>$this->loadModel->countEdatByStatus('fixed')
      ];
      $this->view('admin/index',$data);
    }
    public function staff(){
      $data['companyName']=$this->companyName;
      $data['data']=$this->loadModel->staffDetails($this->cmp);
      $this->view('admin/staff',$data);
    }
    // view asigned meters
    public function noedat(){
      $data['msg']='meters without edat';
      $data['cust']=$this->loadModel->viewNoEdat();
      $data['baseUrl']="/admins";
      $this->view('company/meters',$data);
    }
    // all edats
    public function alledats(){
      $data['cust']=$this->loadModel->asignedEdat();
      $data['msg']='Edat(s)';
      $data['baseUrl']='/admins';
      $this->view('company/edats',$data);
    }
    // all customers
    public function paid(){
      $data['cust']=$this->loadModel->meters();
      $data['baseUrl']="/admins";
      $data['companyName'] ='Schedules';
      // $data['msg']=''
      $this->view('company/meters',$data);
    }
    // installed customers
    public function installedmeters(){
      $data['cust']=$this->loadModel->meters('installed');
      $data['baseUrl']="/admins";
      $this->view('company/meters',$data);
    }
    // faulty meters
    public function asignedfaultymeters(){
      $data['baseUrl']="/admins";
      $data['cust']=$this->loadModel->meters('faulty');
      $this->view('company/meters',$data);
    }
    // fixed faulty meters
    public function fixedfaultyMeter(){
      $data['baseUrl']="/admins";
      $data['cust']=$this->loadModel->meters('fixed');
      $this->view('company/meters',$data);
    }
    // meter stop here

    // edats start here
    public function edats(){
      $data['companyName']=$this->companyName;
      $data['baseUrl']="/admins";
      $data['cust']=$this->loadModel->asignedEdat($this->cmp);
      $this->view('company/edats',$data);
    }
    // installed edats
    public function installededats(){
      $data['baseUrl']="/admins";
      $data['cust']=$this->loadModel->fetchEdats('installed');
      $this->view('company/edats',$data);
    }
    // faulty edats
    public function asignedfaultyedats(){
      $data['baseUrl']="/admins";
      $data['cust']=$this->loadModel->fetchEdats('faulty');
      $this->view('company/edats',$data);
    }
    // fix faulty edats
    public function fixedFaultyEdat(){
      $data['baseUrl']="/admins";
      $data['cust']=$this->loadModel->fetchEdats('fixed');
      $this->view('company/edats',$data);
    }

    // edat stop here
    public function installer(){
        $this->view('admin/installer',$data);
    }
    function updatelevel(){
      parse_str($_POST['form'],$_POST);
      $group=[
        'group'=>escapeString($_POST['group']),
        'id'=>escapeString($_POST['userId'])
      ];
      $this->userModel=$this->model('User');
       if($this->userModel->updateGroup($group)){
         reportLog(UID().' updated user group',$group['id']);
         $msg = 'success';
       }else{
        $msg = 'update failed';
       }
       echo $msg;
    }
    function updateTeam(){
      parse_str($_POST['form'],$_POST);
      $team=[
        'team'=>escapeString($_POST['team']),
        'id'=>escapeString($_POST['userId'])
      ];
      $this->userModel=$this->model('User');
      if($this->loadModel->updateTeam($team)){
        reportLog(UID().' updated user Team',$team['id']);
        $msg = 'success';
      }else{
        $msg="Update failed";
      }
      echo $msg;
    }
    function updateStatus(){
      parse_str($_POST['form'],$_POST);
      $status=[
        'status'=>escapeString($_POST['status']),
        'id'=>escapeString($_POST['userId'])
      ];
      $this->userModel=$this->model('User');
      if($this->userModel->userStatus($status)){
        $data['status']=($data['status']=='guest') ? 'deactivated' : 'activated';
        reportLog(UID().' '.$data['status'].' '.idToName($data['id'])."'s account ",$data['id']);
        $msg = 'success!';
        // send mail
        // sendMail(idToMail($data['id']),'Your account has been '.$data['status']);
      }else{
        $msg="Update failed";
      }
      echo $msg;
    }



}
