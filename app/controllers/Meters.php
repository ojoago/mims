<?php
  class Meters extends Controller{
    public function __construct(){
      isLoggedIn() ?: redirect('pages');
      $this->metModel=$this->model('Meter');
    }
    public function index($from='',$to=''){
      if(!empty($from)){
        if($from=='all'){
          $row=$this->metModel->loadAllCustomers();
          $data['date']="All Installation Records";
          reportLog(UID().' filter all record');
        }else{
          $to=empty($to) ? $from:$to;
          $to=date('Y-m-d',strtotime($to));
          $from=date('Y-m-d',strtotime($from));
          $data['date']= $from===$to ? "$from Installations" : "Installations from ".$from.' to '.$to;
          $row=$this->metModel->loadCustomerByDates($from,$to);
          reportLog(UID().' filter installation '.$data['date']);
        }
        $data['row']=$row['row'];
        $data['count']=$row['count'];
      }else{
        $row=$this->metModel->loadCustomers();
        $data['row']=$row['row'];
        $data['count']=$row['count'];
        $data['date']="Today's installations";
      }
      $this->view('meters/index',$data);
    }

    public function supervisor($from='',$id=0,$to=''){
      $data['count']=0;
      if(!empty($from) and $id>0 and isNum($id)){
        $to=empty($to) ? $from : $to;
        $to=date('Y-m-d',strtotime($to));
        $from=date('Y-m-d',strtotime($from));
        $id=escapeString($id);
        $row=$this->metModel->loadCustomersBySup($from,$to,$id);
        $data['row']=$row['row'];
        $data['count']=$row['count'];
        $data['date']= $from===$to ? "$from Installations" : "Installations from ".$from.' to '.$to;
        reportLog(UID().' filter installation of '.$data['date']);
      }
      $this->view('meters/index',$data);
    }

    public function find($id=0){
      $data=$this->metModel->loadCustomersById(base64_decode($id));
      $data['row']=$data['row'];
      $data['count']=$data['count'];
      $data['date']="Single Customer";
      reportLog(UID().' filter '. @$data['row'][0]->account_number);
      $this->view('meters/index',$data);
    }

    public function manageForm(){
      if(isset($_POST['scheduleFirst'])){
        parse_str($_POST['form'],$_POST);$error=$msg='';
        $data=[
          'account_name'=>escapeString($_POST['account_name']),
          'accountnum'=>escapeString($_POST['accountnum']),
          'gsm'=>escapeString($_POST['gsm']),
          'address'=>escapeString($_POST['address']),
          'dtname'=>escapeString($_POST['dtname']),
          // 'surveyStatus'=>escapeString($_POST['']),
          'custType'=>escapeString(@$_POST['custType']),
          'state'=>escapeString($_POST['state']),
          'region'=>escapeString($_POST['region']),
          'feeder'=>escapeString($_POST['feeder']),
          'meterType'=>escapeString(@$_POST['meterType']),
          'date'=>escapeString($_POST['date']),
          'uid'=>escapeString(@$_POST['uid']),
        ];
        //print_r($data);
        if(empty($data['account_name'])){
          $error='Enter Account Number';
        }
        if(empty($data['accountnum'])){
          $error='Enter Account Number';
        }
        if(empty($data['gsm'])){
          $error='Enter Account Number';
        }
        if(empty($data['gsm'])){
          $error='Enter Account Number';
        }
        if(empty($data['address'])){
          $error='Enter Account Number';
        }
        if(empty($data['dtname'])){
          $error='Enter Account Number';
        }
        if(empty($data['custType'])){
          $error='Enter Account Number';
        }
        if(empty($data['state'])){
          $error='Enter Account Number';
        }
        if(empty($data['region'])){
          $error='Enter Account Number';
        }
        if(empty($data['feeder'])){
          $error='Enter Account Number';
        }
        if(empty($data['meterType'])){
          $error='Enter Account Number';
        }
        if(empty($data['date'])){
          $error='Enter Account Number';
        }
        if(empty($data['uid'])){
          $error='Enter Account Number';
        }
      }
    }
    function findSchedule(){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $num =escapeString($_POST['num']);
        if(!empty($num)){
            $num=$this->metModel->findnum($num);
            if(!empty($num)){
                $data='<ul class="list-unstyled">';
                foreach ($num as $r) {
                $data.="<a href='". URLROOT."/meters/single/".$r->id."'><li class = 'list-group-item pointer' >".ucwords($r->accountname). "</li></a>";
                }
                $data.='</ul>';
            }
        }else {
            $data="Empty Result set";
        }
        // echo var_dump($data);
        echo jsonDecode($data);
    }
    public function single($id=0){
      $_SESSION['search']=true;
      if(isNum($id) and $id>0){
      $id = floor($id);
      $data=$this->metModel->findSingleSchedule($id);
      $this->view('meters/index',$data);
    }else{
        $this->index();
      }
    }
    // installation form and page
    public function install($id=0){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = [
          'custId'=>escapeString($_POST['custid']),
          'doi'=>escapeString($_POST['doi']),
          'eid'=>'',
          'preload'=>escapeString($_POST['preload']),
          'seal'=>escapeString($_POST['seal']),
          'meterNumber'=>escapeString($_POST['meterNumber']),
          'box'=>escapeString($_POST['box']),
          'tariff'=>escapeString(@$_POST['tariff']),
          'advtariff'=>escapeString(@$_POST['advtariff']),
          'status'=>escapeString(@$_POST['status']),
          'meterfoto'=> !empty($_FILES['meterfoto']['tmp_name']) ? $_FILES['meterfoto']['name'] : '',
          'remark'=>escapeString($_POST['remark']),
          'latitude'=>escapeString($_POST['latitude']),
          'longitude'=>escapeString($_POST['longitude']),
          'type'=>escapeString(@$_POST['type']),
          'rf'=>escapeString($_POST['rf'])
        ];
        $id=$data['custId'];
        if(empty($data['doi'])){
          $error=$data['doi_err']="Enter Date";
        }
        if(empty($data['type'])){
          $error=$data['type_err']="Select Meter Technology";
        }
        $data['rf_err']='';
        if($data['type']=='rf' and empty($data['rf'])){
          $error=$data['rf_err']="Enter RF Channel";
        }
        if(!$this->isNum($data['preload'])){
          $error=$data['preload_err']="Enter preload Unit Correctly";
        }
        if(empty($data['seal']) or !$this->isNum($data['seal'])){
          $data['seal_err']="Enter seal number correctly";
        }
        if(empty($data['meterNumber'])){
          $error=$data['mt_err']="Enter Meter Number";
        }elseif(strlen($data['meterNumber']) < METER_LENGTH){
          $error=$data['mt_err']="Meter Number is 12 digit";
        }elseif(findByCol(MET_TBL,'meternum',$data['meterNumber'])){
          $error=$data['mt_err']="Meter Exist";
        }
        if(empty($data['box'])){
          $error=$data['box_err']="Enter Box Id Correctly";
        }
        if(empty($data['tariff'])){
          $error=$data['tariff_err']="Select Tariff";
        }
        if(empty($data['advtariff'])){
          $error=$data['advtariff_err']="Select advised Tariff";
        }
        if(empty($data['remark'])){
          $error=$data['remark_err']="Enter remark";
        }
        if(empty($data['status'])){
          $error=$data['status_err']="Enter status";
        }
        if(empty($data['latitude'])){
          $error=$data['latitude_err']="Enter latitude";
        }
        if(empty($data['longitude'])){
          $error=$data['longitude_err']="Enter longitude";
        }
        if(empty($error)){
            //$data['eid']=$this->metModel->edatId($data['edatNum']);
            if($this->metModel->scheduleMeter($data)){
              reportLog('installed meter',lastID());
               !empty($_FILES['meterfoto']['tmp_name']) ? $this->extractImg($_FILES['meterfoto']['name'],$_FILES['meterfoto']['tmp_name']) : '';
               if(strtolower($data['status'])=='installed'){
                 $this->metModel->updateStatus($data['custId']);
                 $installDetails =[
                   "sealNo"=>$data['seal'],
                   "meterNo"=>$data['meterNumber'],
                   "account"=>getValue(SCHEDULE_TBL,'accountnumber',$data['custId']),
                   "date"=> $data['doi'],
                   "key"=>"50105772d8f5ae251c1add6f26ef205f"
                 ];
              //  echo  Restapi::installationDetails($installDetails);
               }
                flash('register_success','success');
                $data=resetArray($data);
                $data['custId']=$id;
              // $this->view('meters/index', $data);
           }else{
               die('Somthing Went Wrong');
           }
          }
      }else {
        $data = [
          'custId'=>$id,
          'doi'=>'',
          'doi_err'=>'',
          'preload'=>'',
          'preload_err'=>'',
          'seal'=>'',
          'seal_err'=>'',
          'meterNumber'=>'',
          'mt_err'=>'',
          'box'=>'',
          'box_err'=>'',
          'tariff'=>'',
          'tariff_err'=>'',
          'advtariff'=>'',
          'advtariff_err'=>'',
          'status'=>'',
          'status_err'=>'',
          'meterfoto'=>'',
          'meterfoto_err'=>'',
          'remark'=>'',
          'remark_err'=>'',
          'latitude'=>'',
          'latitude_err'=>'',
          'longitude'=>'',
          'longitude_err'=>'',
          'type'=>'',
          'type_err'=>'',
          'rf'=>'',
          'rf_err'=>''
        ];
      }
       $this->view('meters/install', $data);
    }
    // load installed customers page
    public function installed(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        if(isset($_POST['column'])){
          $data=[
            'num'=>escapeString($_POST['day']),
            'to'=>escapeString($_POST['criteria'])
          ];
            $data=$this->metModel->findInstalledCustomerByColumn($data);
        }
      }else{
        $data=$this->metModel->installedCustomer();
      }
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
     $data=$this->metModel->findInstalledCustomerByDateRange($data);
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
      $data=$this->metModel->findInstalledCustomerByColumn($data);
      $this->view('meters/installed',$data);
    }
    function findBynumber(){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $num =escapeString($_POST['num']);
        if(!empty($num)){
            $num=$this->metModel->findnum($num);
            if(!empty($num)){
                $data='<ul class="list-unstyled">';
                foreach ($num as $r) {
                $data.="<a href='". URLROOT."/meters/fetchsingle/".$r->id."'><li class = 'list-group-item pointer' >".ucwords($r->fullname). "</li></a>";
                }
                $data.='</ul>';
            }
        }else {
            $data="Empty Result set";
        }
        // echo var_dump($data);
        echo jsonDecode($data);
    }

    public function form(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
          'accountno'=>escapeString($_POST['accountnum']),
          'accountno_err'=>'',
          'accountname'=>escapeString($_POST['account_name']),
          'accountname_err'=>'',
          'address'=>escapeString($_POST['address']),
          'address_err'=>'',
          'gsm'=>escapeString($_POST['gsm']),
          'gsm_err'=>'',
          'region'=>escapeString($_POST['region']),
          'region_err'=>'',
          'area'=>escapeString($_POST['']),
          'accountno_err'=>'',
          'feeder'=>escapeString($_POST['feeder']),
          'area_err'=>'',
          'dt'=>escapeString($_POST['dtname']),
          'dt_err'=>'',
          'metertype'=>escapeString($_POST['meterType']),
          'metertype_err'=>'',
          'date'=>escapeString($_POST['date']),
          'date_err'=>'',
          'status'=>escapeString($_POST['status']),
          'status_err'=>'',
          'uid'=>escapeString($_POST['uid']),
          'uid_err'=>'',
          // 'duration'=>escapeString($_POST['']),

          'custId'=>escapeString($_POST['']),
          'preload'=>escapeString($_POST['']),
          'preload_err'=>'',
          'seal'=>escapeString($_POST['']),
          'seal_err'=>'',
          'meterNumber'=>escapeString($_POST['']),
          'mt_err'=>'',
          'date'=>escapeString($_POST['date']),
          'box'=>escapeString($_POST['']),
          'box_err'=>'',
          'tariff'=>escapeString($_POST['']),
          'tariff_err'=>'',
          'advtariff'=>escapeString($_POST['']),
          'advtariff_err'=>'',
          'status'=>escapeString($_POST['']),
          'status_err'=>'',
          'meterfoto'=>escapeString($_POST['']),
          'meterfoto_err'=>'',
          'remark'=>escapeString($_POST['']),
          'remark_err'=>'',
          'latitude'=>escapeString($_POST['']),
          'latitude_err'=>'',
          'longitude'=>escapeString($_POST['']),
          'longitude_err'=>'',
          'tech'=>escapeString($_POST['']),
          'tech_err'=>'',
          'rf'=>escapeString($_POST['']),
          'rf_err'=>'',
          'meterType'=>escapeString($_POST['']),
          'uid'=>escapeString($_POST['']),
          'dtcode'=>escapeString($_POST['']),
          'upriser'=>escapeString($_POST['']),
          'pole'=>escapeString($_POST['']),
        ];
      }else{
        $data=[
          'accountno'=>'',
          'accountname'=>'',
          'address'=>'',
          'gsm'=>'',
          'region'=>'',
          'area'=>'',
          'feeder'=>'',
          'dt'=>'',
          'metertype'=>'',
          'date'=>'',
          'duration'=>'',
          'dtname'=>'',
          'custId'=>'',
          'doi'=>'',
          'doi_err'=>'',
          'preload'=>'',
          'preload_err'=>'',
          'seal'=>'',
          'seal_err'=>'',
          'meterNumber'=>'',
          'mt_err'=>'',
          'box'=>'',
          'box_err'=>'',
          'tariff'=>'',
          'tariff_err'=>'',
          'advtariff'=>'',
          'advtariff_err'=>'',
          'status'=>'',
          'status_err'=>'',
          'meterfoto'=>'',
          'meterfoto_err'=>'',
          'remark'=>'',
          'remark_err'=>'',
          'latitude'=>'',
          'latitude_err'=>'',
          'longitude'=>'',
          'longitude_err'=>'',
          'type'=>'',
          'type_err'=>'',
          'rf'=>'',
          'rf_err'=>'',
          'meterType'=>'',
          'uid'=>'',
          'dtcode'=>'',
          'upriser'=>'',
          'pole'=>'',
        ];
      }
      $data=resetArray($data);
      $this->view('meters/form',$data);
    }
    public function schedule(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
          'meter_num'=>escapeString($_POST['meter_num']),
          'meter_num_err'=>'',
          'preload'=>escapeString($_POST['preload']),
          'preload_err'=>'',
          'state'=>escapeString($_POST['state']),
          'state_err'=>'',
          'zone'=>escapeString($_POST['zone']),
          'zone_err'=>'',
          'doi'=>escapeString($_POST['doi']),
          'doi_err'=>'',
          'dt_name'=>escapeString($_POST['dt_name']),
          'dt_name_err'=>'',
          'dt_code'=>escapeString($_POST['dt_code']),
          'dt_code_err'=>'',
          'dt_type'=>escapeString(@$_POST['dt_type']),
          'dt_type_err'=>'',
          'upriser'=>escapeString($_POST['upriser']),
          'upriser_err'=>'',
          'pole'=>escapeString($_POST['pole']),
          'pole_err'=>'',
          'tariff'=>escapeString(@$_POST['tariff']),
          'tariff_err'=>'',
          'advtariff'=>escapeString(@$_POST['advtariff']),
          'advtariff_err'=>'',
          'fullname'=>escapeString($_POST['fullname']),
          'fullname_err'=>'',
          // 'first_name'=>escapeString($_POST['first_name']),
          // 'first_name_err'=>'',
          // 'last_name'=>escapeString($_POST['last_name']),
          // 'last_name_err'=>'',
          'gsm'=>escapeString($_POST['gsm']),
          'gsm_err'=>'',
          'mail'=>escapeString($_POST['mail']),
          'mail_err'=>'',
          'premises'=>escapeString(@$_POST['premises']),
          'premises_err'=>'',
          'phase'=>escapeString(@$_POST['phase']),
          'phase_err'=>'',
          'address'=>escapeString($_POST['address']),
          'address_err'=>'',
          'remark'=>escapeString($_POST['remark']),
          'remark_err'=>'',
          'feeder_33kv'=>escapeString(@$_POST['feeder_33kv']),
          'feeder_33kv_err'=>'',
          'feeder_11kv'=>escapeString(@$_POST['feeder_11kv']),
          'feeder_11kv_err'=>'',
          'meter_type'=>escapeString(@$_POST['meter_type']),
          'meter_type_err'=>'',
          'meter_brand'=>escapeString($_POST['meter_brand']),
          'meter_brand_err'=>'',
          'meter_tech'=>escapeString($_POST['meter_tech']),
          'meter_tech_err'=>'',
          'estimated'=>escapeString($_POST['estimated']),
          'estimated_err'=>'',
          'account_no'=>escapeString($_POST['account_no']),
          'account_no_err'=>'',
          'b_unit'=>escapeString($_POST['b_unit']),
          'b_unit_err'=>'',
          'x'=>escapeString($_POST['x']),
          'x_err'=>'',
          'y'=>escapeString($_POST['y']),
          'y_err'=>'',
          'installer'=>escapeString(@$_POST['installer']),
          'installer_err'=>'',
          'super'=>escapeString(@$_POST['super']),
          'super_err'=>'',
          'rf'=>escapeString($_POST['rf']),
          'rf_err'=>'',
          'din'=>escapeString($_POST['din']),
          'din_err'=>'',
          'seal'=>escapeString($_POST['seal']),
          'seal_err'=>'',
          'id'=>isset($_POST['id']) ? escapeString($_POST['id']) : '',
          'updated_for'=>isset($_POST['updated_for']) ? escapeString($_POST['updated_for']) : '',
        ];
        if(!empty($data['id'])){
          $data['update']=true;
        }
        if(empty($data['meter_num'])){
          $error=$data['meter_num_err']="Enter Meter Number";
        }elseif(!maxLength($data['meter_num'])) {
          $error=$data['meter_num_err']="T7 Meter Number is 11 digit";
        }
        elseif(!findByCol(MET_NUM_TBL,'number',$data['meter_num'])) {
          $error=$data['meter_num_err']="This Meter Number is not in our record!!!";
        }
        if(isset($data['update'])){
          $id=findDupByCol(INSTALL_MET_TBL,'id','meter_no',$data['meter_num']);
          if($id !=0 and $id !=$data['id']){
            $error=$data['meter_num_err']="Meter Number already asigned to another customer!";
          }
        }elseif(findByCol(INSTALL_MET_TBL,'meter_no',$data['meter_num'])){
            $error=$data['meter_num_err']="Meter Number exist";
        }

        if(empty($data['seal'])){
          $error=$data['seal_err']="Enter Seal Number";
        }elseif(!maxLength($data['seal'],6)) {
          $error=$data['seal_err']="Seal Number is 6 digit";
        }
        // if(!isNum($data['seal'])){
        //   $error=$data['seal_err']="Seal Must be Number";
        // }
        if(empty($data['preload'])){
          $error=$data['preload_err']="Enter preload Unit";
        }
        if(!isNum($data['preload'])){
          $error=$data['preload_err']="Preload Unit Must Be in figure";
        }
        if(empty($data['state'])){
          $error=$data['state_err']="Enter State";
        }
        if(empty($data['zone'])){
          $error=$data['zone_err']="Select Trading Zone";
        }
        if(empty($data['doi'])){
          $error=$data['doi_err']="Date cannot be empty";
        }else{
            $_SESSION['doi']=$data['doi'];
        }
        if(empty($data['dt_name'])){
          $error=$data['dt_name_err']="Enter DT Name";
        }
        // if(empty($data['dt_code'])){
        //   $error=$data['dt_code_err']="Enter DT code";
        // }
        // if(!isNum($data['dt_code'])){
        //   $error=$data['dt_code_err']="DT code Must be Number";
        // }
        if(empty($data['dt_type'])){
          $error=$data['dt_type_err']="Select Owner";
        }
        if(empty($data['upriser'])){
          $error=$data['upriser_err']="Enter Upriser";
        }
        if(!isNum($data['upriser'])){
          $error=$data['upriser_err']="Upriser Must Be Number";
        }elseif($data['upriser']<1 and $data['upriser']>4){
            $error=$data['upriser_err']="Wrong Upriser Number";
        }
        if(empty($data['pole'])){
          $error=$data['pole_err']="Enter Pole Number";
        }

        if(!isNum($data['pole'])){
          $error=$data['pole_err']="Pole Number Must be in figure";
        }
        if(empty($data['tariff'])){
          $error=$data['tariff_err']="Select Tariff";
        }
        if(empty($data['advtariff'])){
          $error=$data['advtariff_err']="Select advised Tariff";
        }
        if(empty($data['fullname'])){
          $error=$data['fullname_err']="Enter Customer's name";
        }
        // if(empty($data['last_name'])){
        //   $error=$data['last_name_err']="Customer last name";
        // }
        if(empty($data['gsm'])){
          $error=$data['gsm_err']="Enter Customer Phone Number";
        }elseif(!maxLength($data['gsm'])) {
          $error=$data['gsm_err']="Customer Phone Number Must 11 digit";
        }
        if(empty($data['premises'])){
          $error=$data['premises_err']="Enter premises type";
        }
        if(empty($data['phase'])){
          $error=$data['phase_err']="Select phase";
        }
        if(empty($data['address'])){
          $error=$data['address_err']="Enter Customer Address";
        }
        // if(empty($data['remark'])){
        //   $error=$data['remark_err']="Enter Customer's comments";
        // }
        if(empty($data['feeder_33kv'])){
          $error=$data['feeder_33kv_err']="Select 33kv Feeder";
        }
        if(empty($data['feeder_11kv'])){
          $error=$data['feeder_11kv_err']="Select 11kv Feeder";
        }
        if(empty($data['meter_type'])){
          $error=$data['meter_type_err']="Select Meter Type";
        }
        if(empty($data['meter_brand'])){
          $error=$data['meter_brand_err']="Select Meter Brand";
        }
        if(empty($data['meter_tech'])){
          $error=$data['meter_tech_err']="Select Meter Technology";
        }
        // if(empty($data['estimated'])){
        //   $error=$data['estimated_err']="CUSTOMER ESTIMATED CUMULATIVE";
        // }
        if(empty($data['account_no'])){
          $error=$data['account_no_err']="Enter Customer Account Number";
        }
        if(isset($data['update'])){
            $id=findDupByCol(INSTALL_MET_TBL,'id','account_number',$data['account_no']);
            //$id=$this->metModel->verifyAccountNumberOnUpdate($data['account_no']);
          if($id !=0 and $id !=$data['id']){
            $error=$data['account_no_err']="Account Number belong to another customer!";
          }
          if(empty($data['updated_for'])){
            $error=$data['updated_for_err']="State why you're updating!";
          }
        }else{
            if(findByCol(INSTALL_MET_TBL,'account_number',$data['account_no'])){
                $error=$data['account_no_err']="Account Number exist";
            }
        }

        if(empty($data['b_unit'])){
          $error=$data['b_unit_err']="Enter Business Unit";
        }
        if(empty($data['x'])){
          $error=$data['x_err']="Enter X coordinate";
        }elseif(!coordinateNum($data['x'])){
          $error=$data['x_err']='Wrong coordinate';
        }elseif(!coordinateDot($data['x'])){
          $error=$data['x_err']='Round coordinate to six decimal places';
        }elseif(!coordinate($data['x'])){
          $error=$data['x_err']='Round coordinate to six decimal places';
        }
        if(empty($data['y'])){
          $error=$data['y_err']="Enter Y coordinate";
        }elseif(!coordinateNum($data['y'])){
          $error=$data['y_err']='Wrong coordinate';
        }elseif(!coordinateDot($data['y'])){
          $error=$data['y_err']='Round coordinate to six decimal places';
        }elseif(!coordinate($data['y'])){
          $error=$data['y_err']='Round coordinate to six decimal places';
        }
        if(empty($data['installer'])){
          $error=$data['installer_err']="Select Installer";
        }
        if(empty($data['super'])){
          $error=$data['super_err']="Select Supervisor";
        }
        if(strtoupper($data['meter_tech'])=='RF'){
          if(empty($data['rf'])){
            $error=$data['rf_err']="Enter RF Channel";
          }
          if(!isNum($data['rf'])){
            $error=$data['rf_err']="RF Channel Must Be Number";
          }
        }
        if(empty($error)){
          $this->metModel->installCustomer($data) ? flash('register_success','Form Submitted'): flash('register_success','Something Went Wrong','alert alert-danger');
          isset($data['update']) ? reportLog(UID().' Updated '.$data['meter_num'].','.$data['account_no'].' info'): reportLog(UID().' Entered '.$data['meter_num'].' record');
          unset($data['update']);
          $_SESSION['doi']=$data['doi'];
          if(!isset($_POST['multiple'])){
            $data=resetArray($data);
            //$data['doi']=$doi;
          }else{
              unset($data['update']);
            $data['din']=$data['meter_num']=$data['preload']=$data['tariff']=$data['advtariff']=$data['phase']=$data['meter_type']=$data['account_no']=$data['seal']='';
          }
        }
      }else {
        $data=[
          'meter_num'=>'',
          'meter_num_err'=>'',
          'preload'=>'',
          'preload_err'=>'',
          'state'=>'',
          'state_err'=>'',
          'zone'=>'',
          'zone_err'=>'',
          'doi'=>'',
          'doi_err'=>'',
          'dt_name'=>'',
          'dt_name_err'=>'',
          'dt_num'=>'',
          'dt_num_err'=>'',
          'dt_type'=>'',
          'dt_type_err'=>'',
          'upriser'=>'',
          'upriser_err'=>'',
          'pole'=>'',
          'pole_err'=>'',
          'tariff'=>'',
          'advtariff'=>'',
          'tariff_err'=>'',
          'title'=>'',
          'title_err'=>'',
          'fullname'=>'',
          'fullname_err'=>'',
          'last_name'=>'',
          'last_name_err'=>'',
          'gsm'=>'',
          'gsm_err'=>'',
          'mail'=>'',
          'mail_err'=>'',
          'premises'=>'',
          'premises_err'=>'',
          'phase'=>'',
          'phase_err'=>'',
          'address'=>'',
          'address_err'=>'',
          'remark'=>'',
          'remark_err'=>'',
          'feeder_33kv'=>'',
          'feeder_33kv_err'=>'',
          'feeder_11kv'=>'',
          'feeder_11kv_err'=>'',
          'meter_type'=>'',
          'meter_type_err'=>'',
          'meter_brand'=>'',
          'meter_brand_err'=>'',
          'meter_tech'=>'',
          'meter_tech_err'=>'',
          'estimated'=>'',
          'estimated_err'=>'',
          'account_no'=>'',
          'account_no_err'=>'',
          'b_unit'=>'',
          'b_unit_err'=>'',
          'x'=>'',
          'x_err'=>'',
          'y'=>'',
          'y_err'=>'',
          'installer'=>'',
          'installer_err'=>'',
          'super'=>'',
          'super_err'=>'',
          'rf'=>'',
          'rf_err'=>'',
          'din'=>'',
          'din_err'=>'',
          'seal'=>'',
          'seal_err'=>'',
          'dt_code'=>'',
          'dt_code_err'=>'',
          'advtariff_err'=>'',
        ];
        $_SESSION['doi']='';
      }
      $this->view('meters/form',$data);
    }

    public function edit($id=0){
      if($id>0){
        $row=$this->metModel->loadInstalledCustomerById(escapeString($id));
        if($row){
          reportLog(UID().' fetched this for editing '.$row->meter_no);
          $data=[
            'meter_num'=>$row->meter_no,
            'meter_num_err'=>'',
            'preload'=>$row->preload,
            'preload_err'=>'',
            'state'=>$row->state,
            'state_err'=>'',
            'zone'=>$row->zone,
            'zone_err'=>'',
            'doi'=>$row->date,
            'doi_err'=>'',
            'dt_name'=>$row->dt_name,
            'dt_name_err'=>'',
            'dt_num'=>'',
            'dt_num_err'=>'',
            'dt_type'=>$row->dt_type,
            'dt_type_err'=>'',
            'upriser'=>$row->upriser,
            'upriser_err'=>'',
            'pole'=>$row->pole,
            'pole_err'=>'',
            'tariff'=>$row->presenet_tariff,
            'advtariff'=>$row->advised_tariff,
            'advtariff_err'=>'',
            'tariff_err'=>'',
            'title'=>'',
            'title_err'=>'',
            'fullname'=>$row->fullname,
            'fullname_err'=>'',
            'last_name'=>'',
            'last_name_err'=>'',
            'gsm'=>$row->phone_number,
            'gsm_err'=>'',
            'mail'=>$row->customer_email,
            'mail_err'=>'',
            'premises'=>$row->use_of_premises,
            'premises_err'=>'',
            'phase'=>$row->customer_phase,
            'phase_err'=>'',
            'address'=>$row->customer_address,
            'address_err'=>'',
            'remark'=>$row->customer_remark,
            'remark_err'=>'',
            'feeder_33kv'=>$row->feeder_kv,
            'feeder_33kv_err'=>'',
            'feeder_11kv'=>$row->feeder,
            'feeder_11kv_err'=>'',
            'meter_type'=>$row->meter_type,
            'meter_type_err'=>'',
            'meter_brand'=>$row->meter_brand,
            'meter_brand_err'=>'',
            'meter_tech'=>$row->meter_tech,
            'meter_tech_err'=>'',
            'estimated'=>$row->estimated,
            'estimated_err'=>'',
            'account_no'=>$row->account_number,
            'account_no_err'=>'',
            'b_unit'=>$row->b_unit,
            'b_unit_err'=>'',
            'x'=>$row->latitude,
            'x_err'=>'',
            'y'=>$row->longitude,
            'y_err'=>'',
            'installer'=>$row->installer_id,
            'installer_err'=>'',
            'super'=>$row->installer_supervisor,
            'super_err'=>'',
            'rf'=>$row->rf,
            'rf_err'=>'',
            'din'=>$row->din,
            'din_err'=>'',
            'seal'=>$row->seal_number,
            'seal_err'=>'',
            'dt_code'=>$row->dt_code,
            'dt_code_err'=>'',
            'id'=>$row->id,
            'update'=>true,
            'advtariff_err'=>'',
            'doi'=>$row->date,
            'updated_for'=>$row->updated_for,
          ];
          $_SESSION['doi']=$data['doi'];
          $this->view('meters/form',$data);
        }else{
          redirect('meters/schedule');
        }
      }else {
        redirect('meters/schedule');
      }
    }

    public function confirmMeterNumber(){
      $msg='';
      if(isset($_POST['confirmMeterNumber'])){
        $msg=$this->metModel->confirmMeterNumber(escapeString($_POST['num'])) ?: 'This Meter Number is not in our record!!!';
      }
      jsonEncode($msg);
    }

    public function list(){
      $data=$this->metModel->jedSchedule();
      $this->view('meters/list',$data);
    }
    public function load($id=0){
      if($id>0){
        $row=$this->metModel->loadCustomerById(escapeString($id));
        if($row){
            $data=[
              'meter_num'=>'',
              'meter_num_err'=>'',
              'preload'=>'',
              'preload_err'=>'',
              'state'=>'',
              'state_err'=>'',
              'zone'=>'',
              'zone_err'=>'',
              'doi'=>'',
              'doi_err'=>'',
              'dt_name'=>$row->dt_name,
              'dt_name_err'=>'',
              'dt_type'=>'',
              'dt_type_err'=>'',
              'upriser'=>'',
              'upriser_err'=>'',
              'pole'=>'',
              'pole_err'=>'',
              'tariff'=>'',
              'advtariff'=>'',
              'tariff_err'=>'',
              'title'=>'',
              'title_err'=>'',
              'fullname'=>$row->fullname,
              'fullname_err'=>'',
              'gsm'=>$row->gsm,
              'gsm_err'=>'',
              'mail'=>'',
              'mail_err'=>'',
              'premises'=>'',
              'premises_err'=>'',
              'phase'=>'',
              'phase_err'=>'',
              'address'=>$row->address,
              'address_err'=>'',
              'remark'=>'',
              'remark_err'=>'',
              'feeder_33kv'=>$row->feeder33kv,
              'feeder_33kv_err'=>'',
              'feeder_11kv'=>'',
              'feeder_11kv_err'=>'',
              'meter_type'=>'',
              'meter_type_err'=>'',
              'meter_brand'=>'',
              'meter_brand_err'=>'',
              'meter_tech'=>'',
              'meter_tech_err'=>'',
              'estimated'=>'',
              'estimated_err'=>'',
              'account_no'=>$row->account_number,
              'account_no_err'=>'',
              'b_unit'=>'',
              'b_unit_err'=>'',
              'x'=>'',
              'x_err'=>'',
              'y'=>'',
              'y_err'=>'',
              'installer'=>'',
              'installer_err'=>'',
              'super'=>'',
              'super_err'=>'',
              'rf'=>'',
              'rf_err'=>'',
              'din'=>$row->cin,
              'din_err'=>'',
              'seal'=>'',
              'seal_err'=>'',
              'dt_code'=>$row->transformer_number,
              'dt_code_err'=>'',
              'advtariff_err'=>'',
            ];
            $this->view('meters/form',$data);
        }else {
          redirect('meters/form');
        }
      }else{
        redirect('meters/list');
      }
    }
    public function record($from='',$to='',$id=''){
      if(!empty($from) AND empty($id)){
        $to=empty($to) ? $from:$to;
        $to=date('Y-m-d',strtotime(escapeString($to)));
        $from=date('Y-m-d',strtotime(escapeString($from)));
        $data=$this->metModel->loadDailyRecordByDates($from,$to);
      }elseif(!empty($from) and !empty($to) and !empty($id)){
        $to=date('Y-m-d',strtotime(escapeString($to)));
        $from=date('Y-m-d',strtotime(escapeString($from)));
        $data=$this->metModel->loadDailyRecordByDateId($from,$to,escapeString($id));
      }else{
        $data=$this->metModel->loadDailyRecord();
      }
      $this->view('meters/record',$data);
    }
    public function manageRecord(){
      $error=$msg=$data='';
      if(isset($_POST['addDailyRecord'])){
        parse_str($_POST['form'],$_POST);
        $data=[
          'schedule'=>escapeString($_POST['schedule']),
          'id'=>escapeString($_POST['id']),
          'installed'=>escapeString($_POST['installed']),
          'replaced'=>escapeString($_POST['replaced']),
          'date'=>escapeString($_POST['date']),
          'team'=>escapeString(@$_POST['team']),
          'sup'=>escapeString(@$_POST['sup']),
          'writer'=>escapeString(@$_POST['writer']),
        ];
        if(empty($data['schedule'])){
          $error='Enter No. of Meter issue Out';
        }
        if(empty($data['installed'])){
          $error='Enter No. of Meter installed';
        }
          if(empty($data['replaced']))
            $data['replaced']=0;
        if(empty($data['date'])){
          $error='Enter Date';
        }
        if(empty($data['team'])){
          $error='Select Team';
        }
        if(empty($data['sup'])){
          $error='Select team Supervisor';
        }
        if(empty($data['writer'])){
          $error='Select Writer';
        }
        if(empty($error)){
          $this->metModel->addDailyRecord($data) ? $msg = prettyMsg('success') : $error=prettyMsg($error,'alert-danger');
        }else{
          $error=prettyMsg($error,'alert-danger');
        }
        jsonEncode(['msg'=>empty($msg) ? $error : $msg,'error'=>$error]);
      }
      // update daily installation records
      if(isset($_POST['loadDailyRecordById'])){
        $data=[
          'id'=>escapeString($_POST['id']),
          'meter'=>escapeString($_POST['meter']),
          'forms'=>escapeString($_POST['forms']),
          'replaced'=>escapeString($_POST['replaced'])
        ];
        if(empty($data['id']) or !isNum($data['id']) or $data['id'] < 1){
          $error="Wrong Row selected";
        }
        if(!isNum($data['meter'])){
          $error="Enter Schedule";
        }
        if(!isNum($data['forms'])){
          $error="Enter Number of forms Submitted";
        }
        if(!isNum($data['replaced']+1)){
          $error="Enter Number of forms Submitted";
        }
        if(empty($error)){
          $error = $this->metModel->updateDailyRecord($data) ? ('record updated successfully') : 'Somthing Went Wrong';
        }
        jsonEncode($error);
      }
      if(isset($_POST['deleteDailyRecordById'])){
        jsonEncode(deleteByCol(TEAM_REC_TBL,'id',escapeString($_POST['id'])));
      }
    }
    public function couple($from='',$to='',$id=''){
      if(!empty($from) AND empty($id)){
        $to=empty($to) ? $from :$to;
        $to=date('Y-m-d',strtotime(escapeString($to)));
        $from=date('Y-m-d',strtotime(escapeString($from)));
        $data=$this->metModel->loadDailyCouplingByDates($from,$to);
      }elseif(!empty($from) and !empty($to) and !empty($id)){
        $to=date('Y-m-d',strtotime(escapeString($to)));
        $from=date('Y-m-d',strtotime(escapeString($from)));
        $data=$this->metModel->loadDailyCouplingByDateId($from,$to,escapeString($id));
      }else{
        $data=$this->metModel->loadDailyCoupling();
      }
      $this->view('meters/couple',$data);
    }
    public function manageCoupling(){
      if(isset($_POST['addDailyCoupling'])){
          parse_str($_POST['form'],$_POST);$msg=$error='';
          $data=[
            'id'=>escapeString($_POST['id']),
            'spio'=>escapeString($_POST['spio']),
            'spc'=>escapeString($_POST['spc']),
            'tpio'=>isset($_POST['tpio']) ? escapeString($_POST['tpio']) : 0,
            'tpc'=>isset($_POST['tpc']) ? escapeString($_POST['tpc']) : 0,
            'date'=>escapeString($_POST['date']),
            'installerId'=>escapeString(@$_POST['sup']),
            'remark'=>escapeString($_POST['remark']),
          ];
          if(empty($data['spio'])){
            $error="Enter Single Phase Issued out";
          }
          if(empty($data['spc'])){
            $error="Enter Single Phase coupled";
          }
          if(empty($data['date'])){
            $error="Date is required";
          }
          if(empty($data['installerId'])){
            $error="Select Coupler";
          }
          if(empty($error)){
            $this->metModel->manageCoupling($data) ? $msg='success' :$error= 'Something Went Wrong!';
          }else{
            $error=prettyMsg($error,'alert-danger');
          }
          jsonEncode(['msg'=>empty($msg) ? $error : prettyMsg($msg),'error'=>$error]);
      }
      // delete entries
      if(isset($_POST['deleteDailyRecordById'])){
        jsonEncode(deleteByCol(COU_TBL,'id',escapeString($_POST['id'])));
      }
    }
    public function manageMeters(){
      if(isset($_POST['deleteCustomer'])){
        parse_str($_POST['form'],$_POST);
        $data=[
          'id'=>escapeString($_POST['id']),
          'reason'=>escapeString($_POST['reason'])
        ];
        if(!isNum($data['id'])){
          $error='Wrong Selection';
        }
        if(empty($_POST['reason'])){
          $error='State why you are deleting and Who ask you to!';
        }
        if(empty($error)){
          $error=$this->metModel->moveMeter($data) ? 'success' : 'Something Went Wrong!';
        }else{
          $error=prettyMsg($error,'alert-danger');
        }
        jsonEncode($error);
      }
    }

  }
