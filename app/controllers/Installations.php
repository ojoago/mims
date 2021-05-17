<?php
  class Installations extends Controller{
    public function __construct(){
      !isLoggedIn() ? redirect('pages') : '';
      $this->loadModel=$this->model('Installation');
    }
    public function index(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'companyid'=>$this->loadModel->getCompany()->cm_id,
        'staff'=>$this->loadModel->totalStaff($this->loadModel->getCompany()->cm_id),
        'metersAsigned'=>$this->loadModel->countAsignedMeters($this->loadModel->getCompany()->cm_id),
        'edatAsigned'=>$this->loadModel->countAsignedEdat($this->loadModel->getCompany()->cm_id),
        'installedmeters'=>$this->loadModel->countMeterByStatus('installed',$this->loadModel->getCompany()->cm_id),
        'instlledEdats'=>$this->loadModel->countEdatByStatus('installed',$this->loadModel->getCompany()->cm_id),
        'asignedFaultyMeters'=>$this->loadModel->countMeter('yet',$this->loadModel->getCompany()->cm_id),
        'asignedFaultyEdats'=>$this->loadModel->countEdatByStatus('faulty',$this->loadModel->getCompany()->cm_id),
        'fixedfaultyMeter'=>$this->loadModel->countMeter('RESOLVED',$this->loadModel->getCompany()->cm_id),
        'fixedFaultyEdat'=>$this->loadModel->countEdatByStatus('fixed',$this->loadModel->getCompany()->cm_id),
        'monthly'=>$this->loadModel->countMonthlyMeterInstallation($this->loadModel->getCompany()->cm_id)
      ];
      $this->view('company/index',$data);
    }
    public function staff(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['report']=$this->loadModel->report($this->loadModel->getCompany()->cm_id);
      $data['data']=$this->loadModel->staffDetails($this->loadModel->getCompany()->cm_id);
      $data['baseUrl']='/installations';
      $this->view('company/staff',$data);
    }
    // view asigned meters
    public function meters(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->viewCustomer($this->loadModel->getCompany()->cm_id);
      $data['id']=$this->loadModel->getCompany()->cm_id;
      $data['msg']='Outstanding Schedule(s)';
      $data['baseUrl']='/installations';
      $this->view('company/meters',$data);
    }

    // installed customers
    public function installedmeters(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->meters($this->loadModel->getCompany()->cm_id,'installed');
      $data['id']=$this->loadModel->getCompany()->cm_id;
      $data['msg']='installed meter(s)';
      $data['baseUrl']='/installations';
      $this->view('company/meters',$data);
    }
    // faulty meters
    public function asignedFaultyMeters(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->meters($this->loadModel->getCompany()->cm_id,'faulty');
      $data['msg']='Asigned Faulty Meter(s)';
      $data['baseUrl']='/installations';
      $this->view('company/meters',$data);
    }
    // fixed faulty meters
    public function fixedfaultyMeter(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->meters($this->loadModel->getCompany()->cm_id,'fixed');
      $data['baseUrl']='/installations';
      $data['msg']='Fixed Faulty Meter(s)';
      $this->view('company/meters',$data);
    }
    // meter stop here

    // edats start here
    public function edats(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['id']=$this->loadModel->getCompany()->cm_id;
      $data['cust']=$this->loadModel->asignedEdat($this->loadModel->getCompany()->cm_id);
      $data['msg']='Outstanding Schedule(s)';
      $data['baseUrl']='/installations';
      $this->view('company/edats',$data);
    }
    // installed edats
    public function installededats(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->fetchEdats($this->loadModel->getCompany()->cm_id,'installed');
      $data['baseUrl']='/installations';
      $data['msg']='Outstanding Schedule(s)';
      $this->view('company/edats',$data);
    }
    // faulty edats
    public function asignedfaultyedats(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->fetchEdats($this->loadModel->getCompany()->cm_id,'faulty');
      $data['baseUrl']='/installations';
      $data['msg']='Outstanding Schedule(s)';
      $this->view('company/edats',$data);
    }
    // fix faulty edats
    public function fixedfaultyedat(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->fetchEdats($this->loadModel->getCompany()->cm_id,'fixed');
      $data['baseUrl']='/installations';
      $data['msg']='Outstanding Schedule(s)';
      $this->view('company/edats',$data);
    }

    // edat stop here
    public function installer(){
        $data=[];
        $this->view('company/installer',$data);
    }
    function updatelevel(){
      parse_str($_POST['form'],$_POST);
      $data=[
        'group'=>escapeString($_POST['group']),
        'id'=>escapeString($_POST['userId'])
      ];
        $this->userModel=$this->model('User');
       if($this->userModel->updateGroup($data)){
         reportLog(UID()." updated ".idToName($data['id'])."'s group ",$data['id']);
         // send mail
         // sendMail(idToMail($data['id']),UID().' has asigned you a role!');
         smtpmailer(idToMail($data['id']),'Notification','You have been asigned a new role on MIMS');
         $msg = 'success';
       }else{
        $msg = 'update failed';
       }
       echo $msg;
    }
    function updateTeam(){
      parse_str($_POST['form'],$_POST);
      $data=[
        'team'=>escapeString($_POST['team']),
        'id'=>escapeString($_POST['userId'])
      ];
      $this->userModel=$this->model('User');
      if($this->userModel->updateTeam($data)){
        reportLog(UID().' updated user Team',$data['id']);
        smtpmailer(idToMail($data['id']),'Notification','You have been asigned to a new team on MIMS!');
        $msg = 'success';
      }else{
        $msg="Update failed";
      }
      echo $msg;
    }
    function updateStatus(){
      parse_str($_POST['form'],$_POST);
      $data=[
        'status'=>escapeString($_POST['status']),
        'id'=>escapeString($_POST['userId'])
      ];
      $this->userModel=$this->model('User');
      if($this->userModel->userStatus($data)){
        $data['status']=($data['status']=='guest') ? 'deactivated' : 'activated';
        reportLog(UID().' '.$data['status'].' '.idToName($data['id'])."'s account ",$data['id']);
        $msg = 'success!';
        // send mail
        // sendMail(idToMail($data['id']),'Your account has been '.$data['status']);
        smtpmailer(idToMail($data['id']),'Notification','Your MIMS account has been '.$data['status']);
      }else{
        $msg="Update failed";
      }
      echo $msg;
    }


  }
