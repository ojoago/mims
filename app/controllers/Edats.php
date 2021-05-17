<?php
  class Edats extends Controller{
    public function __construct(){
      !isLoggedIn() ? redirect('pages') : '';
      $this->edatModel=$this->model('Edat');
    }
    public function index(){
      $data=$this->edatModel->viewEdats();
      $this->view('edats/index', $data);
    }
    public function edat(){
       $data = ['title'=>'Scheduling','description'=>'edat'];
         //check for form submition
     if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
           'date'=>escapeString($_POST['date']),
           'date_err'=>'',
           'edatnum'=>escapeString($_POST['edatnum']),
           'edatnum_err'=>'',
           'rf'=>escapeString($_POST['rf']),
           'rf_err'=>'',
           'edatstatus'=>escapeString(@$_POST['edatstatus']),
           'edatstatus_err'=>'',
           'pole'=>escapeString($_POST['pole']),
           'pole_err'=>'',
           'state'=>escapeString(@$_POST['state']),
           'state_err'=>'',
           'dtname'=>escapeString($_POST['dtname']),
           'dtname_err'=>'',
           'address'=>escapeString($_POST['address']),
           'address_err'=>'',
           'company'=>escapeString(@$_POST['company']),
           'company_err'=>'',
           'asignedto'=>escapeString(@$_POST['asignedto']),
           'asignedto_err'=>'',
           'x'=>'',
           'y'=>''
     ];
     // validate input
     if(empty($data['date'])){
        $data['date_err']='Select Date';
     }
     if(empty($data['edatnum'])){
        $data['edatnum_err']='Enter Edat Number';
     }elseif(!is_numeric($data['edatnum'])){
        $data['edatnum_err']='Wrong Edat Number';
     }
     if(empty($data['rf'])){
        $data['rf_err']='Enter RF Number';
     }elseif(!is_numeric($data['rf']) or $data['rf']< 1 or $data['rf'] > 9){
        $data['rf_err']='Wrong RF Number';
     }
     if(empty($data['edatstatus'])){
        $data['edatstatus_err']='Select Edat Status';
     }
     if(empty($data['pole'])){
        $data['pole_err']='Enter Pole Number';
     }elseif(!is_numeric($data['pole']) or $data['pole']<1){
        $data['pole_err']='Wrong Pole Number';
     }
     if(empty($data['state'])){
        $data['state_err']='Select State';
     }
     if(empty($data['dtname'])){
        $data['dtname_err']='Enter DT Name';
     }
     if(empty($data['address'])){
        $data['address_err']='Enter DT address';
     }
     if(empty($data['company'])){
        $data['company_err']='Select Company';
     }
     if(empty($data['date_err']) and empty($data['edatnum_err']) and empty($data['rf_err']) and empty($data['edatstatus_err'])
        and empty($data['pole_err']) and empty($data['state_err']) and empty($data['dtname_err']) and empty($data['company_err'])){
        if($this->edatModel->save($data)){
           flash('register_success','Edat Schedule successfully');
           reportLog('Schedule edat',lastID());
           $data=[
              'date'=>'',
              'date_err'=>'',
              'edatnum'=>'',
              'edatnum_err'=>'',
              'rf'=>'',
              'rf_err'=>'',
              'edatstatus'=>'',
              'edatstatus_err'=>'',
              'pole'=>'',
              'pole_err'=>'',
              'project'=>'',
              'project_err'=>'',
              'dtname'=>'',
              'dtname_err'=>'',
              'address'=>'',
              'address_err'=>'',
              'company'=>'',
              'company_err'=>'',
              'asignedto'=>'',
              'asignedto_err'=>'',
              'state_err'=>'',
              'state'=>''

           ];
       }else{
          flash('register_success','Edat Schedule successfully');
       }
     }
     }else{
       $data=[
          'date'=>'',
          'date_err'=>'',
          'edatnum'=>'',
          'edatnum_err'=>'',
          'rf'=>'',
          'rf_err'=>'',
          'edatstatus'=>'',
          'edatstatus_err'=>'',
          'pole'=>'',
          'pole_err'=>'',
          'project'=>'',
          'project_err'=>'',
          'dtname'=>'',
          'dtname_err'=>'',
          'address'=>'',
          'address_err'=>'',
          'company'=>'',
          'company_err'=>'',
          'asignedto'=>'',
          'asignedto_err'=>'',
          'state_err'=>'',
          'state'=>''

       ];
     }
       $this->view('edats/edat', $data);
    }
    public function update(){
      $msg='';
      if(isset($_POST['updateEdat'])){
        $val=[
          'edatnumber' => escapeString($_POST['edat']),
          'id' => escapeString($_POST['id']),
          'rf' => escapeString($_POST['rf']),
          'add' => escapeString($_POST['address']),
          'dtname' => escapeString($_POST['dt']),
          'pole' => escapeString($_POST['pole']),
          'x' => escapeString($_POST['x']),
          'y' => escapeString($_POST['y'])
        ];
        if(!$this->isEdat($val['edatnumber'])){
          $msg="Wrong Edat Number";
        }
        if(!$this->is_rf($val['rf'])){
          $msg="Wrong RF";
        }
        if(!$this->isNum($val['pole'])){
          $msg="Wrong pole";
        }
        if(!$this->isNum($val['x'])){
          $msg="Wrong cordinate";
        }
        if(!$this->isNum($val['y'])){
          $msg="Wrong cordinate";
        }
        if($msg===''){
          if($this->edatModel->updateEdat($val)){
             $msg='update successful';
             reportLog('update edat',$val['id']);
             unset($val);
         }else{
             $msg='Somthing Went Wrong';
         }
       }
       echo $msg;
      }
    }
    public function asignEdat(){
        parse_str($_POST['form'],$_POST);
        $eid=isNum(escapeString($_POST['edat_id']));
        $cmp=isNum(escapeString($_POST['company']));
        if(isset($_POST['asignedto']) and !empty($_POST['asignedto']))
          $to=isNum(escapeString($_POST['asignedto']));
        else
          $to=0;
        if(!empty($eid) and !empty($cmp)){
            echo ($this->edatModel->asignCompany($eid,$cmp,$to)) ? 'success' : 'Somthing Went Wrong';
            reportLog("asigned edat $eid",lastID());
        }else{echo"Somthing Went Wrong";}
      }
      public function upload(){
        global $data;
        if($_SERVER['REQUEST_METHOD']=='POST'){
           $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
           $post=[
             'eid'=>escapeString($_POST['eid']),
             'doi'=>escapeString($_POST['doi']),
             'status'=>escapeString(@$_POST['status']),
             'remark'=>escapeString($_POST['remark']),
             'lat'=>escapeString($_POST['lat']),
             'long'=>escapeString($_POST['long']),
             'edatfoto'=> (!empty($_FILES['edatfoto']['tmp_name'])) ? $_FILES['edatfoto']['name'] : '',
           ];
           if(!$this->isNum($post['eid'])){
             $msg="all field is required";
           }
           if(!$this->isNum($post['lat'])){
             $msg="all field is required";
           }
           if(!$this->isNum($post['long'])){
             $msg="all field is required";
           }
           if(empty($post['doi'])){
             $msg="all field is required";
           }
           if(empty($post['status'])){
             $msg="all field is required";
           }
           if(empty($post['remark'])){
             $msg="all field is required";
           }
           if(empty($msg)){
             if($this->edatModel->installEdat($post)){
               !empty($_FILES['edatfoto']['tmp_name']) ? $this->extractImg($_FILES['edatfoto']['name'],$_FILES['edatfoto']['tmp_name']) : '';
               $msg="success";
             }
           }
           flash('register_success',$msg);
          unset($data);
         }
         redirect('edats');
      }
      public function maintain(){
        $this->view('edats/maintain', $data=[]);
      }
  }
