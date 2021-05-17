<?php
  /**
   *
   */
  class Apis extends Controller {
    protected $paymentURL= "https://jedecosystem.com/map/api/payConfirmation/index.php";//payment confirmation from payment gateway
    protected $detailsURL="https://jedecosystem.com/map/api/installationDetails/index.php";//Installation confirmation from filed
    protected $remitaURL="https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
    public function __construct(){
     $this->apiModel=$this->model('Api');
    }
    //confirmation payment from remita
    public function installationschedule(){
      $this->requestMethod($_SERVER['REQUEST_METHOD'],'POST');
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      header('Access-Control-Allow-Methods: POST');
      header('Access-Control-Allow-headers: Access-Control-Allow-headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-with');
      // get the posted data
      $post=json_decode(file_get_contents('php://input'));
      if(@$post->key=='1234k'){
      $data=[
            'accountno'=>escapeString($post->accountno),
            'accountname'=>escapeString($post->accountname),
            'address'=>escapeString($post->address),
            'phone'=>escapeString($post->phone),
            'region'=>escapeString($post->region),
            'area'=>escapeString($post->area),
            'feeder'=>escapeString($post->feeder),
            'dt'=>escapeString($post->dt),
            'metertype'=>escapeString($post->metertype),
            'date'=>escapeString($post->paymentconfirmationdate),
            'duration'=>escapeString($post->duration)
          ];
          $error=[];
          if(empty($data['accountno'])){
            $error['accountno_err']='missing account number';
          }
          if(empty($data['accountname'])){
            $error['accountname_err']='account name missing';
          }
          if(empty($data['address'])){
            $error['address_err']='customer address is missing';
          }
          if(empty($data['region'])){
            $error['region_err']='region is missing';
          }
          if(empty($data['feeder'])){
            $error['feeder_err']='feeder is missing';
          }
          if(empty($data['dt'])){
            $error['dt_err']='DT name is missing';
          }
          if(empty($data['metertype'])){
            $error['metertype_err']='meter type';
          }
          if(empty($data['phone'])){
            $error['phone_err']='missing phone number';
          }elseif(strlen($data['phone'])<11){
            $error['phone_err']='incorrect phone number';
          }
          if(empty($error)){
            $row=$this->apiModel->findByAccount($data['accountno']);
            if(!$row){
              if($this->apiModel->scheduleCustomer($data)){
                $this->response(['status'=>'success','message'=>'schedule created']);
              }else{
                $this->response(['status'=>'failed','message'=>'something went wrong']);
              }
            }else{
              unset($row->id);
              unset($row->edited_on);
              unset($row->dayscount);
              $this->response(['message'=>'customer with this account number exist','info'=>$row]);}
          }else{
            $this->throwError(VALIDATE_PARAMETER_REQUIRED,$error);
          }
      }else{
        $this->throwError(ACCESS_TOKEN_ERRORS,'invalid key');
      }
    }


    public function updatecustomerstatus(){
      $this->requestMethod($_SERVER['REQUEST_METHOD'],'PUT');
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      header('Access-Control-Allow-Methods: POST');
      header('Access-Control-Allow-headers: Access-Control-Allow-headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-with');
      // get the posted data
      $post=json_decode(file_get_contents('php://input'));
      if(@$post->key=='1234k'){
      $data=[
            'id'=>escapeString($post->id),
            'status'=>escapeString($post->status)
          ];
          $error=[];
          if(empty($data['id'])){
            $error['id_err']='wrong parameter';
          }elseif(!is_numeric($data['id'])){
            $error['id_err']='Wrong id number';
          }
          if(empty($data['status'])){
            $error['status_err']='status is missing';
          }
          if(empty($error)){
            $row=$this->apiModel->findById($data['id']);
            if($row){
              if($this->apiModel->updateCustomerStatus($data)){
                $this->response(['status'=>'success','message'=>'status updated']);
              }else{
                $this->response(['status'=>'failed','message'=>'something went wrong']);
              }
            }else{
              $this->response(['status'=>'failed','message'=>'wrong customer id supplied']);}
          }else{
            $this->throwError(VALIDATE_PARAMETER_REQUIRED,$error);
          }
      }else{
        $this->throwError(ACCESS_TOKEN_ERRORS,'invalid key');
      }
    }


    protected function requestMethod($method,$type){
      if($method !== $type){
        $this->throwError(REQUEST_METHOD_NOT_VALID,'Request method not valid');
        exit;
      }
    }

    private function validateRequest($type){
      if(header('Content-Type') != $type){
        $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID,'Request content type not valid');
        exit;
      }
    }

    protected function throwError($code,$msg){
      $this->response(['error'=>['status'=>$code,'message'=>$msg]]);
    }

    function response($msg){
      echo json_encode(array('response'=>$msg));
    }

  }
