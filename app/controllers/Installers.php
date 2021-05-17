<?php
  class Installers extends Controller{
    public function __construct(){
      !isLoggedIn() ? redirect('pages') : '';
      $this->loadModel=$this->model('Installer');
    }
    public function index(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'metersAsigned'=>$this->loadModel->countAsignedMeters(userId()),
        'edatAsigned'=>$this->loadModel->countAsignedEdat(userId()),
        'installedmeters'=>$this->loadModel->countMeterByStatus('installed',userId()),
        'instlledEdats'=>$this->loadModel->countEdatByStatus('installed',userId()),
        'asignedFaultyMeters'=>$this->loadModel->countMeterByStatus('faulty',userId()),
        'asignedFaultyEdats'=>$this->loadModel->countEdatByStatus('faulty',userId()),
        'fixedfaultyMeter'=>$this->loadModel->countMeterByStatus('fixed',userId()),
        'fixedFaultyEdat'=>$this->loadModel->countEdatByStatus('fixed',userId()),
        'monthly'=>$this->loadModel->countMonthlyMeterInstallation()
      ];
      $this->view('installer/index',$data);
    }

    // view asigned meters
    public function meters(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['cust']=$this->loadModel->viewCustomer(userId());
      $data['msg']='Schedule(s)';
      $this->view('installer/meters',$data);
    }

    // installed customers
    public function installedmeters(){
      $data['companyName']=$this->loadModel->getCompany()->names;
      $data['msg']='Installed Meter(s)';
      $data['cust']=$this->loadModel->meters(userId(),'installed');
      $this->view('installer/meters',$data);
    }
    // faulty meters
    public function asignedFaultyMeters(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'cust'=>''
      ];
      $data['cust']=$this->loadModel->meters(userId(),'faulty');
      $this->view('installer/meters',$data);
    }
    // fixed faulty meters
    public function fixedfaultyMeter(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'cust'=>''
      ];
      $data['cust']=$this->loadModel->meters(userId(),'fixed');
      $this->view('installer/meters',$data);
    }
    // meter stop here

    // edats start here
    public function edats(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'cust'=>''
      ];
      $data['cust']=$this->loadModel->asignedEdat(userId());
      $this->view('installer/edats',$data);
    }
    // installed edats
    public function installededats(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'cust'=>''
      ];
      $data['cust']=$this->loadModel->fetchEdats(userId(),'installed');
      $this->view('installer/edats',$data);
    }
    // faulty edats
    public function asignedFaultyEdats(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'cust'=>''
      ];
      $data['cust']=$this->loadModel->fetchEdats(userId(),'faulty');
      $this->view('installer/edats',$data);
    }
    // fix faulty edats
    public function fixedFaultyEdat(){
      $data=[
        'companyName'=>$this->loadModel->getCompany()->names,
        'cust'=>''
      ];
      $data['cust']=$this->loadModel->fetchEdats(userId(),'fixed');
      $this->view('installer/edats',$data);
    }

    // edat stop here
    public function installer(){
        $this->view('installer/installer',$data);
    }

  }
