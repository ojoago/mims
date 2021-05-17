<?php
 class Faults extends Controller{
   public function __construct(){
     isLoggedIn() ?: redirect('pages');
     $this->faultModel=$this->model('Fault');
   }
    public function asignMeter(){
      if(isset($_POST['asignMeter'])){
        parse_str($_POST['form'],$_POST);
        $met=[
          'did'=>escapeString($_POST['meterID']),
          'cmp'=>escapeString(@$_POST['company']),
          'installer'=>escapeString(@$_POST['installer']),
          'device'=>'meter'
        ];
        if(!empty($met['did'])){
          if($this->faultModel->asignFaultyMeter($met)){
            reportLog('asigned faulty meter',lastID());
            // send mail
            // if not asigned to installer then mail company
            echo "success";
          }else{
            echo "Failed To asign!";
          }
        }else{
          echo "Something Went Wrong";
        }
      }
   }
   public function fixMeter(){
     if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data=[
          'oldseal'=>'',
          'oldmeter'=>'',
          'error'=>'',
          'id'=>escapeString($_POST['fixMeterId']),
          'seal'=>strtoupper(escapeString($_POST['newseal'])),
          'fault'=>escapeString(@$_POST['fault']),
          'newmeter'=>escapeString(@$_POST['newmeter']),
          'status'=>escapeString(@$_POST['status']),
          'solution'=>escapeString($_POST['solution']),
          'date'=>escapeString($_POST['date']),
          'installer'=>escapeString($_POST['installer']),
          'meterfoto'=> (!empty($_FILES['meterfoto']['tmp_name'])) ? $_FILES['meterfoto']['name'] : ''
        ];
        if(empty($data['status'])){
          $data['error']="select status";
        }
        if($data['status']=='Replacement' and empty($data['newmeter'])){
          $data['error']='Enter new meter Number';
        }elseif($data['status']=='Replacement'){
          if(!isNum($data['newmeter'])){
            $data['error']="Meter number must be number!";
          }elseif(!maxLength($data['newmeter'])) {
            $data['error']="T7 Meter Number is 11 digit";
          }elseif(findByCol(INSTALL_MET_TBL,'meter_no',$data['newmeter'])){
            $data['error']="New Meter Number already exist";
          }
          elseif(!findByCol(MET_NUM_TBL,'number',$data['newmeter'])){
            $data['error']="New Meter Number is not in our record!!!";
          }
        }

        if(!maxLength($data['seal'],6)){
          $data['error']="Enter seal Number correctly";
        }
        if(empty($data['fault'])){
          $data['error']="select Source/fault";
        }
        if(empty($data['solution'])){
          $data['error']="Enter recommendation";
        }
        if(empty($data['date'])){
          $data['error']="Enter Date";
        }
        if(empty($data['meterfoto'])){
          $data['error']="picture is compulsary";
        }
        if(empty($data['error'])){
          $this->faultModel->reportFault($data);
          $mns=$this->faultModel->findMetandSeal($data['id']);
          if($mns){
            $data['oldseal']=$mns->seal_number;
            $data['oldmeter']=$mns->meter_no;
            if($this->faultModel->fixfaultyMeter($data)){
                $data['error']='updated but issue not solved';
              if($data['status']=='Resolved'){
                  if($this->faultModel->updateSealNStatus($data['id'],$data['seal'],$data['status'])){
                    $data['error']='success';
                  }
              }
              !empty($_FILES['meterfoto']['tmp_name']) ? $this->extractImg($_FILES['meterfoto']['name'],$_FILES['meterfoto']['tmp_name']) : '';
              if(!empty($data['newmeter']) and $data['status']=='Replacement'){
                if($this->faultModel->updateMeterNumber($data['id'],$data['newmeter'])){
                  $data['error']="success";
                }else{$data['error']="could not update new meter number";}
              }
              reportLog(" " .$data['solution'] .", ". $data['fault'] ." ". $data['oldmeter'] ." ",$data['id']);
            }else{$data['error']="Failed to update";}
          }else{$data['error']="Somthing Went Wrong";}
        }
      }
      jsonEncode($data['error']);
   }
   // asign fualty edat to install or company
   public function asignEdat(){
     if(isset($_POST['asignedto'])){
       parse_str($_POST['form'],$_POST);
       $met=[
         'did'=>escapeString($_POST['edat_id']),
         'cmp'=>escapeString(@$_POST['company']),
         'installer'=>escapeString(@$_POST['asignedto']),
         'device'=>'edat'
       ];
       if(!empty($met['did'])){
         if($this->faultModel->asignFaultyEdat($met)){
           reportLog('asigned faulty edat',lastID());
           // send mail
           // if not asigned to installer then mail company
           echo "success";
         }else{
           echo "Failed To asign!";
         }
       }else{
         echo "Something Went Wrong";
       }
     }
   }

   public function fixEdat(){
     if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

      $data=[
          'eid'=>escapeString($_POST['eid']),
          'fault'=>escapeString(@$_POST['fault']),
          'status'=>escapeString(@$_POST['status']),
          'seal'=>escapeString($_POST['seal']),
          'solution'=>escapeString($_POST['solution']),
          'edatnum'=>escapeString(@$_POST['edatnum']),
          'date'=>escapeString(@$_POST['date']),
          'oldsel'=>'',
          'oldedat'=>'',
          'error'=>'',
          'foto'=> (!empty($_FILES['edatfoto']['tmp_name'])) ? rand(10,1000) . $_FILES['edatfoto']['name'] : ''
      ];
        if(empty($data['eid'])){
          $data['error']="Something is Wrong";
        }
        if(empty($data['fault'])){
          $data['error']="Select edats faults";
        }
        if(empty($data['status'])){
          $data['error']="Select Status";
        }
        if($data['status']=='Replacement' and (empty($data['edatnum']) or !isNum($data['edatnum']))){
          $data['error']="Enter New edat number correctly";
        }
        if(empty($data['seal'])){
          $data['error']="Enter seal number";
        }
        elseif(!isNum($data['seal'])){
          $data['error']="Enter new number";
        }
        if(empty($data['date'])){
          $data['error']="Enter date";
        }
        if(empty($data['error'])){
          $sed=$this->faultModel->findedatandSeal($data['eid']);
          $data['oldedat']=$sed->edatnumber;
          $data['oldseal']=$sed->seal;
          if($this->faultModel->fixfaultyEdat($data)){
            reportLog(" " .$data['solution'] .", ". $data['fault'] ." ". $data['oldsel'] ." ",$data['eid']);
            if($this->faultModel->updateEdatInfo($data['eid'],$data['seal'],$data['status'])){
              $data['error']="success";
            }
            !empty($_FILES['edatfoto']['tmp_name']) ? $this->extractImg($data['foto'],$_FILES['edatfoto']['tmp_name']) : '';
            if($data['status'] =='Replacement'){
              if($this->faultModel->updateEdatNumber($data['eid'],$data['edatnum'])){
                $data['error']="success";
              }else{$data['error']="Somthing went wrong while updating edat Number";}
            }
          }
        }
      }
      echo $data['error'];
   }

 }
