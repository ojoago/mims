<?php
    class Schedules extends Controller{
        public function __construct(){
          !isLoggedIn() ? redirect('pages') : '';
          $this->userModel=$this->model('Schedule');
        }

        public function index(){
           $data = ['title'=>'Scheduling','description'=>'customer'];
           $this->view('view/index', $data);
        }
        public function batch(){
           $data = ['title'=>'Batch Scheduling','description'=>'customer'];
           $this->view('schedules/batch', $data);
        }
        public function customer(){
           $data = ['title'=>'Scheduling','description'=>'customer'];
           //check for form submition
         if($_SERVER['REQUEST_METHOD']=='POST'){
            //process form
            // sanitize input
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data=[
               'accountname'=>escapeString($_POST['accountname']),
               'accountname_err'=>'',
               'accountnum'=>escapeString($_POST['accountnum']),
               'accountnum_err'=>'',
               'gsm'=>escapeString($_POST['gsm']),
               'gsm_err'=>'',
               'address'=>escapeString($_POST['address']),
               'address_err'=>'',
               'clm'=>escapeString($_POST['clm']),
               'clm_err'=>'',
               'surveystatus'=>escapeString($_POST['surveystatus']),
               'surveystatus_err'=>'',
               'ctype'=>escapeString($_POST['ctype']),
               'ctype_err'=>'',
               'state'=>escapeString($_POST['state']),
               'state_err'=>'',
               'region'=>escapeString($_POST['region']),
               'region_err'=>'',
               'kv33'=>escapeString($_POST['kv33']),
               'kv33_err'=>'',
               'feeder'=>escapeString($_POST['feeder']),
               'feeder_err'=>'',
               'dtname'=>escapeString($_POST['dtname']),
               'dtname_err'=>'',
               'dtcode'=>escapeString($_POST['dtcode']),
               'dtcode_err'=>'',
               'upriser'=>escapeString($_POST['upriser']),
               'upriser_err'=>'',
               'pole'=>escapeString($_POST['pole']),
               'pole_err'=>'',
               'metertype'=>escapeString($_POST['metertype']),
               'metertype_err'=>'',
               'date'=>escapeString($_POST['date']),
               'date_err'=>'',
               'company'=>escapeString($_POST['company']),
               'company_err'=>'',
               'asignedto'=>escapeString($_POST['asignedto']),
               'asignedto_err'=>''
         ];
         if(empty($data['accountname'])){
            $error=$data['accountname_err']='Please enter Customer name';
         }
         if(empty($data['accountnum'])){
            $error=$data['accountnum_err']="Please enter Account Number ";
         }
         if(empty($data['gsm'])){
            $error=$data['gsm_err']="Phone  Number ";
         }elseif(strlen($data['gsm'])<11){
            $error=$data['gsm_err']="Phone  Number is short";
         }
         if(empty($data['address'])){
            $error=$data['address_err']="Please enter address ";
         }
         if(empty($data['clm'])){
            $error=$data['clm_err']="Please enter closest land mark ";
         }
         if(empty($data['surveystatus'])){
            $error=$data['surveystatus_err']="Select Status ";
         }
         if(empty($data['ctype'])){
            $error=$data['ctype_err']="Select Custmer type ";
         }
         if(empty($data['state'])){
            $error=$data['state_err']="Select State ";
         }
         if(empty($data['region'])){
            $error=$data['region_err']="Select Region ";
         }
         if(empty($data['kv33'])){
            $error=$data['kv33_err']="Select 33kv feeder ";
         }
         if(empty($data['feeder'])){
            $error=$data['feeder_err']="Select 11kv feeder ";
         }
         if(empty($data['dtname'])){
            $error=$data['dtname_err']="Enter DT Name ";
         }
         if(empty($data['dtcode'])){
            $error=$data['dtcode_err']="Enter DT Code ";
         }elseif(!is_numeric($data['dtcode'])){
            $error=$data['dtcode_err']="DT Code Must be Number";
         }
         if(empty($data['upriser'])){
            $error=$data['dtcode_err']="Enter Upriser ";
         }elseif(!is_numeric($data['upriser'])){
            $error=$data['upriser_err']="Upriser Must be Number";
         }
         if(empty($data['pole'])){
            $error=$data['pole_err']="Enter Pole Number ";
         }elseif(!is_numeric($data['pole'])){
            $error=$data['pole_err']="Upriser Must be Number";
         }
         if(empty($data['metertype'])){
            $error=$data['metertype_err']='Select Meter Type';
         }
         if(empty($data['date'])){
            $error=$data['date_err']='Select Date';
         }
         if(empty($data['company'])){
            $error=$data['company_err']='Select Company';
         }
         //validate user input
         if(empty($error)){
               if($this->userModel->scheduleCustomer($data)){
                  flash('register_success','Schedule success');
                  unset($data);
                  // redirect('schedules/customer');
              }else{
                  die('Somthing Went Wrong');
              }
         }
         }else{
         //init data
            $data=[
                  'accountname'=>'',
                  'accountname_err'=>'',
                  'accountnum'=>'',
                  'accountnum_err'=>'',
                  'gsm'=>'',
                  'gsm_err'=>'',
                  'address'=>'',
                  'address_err'=>'',
                  'clm'=>'',
                  'clm_err'=>'',
                  'surveystatus'=>'',
                  'surveystatus_err'=>'',
                  'ctype'=>'',
                  'ctype_err'=>'',
                  'state'=>'',
                  'state_err'=>'',
                  'region'=>'',
                  'region_err'=>'',
                  'kv33'=>'',
                  'kv33_err'=>'',
                  'feeder'=>'',
                  'feeder_err'=>'',
                  'dtname'=>'',
                  'dtname_err'=>'',
                  'dtcode'=>'',
                  'dtcode_err'=>'',
                  'upriser'=>'',
                  'upriser_err'=>'',
                  'pole'=>'',
                  'pole_err'=>'',
                  'metertype'=>'',
                  'metertype_err'=>'',
                  'date'=>'',
                  'date_err'=>'',
                  'company'=>'',
                  'company_err'=>'',
                  'asignedto'=>'',
                  'asignedto_err'=>''
            ];
         }
           $this->view('schedules/customer', $data);
        }
        // asign single customer to installer
        public function asignCustomer(){
          parse_str($_POST['form'],$_POST);
          $cust=isNum(escapeString($_POST['customer_id']));
          $cmp=isNum(escapeString($_POST['company']));
          if(isset($_POST['asignedto']) and !empty($_POST['asignedto']))
            $to=isNum(escapeString($_POST['asignedto']));
          else
            $to=0;
          if(!empty($cust) and !empty($cmp)){
              echo ($this->userModel->asignCompany($cust,$cmp,$to)) ? 'success' : 'Somthing Went Wrong';
          }else{echo"Somthing Went Wrong";}
        }
        public function batchAsignCustomer(){
            $cmp=isNum(escapeString($_POST['company']));
            if(isset($_POST['installer']) and !empty($_POST['installer']))
              $to=isNum(escapeString($_POST['installer']));
            else
              $to=0;
              if(!empty($cmp)){
                foreach($_POST['batch'] as $cust){
                    $msg= ($this->userModel->asignCompany($cust,$cmp,$to)) ? 'success' : 'Somthing Went Wrong';
                }
              }else{
                $msg="Somthing Went Wrong!";
              }
              echo $msg;
        }

        // install meter method
        public function meter($id=0){
          if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
              'custId'=>trim($_POST['custid']),
              'doi'=>trim($_POST['doi']),
              'eid'=>'',
              'preload'=>trim($_POST['preload']),
              'seal'=>trim($_POST['seal']),
              'meterNumber'=>trim($_POST['meterNumber']),
              'edatNum'=>trim($_POST['edatNum']),
              'tariff'=>trim($_POST['tariff']),
              'advtariff'=>trim($_POST['advtariff']),
              'status'=>trim($_POST['status']),
              'meterfoto'=> (!empty($_FILES['meterfoto']['tmp_name'])) ? $_FILES['meterfoto']['name'] : '',
              'remark'=>trim($_POST['remark']),
              'latitude'=>trim($_POST['latitude']),
              'longitude'=>trim($_POST['longitude'])
            ];
            if(empty($data['doi'])){
              $data['doi_err']="Enter Date";
            }
            if(empty($data['preload'])){
              $data['preload_err']="Enter preload Unit";
            }
            if(empty($data['meterNumber'])){
              $data['mt_err']="Enter Meter Number";
            }elseif(strlen($data['meterNumber']) < METER_LENGTH){
              $data['mt_err']="Enter Correct Meter Number";
            }elseif(findByCol(MET_TBL,'meternum',$data['meterNumber'])){
              $data['mt_err']="Meter Exist";
            }
            if(empty($data['edatNum'])){
              $data['edat_err']="Enter Edata Number Correctly";
            }
            if(empty($data['tariff'])){
              $data['tariff_err']="Select Tariff";
            }
            if(empty($data['advtariff'])){
              $data['advtariff_err']="Select advised Tariff";
            }
            if(empty($data['remark'])){
              $data['remark_err']="Enter remark";
            }
            if(empty($data['status'])){
              $data['status_err']="Enter status";
            }
            if(empty($data['latitude'])){
              $data['latitude_err']="Enter latitude";
            }
            if(empty($data['longitude'])){
              $data['longitude_err']="Enter longitude";
            }
            if(empty($data['doi_err']) and empty($data['preload_err']) and empty($data['mt_err']) and empty($data['edat_err']) and
              empty($data['tariff_err']) and empty($data['advtariff_err']) and empty($data['remark_err']) and empty($data['latitude_err'])
              and empty($data['longitude_err']) and empty($data['seal_err']) and empty($data['status_err'])){
                $data['eid']=$this->userModel->edatId($data['edatNum']);
                if($this->userModel->scheduleMeter($data)){
                   !empty($_FILES['meterfoto']['tmp_name']) ? $this->extractImg($_FILES['meterfoto']['name'],$_FILES['meterfoto']['tmp_name']) : '';
                   $installDetails = array(
                     "sealNo"=>$data['seal'],
                     "meterNo"=>$data['meterNumber'],
                     "account"=>getValue(CUSTOMER_TBL,'accountnumber',$data['custId']),
                     "date"=> $data['doi'],
                     "key"=>"50105772d8f5ae251c1add6f26ef205f"
                   );
                  echo  $msg=Restapi::installationDetails($installDetails);
                    flash('register_success',$msg);
                   unset($data);
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
              'edatNum'=>'',
              'edat_err'=>'',
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
            ];
          }
           $this->view('schedules/meter', $data);
        }

    }
