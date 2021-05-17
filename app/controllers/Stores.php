<?php
/**
 *
 */
class Stores extends Controller{

  public function __construct(){
    isLoggedIn() ?: redirect('pages');
    $this->strModel= $this->model('Store');
  }

  public function index($id=0){
    if($id>0){
      $id=escapeString($id);
      $data['store']=$this->strModel->loadAllStore();
      $data['storeName']=$this->strModel->storeName($id);
      $data['item']=$this->strModel->loadSingleStoreItems($id);
    }else{
      $data['storeName']='all Store Items';
      $data['store']=$this->strModel->loadAllStore();
      $data['item']=$this->strModel->loadAllStoreItems();
    }
    $this->view('stores/index', $data);
  }

  public function request(){
    $this->view('stores/request', $data=[]);
  }
  public function processRequest(){
    if(isset($_POST['userItemRequest'])){
      $error="Select at least one item";$id='';
      if(isset($_SESSION['sr_in'])) {
        $error="";
        $data['store']=escapeString($_POST['store']);
        parse_str($_POST['form'],$_POST);
        $data['remark']=escapeString($_POST['remark']);
        $data['receiver']=escapeString($_POST['to']);
        if(empty($data['store']) or !isNum($data['store'])){
          $error="Select Store";
        }
        if(empty($data['receiver']) or !isNum($data['receiver'])){
          $error="Select Receiver";
        }
        if(empty($error)){
          $data['requestId']=$this->wayBillId();
          $this->strModel->addRequestInfo($data);
          foreach($_SESSION['sr_in'] as $key => $value){
            $this->strModel->addRequestItems($data['requestId'],$_SESSION['sr_in'][$key]['id'],$_SESSION['sr_in'][$key]['qnt']);
          }
          //$id=$data['requestId'];
          $requestList=$this->strModel->fetchRequestItem($data['requestId']);
          if($requestList){
            $list=decodeHtmlEntity($requestList[0]->uid).' has requested for the following item(s)<br>';$n=0;
            foreach($requestList as $row){
              $list.=++$n .' -- #'.$row->qnt.' Quantity of '.$row->name.'<br>';
              $to=$row->manager_id;
              $rcb=$row->receiver;
            }
            reportLog(UID().' Request for item(s) '.$data['requestId']);
            $list.='to be delivered to '.decodeHtmlEntity(getUsername($rcb));
            smtpmailer(idToMail($to),'Request Notification '.$data['requestId'],$list);
          }
          unset($_SESSION['sr_in']);
        }else{
          $error=prettyMsg("Select at least one item",'alert-danger');
        }
      }
      jsonEncode(['error'=>$error,'id'=>@$data['requestId']]);
    }
    if(isset($_POST['updateRequestItem'])){
      $id=escapeString($_POST['id']);
      $rid=escapeString($_POST['rid']);
      $qnt=escapeString($_POST['qnt']);
      $this->confirmQnt($id,$qnt);
      if($this->strModel->getItemStatus($rid)){
        $this->strModel->updateRequestQnt($id,$rid,$qnt) ? jsonEncode(prettyMsg('Quantity updated')) : jsonEncode(prettyMsg('Something Went Wrong','alert-warning'));
        reportLog(UID().' update requsted items quantity '.$rid);
      }else{
        jsonEncode(prettyMsg('Already Treated','alert-warning'));
      }
    }
    // reove an item from request
    if(isset($_POST['removeItemFromRequest'])){
      $rid=escapeString($_POST['rid']);
      $id=escapeString($_POST['id']);
      if($this->strModel->getItemStatus($rid)){
        jsonEncode($this->strModel->removeItemFromRequest($id,$rid));
        reportLog(UID().' remove requsted item '.$rid);
      }
    }
    // delete request

    // aproving request
    if(isset($_POST['approveRequest'])){
      $rid=escapeString($_POST['id']);
      $details=$this->strModel->getRequestDetail($rid);
      $data=[
          'rqs'=>$details->uid,
          'apv'=>$details->uid,
          'rcb'=>getUsername($details->receiver),
          'dept'=>'internal',
          'unit'=>'internal',
          'date'=>toDay(),
          'remark'=>$details->comment,
          'wbid'=>$rid,
          'type'=>'SR-CN',
          'to'=> $details->store,
          'from'=>$details->store,
      ];
      $rowSet=$this->strModel->getRequestItems($rid);$error="request List is empty";
      if($rowSet){
        $error='';
        if(!confirmStoreManager($data['to'])){
          $error='You are not the Store Manager';
        }
        if(empty($error)){
          $this->strModel->wayBillLog($data);
          foreach($rowSet as $row) {
            $this->strModel->processData($row->pid,$data['to'],$row->qnt,$data['wbid'],$data['type']);
          }
          $this->strModel->updateRequestStatus($data['wbid']);
          $rqs=$this->strModel->fetchRequestItem($data['wbid']);
          reportLog(UID().' Approved requsted '.$data['wbid']);
          smtpmailer(idToMail($rqs[0]->request_by),'Aproval Notification'.$data['wbid'],'Your your item request with '.$data['wbid'].' id has being approved');
        }
      }
      jsonEncode(['id'=>$data['wbid'],'error'=>$error]);
    }
  }
  public function myrequest($id=''){
    $data['myRequest']=$this->strModel->myRequest();
    if(!empty($id)){
      $data['requestDetail']=$this->strModel->requestDetail(escapeString($id));
    }
    $this->view('stores/myrequest',$data);
  }
  public function requestlist($id=''){
    redirectAccess('requestlist');// redirect if access not granted
    $data['list']=$this->strModel->requestList();
    if(!empty($id)){
      $data['deatils']=$this->strModel->requestDetail(escapeString($id));
    }
    $this->view('stores/requestlist',$data);
  }
  public function loadItem(){
    if(isset($_POST['loadSRINItemDetails'])){
      if(isset($_SESSION["sr_in"])){
        $i=0;
        foreach($_SESSION['sr_in'] as $key => $value) {
          if($_SESSION['sr_in'][$key]['id']==$_POST['id']){
            if(strtoupper($_POST['cat'])!='SR-IN'){
              $this->confirmQnt($_SESSION['sr_in'][$key]['id'],$_SESSION['sr_in'][$key]['qnt']+1);
            }
            $_SESSION['sr_in'][$key]['qnt']+=1;
            $i++;
          }
        }
        if($i<1){
          if(strtoupper(@$_POST['cat'])!='SR-IN'){
            $this->confirmQnt(escapeString($_POST['id']),1);
          }
          $data=['id'=>escapeString($_POST['id']),'qnt'=>1];
          $_SESSION["sr_in"][]=$data;
        }
      }else{
        if(strtoupper(@$_POST['cat'])!='SR-IN'){
          $this->confirmQnt(escapeString($_POST['id']),1);
        }
        $data=['id'=>escapeString($_POST['id']),'qnt'=>1,'cmt'=>''];
        $_SESSION["sr_in"][]=$data;
      }
    }
    if(isset($_POST['updateQnt'])){
			foreach($_SESSION["sr_in"] as $key => $value){
        if($_SESSION["sr_in"][$key]['id'] == escapeString($_POST["id"])){
            if(isset($_POST['cat']) AND strtoupper(@$_POST['cat'])!='SR-IN'){
                $this->confirmQnt(escapeString($_POST['id']),escapeString($_POST["qnt"]));
              }
            $_SESSION["sr_in"][$key]['qnt'] = escapeString($_POST["qnt"]);
        }
      }
		}
    if(isset($_POST['addComment'])){
			foreach($_SESSION["sr_in"] as $key => $value){
        if($_SESSION["sr_in"][$key]['id'] == escapeString($_POST["id"])){
            $_SESSION["sr_in"][$key]['cmt'] = escapeString($_POST["txt"]);
        }
      }
		}

    if(isset($_POST['removeItem'])){
      foreach($_SESSION['sr_in'] as $key => $value){
        if($_SESSION['sr_in'][$key]['id']==$_POST['id']){
          if($value["id"] == $_POST["id"]){
               unset($_SESSION["sr_in"][$key]);
          }
        }
      }
    }

    if(isset($_POST['loadItemAdded']) and isset($_SESSION['sr_in'])){
      foreach($_SESSION["sr_in"] as $row) {
          $this->loadItemDetails($row['id'],$row['qnt'],@$row['cmt']);
      }
    }
    if(isset($_POST['processData']) and isset($_SESSION['sr_in'])){
        foreach($_SESSION["sr_in"] as $row) {
          $this->strModel->addtoStore($row['id'],1,$row['qnt']);
        }
    }

    if(isset($_POST['processWayBill'])){
      $id=$error='';
      $type=escapeString(@$_POST['type']);
      $from=escapeString(@$_POST['from']);
      parse_str($_POST['form'],$_POST);
      $data=[
          'rqs'=>escapeString($_POST['rqs']),
          'apv'=>escapeString($_POST['apv']),
          'rcb'=>escapeString($_POST['rcb']),
          'dept'=>escapeString($_POST['dept']),
          'unit'=>escapeString($_POST['unit']),
          'date'=>escapeString($_POST['date']),
          'remark'=>escapeString($_POST['remark']),
          'wbid'=>$this->wayBillId(),
          'type'=>$type,
          'to'=> $type=='SR-IN' ? escapeString(@$_POST['to']) : $from,
          'from'=>$from,
      ];
      if(empty($data['to'])){
        $error='Select Destination Store!!!';
      }
      if(empty($data['type'])){
        $error='Go back and Select Category First!!!';
      }elseif($data['type']=='SR-CN'){
        if(empty($data['from'])){
          $error='Go back and Select Source Store!!!';
        }
      }
      if(empty($data['date'])){
        $error='Select Date!';
      }
      if(empty($data['rqs'])){
        $error='Enter name of Request person';
      }
      if(empty($data['apv'])){
        $error='Enter name of Approver';
      }
      if(empty($data['apv'])){
        $error='Enter name of Approver';
      }
      if(empty($data['rcb'])){
        $error='Enter name of Receiver';
      }
      if(empty($error)){
        if(isset($_SESSION['sr_in'])){
          $this->strModel->wayBillLog($data);
          foreach($_SESSION["sr_in"] as $row) {
            $this->strModel->processData($row['id'],$data['to'],$row['qnt'],$data['wbid'],$data['type'],@$row['cmt']);
          }
        }
        unset($_SESSION['sr_in']);
      }else {
        $error = prettyMsg($error,'alert-danger');
      }
      jsonEncode(['id'=>$data['wbid'],'error'=>$error]);
      //print_r($data);
    }


  }


  private function wayBillId(){
    return strtoupper(date('yMdHis'));
  }
  public function waybill($id=0){
    $data['data']=$this->strModel->wayBillDetails($id);
    $data['info']=$this->strModel->wayBillInfo($id);
    $this->view('stores/print',$data);
  }
  public function lend($id=0){
    $data=$this->strModel->loadMyStore();
    $this->view('stores/lend',$data);
  }
  public function manageLend(){
    if(isset($_POST['addItem'])){
      $this->confirmQnt(escapeString($_POST['id']),escapeString($_POST['qnt']));
      if(isset($_SESSION["lend_cart"])){
        $i=0;
        foreach($_SESSION['lend_cart'] as $key => $value) {
          if($_SESSION['lend_cart'][$key]['id']==$_POST['id']){
            $_SESSION['lend_cart'][$key]['qnt']=escapeString($_POST['qnt']);
            $i++;
          }
        }
        if($i<1){
          $data=['id'=>escapeString($_POST['id']),'qnt'=>escapeString($_POST['qnt'])];
          $_SESSION["lend_cart"][]=$data;
        }
      }else{
        $data=['id'=>escapeString($_POST['id']),'qnt'=>escapeString($_POST['qnt'])];
        $_SESSION["lend_cart"][]=$data;
      }
    }

    if(isset($_POST['removeItem'])){
      foreach($_SESSION['lend_cart'] as $key => $value){
        if($_SESSION['lend_cart'][$key]['id']==$_POST['id']){
          if($value["id"] == $_POST["id"]){
               unset($_SESSION["lend_cart"][$key]);
               printMsg('removed');
          }
        }
      }
    }
    // load lend session item
    if(isset($_POST['loadItem'])){
      if(isset($_SESSION['lend_cart'])){
        foreach($_SESSION['lend_cart'] as $row){
          $this->lendableDetails(escapeString($row['id']),escapeString($row['qnt']));
        }
      }
    }

    if(isset($_POST['processLendFrom'])){
      parse_str($_POST['from'],$_POST);$msg=$error='';
      $data=[
        'cdate'=>escapeString($_POST['cdate']),
        'rdate'=>escapeString($_POST['rdate']),
        'remark'=>escapeString($_POST['remark']),
        'clt'=>escapeString(@$_POST['clt']),
        'lid'=>$this->lendId()
      ];
      if(empty($data['cdate'])){
        $error='Select Date';
      }
      if(empty($data['clt'])){
        $error='Select Staff collecting';
      }
      if(empty($error)){
        if(isset($_SESSION['lend_cart'])){
          $this->strModel->processLend($data);
            foreach($_SESSION['lend_cart'] as $row){
              $this->strModel->processingLendItem(escapeString($row['id']),$data['lid'],escapeString($row['qnt']));
            }
            unset($_SESSION['lend_cart']);
        }
      }else {
        $error=prettyMsg($error,'alert-danger');
      }
      jsonEncode(['error'=>$error,'id'=>$data['lid']]);
    }
  }
  private function lendId(){
    return strtoupper(date('yMdhis'));
  }
  private function confirmQnt($id,$qnt){
    $q= $this->strModel->confirmQnt($id);
    if($qnt > $q){
      printMsg('Only '.$q .' Remaining','alert-danger');
    }

  }
  private function lendableDetails($id,$qnt){
    $row=$this->strModel->lendableDetails($id);$r='';
    if($row){
      $r='
      <div class="pt-2 row">
        <div class = "col-1">
          <i class="fa fa-minus-square bg-primary text-light p-1 removeItem pointer" id="'.$id.'" ></i>
        </div>
        <div class ="col-11">
          <span>Qnt: '.$qnt.' Name: '.$row->name.' Store : '.$row->store.' </span>
        </div>
      </div>';
    }
    echo $r;
  }
  private function loadItemDetails($id,$qnt,$txt=''){
    $r='';
    $row=$this->strModel->loadItemDetails($id);
    if($row){
      echo $r.='
      <div class="pt-2 row">
        <div class = "col-3">
          <div class="form-group input-group">
          <i class="fa fa-minus-square bg-primary text-light p-2 input-group-append removeItem pointer" id="'.$id.'" ></i>
          <input type = "number" placeholder="quantity" class = "form-control form-control-sm itemQnt" value="'.$qnt.'" id="'.$id.'">
          </div>
        </div>
        <div class ="col-9">
          <span>Name: '.$row->name.' Dsc: '.$row->dsc.' </span>
          <input type = "text" placeholder="comment" class = "form-control form-control-sm itemComment" id="'.$id.'" value="'.$txt.'">
        </div>
      </div>';
    }

    //jsonEncode($r);
  }

  public function waybills($id=0){
    $data=[];
    $this->view('stores/waybill', $data);
  }
  public function lendlist($id=''){
    if(!empty($id)){
      $data['details']=$this->strModel->loadLendDetail(escapeString($id));
    }
    $data['lid']=$this->strModel->itemLend();
    $this->view('stores/lendlist',$data);
  }
  public function create(){
    $error=$msg='';
    // create new store start here
    if(isset($_POST['createStore'])){
      parse_str($_POST['form'],$_POST);
      $data=[
            'name'=>escapeString($_POST['store']),
            'address'=>escapeString($_POST['address']),
            'id'=>escapeString(@$_POST['manager']),
            'sid'=>escapeString($_POST['sid']) ?? '',
          ];
      if(empty($data['name'])){
        $error='Enter Store name';
      }
      if(empty($data['address'])){
        $error='Enter Store address';
      }
      if(empty($data['id']) or !isNum($data['id'])){
        $error='Select Store Manager';
      }
      if(empty($data['sid'])){
        if(findByCol(STORE_TBL,'name',$data['name'])){
          $error='Store with same name already eixst!';
        }
      }
      if(empty($error)){
        if(empty($data['sid'])){
          $msg=$this->strModel->createStore($data) ? 'Store Created': 'Something Went Wrong!';
        }else{
          $msg=$this->strModel->editStore($data) ? 'Store Updated': 'Something Went Wrong!';
        }
      }
      jsonEncode(['error'=>prettyMsg($error,'alert-danger'),'msg'=>$msg]);
    }
    // create new store stop here

    // load store for editing
    if(isset($_POST['editStore'])){
      jsonEncode($this->strModel->loadStoreById(escapeString($_POST['id'])));
    }

    // create new item Instance
    if(isset($_POST['createNewItem'])){
      parse_str($_POST['form'],$_POST);
      $data=[
            'brand'=>escapeString($_POST['brand']),
            'batch'=>escapeString($_POST['batch']),
            'unit'=>escapeString(@$_POST['unit']),
            'dsc'=>escapeString($_POST['dsc']),
      ];
      if(empty($data['brand'])){
        $error="Enter name of item";
      }
      if(empty($data['batch'])){
        $error="Enter item ID";
      }
      if(empty($data['unit'])){
        $error="Select unit of mesurement";
      }
      if(empty($data['dsc'])){
        $error="Enter Item description";
      }
      if(empty($error)){
        $msg=$this->strModel->createItem($data) ? 'Item Created': 'Something Went Wrong!';
      }
      jsonEncode(['error'=>prettyMsg($error,'alert-danger'),'msg'=>$msg]);
    }

  }

  public function sr_in($id=0){
    redirectAccess('sr_in');// redirect if access not granted
    $data['sr_in']=$this->strModel->sr_in($id);
    $this->view('stores/sr_in',$data);
  }
  public function sr_cn($id=0){
    redirectAccess('sr_cn');// redirect if access not granted
    $data['sr_cn']=$this->strModel->sr_cn($id);
    $this->view('stores/sr_cn',$data);
  }
}
