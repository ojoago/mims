<?php
    class Inventories extends Controller{
        public function __construct(){
          isLoggedIn() ?: redirect('pages');
          $this->inventModel=$this->model('Inventory');
        }

        public function index($id=0){
          $data['storeName']='all Store Items';
          $data['store']=$this->inventModel->loadAllStore();
          $data['item']=$this->inventModel->loadAllStoreItems();
          $this->view('inventory/index', $data);
        }
        public function inOutWayBill(){
          if(isset($_POST['wayBillItems'])){
            parse_str($_POST['form'],$_POST);
            $error='';
            $waybill=[
              'rqs'=>escapeString($_POST['rqs']),
              'apv'=>escapeString($_POST['apv']),
              'rcb'=>escapeString($_POST['rcb']),
              'unit'=>escapeString($_POST['unit']),
              'dept'=>escapeString($_POST['dept']),
              'date'=>escapeString($_POST['date']),
              'remark'=>escapeString($_POST['remark']),
              'cat'=>escapeString(@$_POST['cat']),
              'to'=>escapeString(@$_POST['to']),
              'waybill'=>$this->wayBillId(),
              'id'=>@$_POST['id'],
              'qnt'=>@$_POST['qnt']
            ];
            if(empty($waybill['rqs'])){
              $error="Enter Request by";
            }
            if(empty($waybill['apv'])){
              $error="Enter Approved by";
            }
            if(empty($waybill['rcb'])){
              $error="Enter Received by";
            }
            if(empty($waybill['unit'])){
              $error ="Enter Unit";
            }
            if(empty($waybill['dept'])){
              $error="Enter Department";
            }
            if(empty($waybill['date'])){
              $error="Select Date";
            }
            // if(empty($waybill['remark'])){
            //   $error="Enter Remark";
            // }
            if(empty($waybill['id'])){
              $error="Select one item at least ";
            }
            if(empty($waybill['qnt'])){
              $error="Select one item at least ";
            }
            if(empty($waybill['to'])){
              $error="Select Store";
            }
            if(!confirmStoreManager($waybill['to'])){
              $error='You are not the Store Manager';
            }
            if(empty($error)){
              $i = @count($waybill['id']);
              if($this->inventModel->inOutWayBill($waybill)){
                if($i > 0){
                  $n=0;
                  while($n < $i){
                      $this->inventModel->logFromStore($waybill['waybill'],escapeString($_POST['id'][$n]),escapeString($_POST['qnt'][$n]),escapeString($_POST['old'][$n]),$waybill['cat']);
                    $n++;
                    $error="success";
                  }
                }else{$error= "Select atleast  one item";}
              }else{$error= "Failed to create waybill";}
            }
            jsonDecode(array('msg'=>$error,'waybill'=>$waybill['waybill']));
          }
        }
        public function waybills(){
          if($_SERVER['REQUEST_METHOD']=='POST'){
             $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
             $data=[
               'cat'=>escapeString(@$_POST['cat']),
               'cat_err'=>'',
               'date'=>escapeString($_POST['date']),
               'date_err'=>'',
               'qnt'=>escapeString($_POST['qnt']),
               'qnt_err'=>'',
               'to'=>escapeString(@$_POST['to']),
               'to_err'=>'',
               'rqs'=>escapeString($_POST['rqs']),
               'rqs_err'=>'',
               'apv'=>escapeString($_POST['apv']),
               'apv_err'=>'',
               'rcv'=>escapeString($_POST['rcv']),
               'rcv_err'=>'',
               // 'store'=>escapeString($_POST['store']),
               // 'store_err'=>'',
               'unit'=>escapeString($_POST['unit']),
               'unit_err'=>'',
               'dept'=>escapeString($_POST['dept']),
               'dept_err'=>'',
               'rmk'=>escapeString($_POST['rmk']),
               'rmk_err'=>''
             ];

             if(empty($data['date'])){
               $error=$data['date_err']="Select Date";
             }
             if(empty($data['qnt'])){
               $error=$data['qnt_err']="Enter Quantity";
             }elseif(!isNum($data['qnt'])){
               $error=$data['qnt_err']="Enter Quantity Correctly!";
             }
             if(empty($data['to'])){
               $error=$data['to_err']="Select Store";
             }elseif($this->inventModel->storeManager($data['to'])!=base64_decode($_SESSION['mimsUserId'])){
                $error=$data['to_err']="You are not the Store manager";
             }
             if(empty($data['rqs'])){
               $error=$data['rqs_err']="Enter Request by";
             }
             if(empty($data['apv'])){
               $error=$data['apv_err']="Enter Approved by";
             }
             if(empty($data['rcv'])){
               $error=$data['rcv_err']="Enter Received by";
             }
             // if(empty($data['store'])){
             //   $error=$data['store_err']="Enter Store";
             // }
             if(empty($data['unit'])){
               $error=$data['unit_err']="Enter Unit";
             }
             if(empty($data['dept'])){
               $error=$data['dept_err']="Enter Department";
             }
             if(empty($data['rmk'])){
               $error=$data['rmk_err']="Enter Remark";
             }
             $error=$this->getStoreManager($waybill['id']);
             if(empty($error)){
               if(isset($_SESSION['datasent'])){
                 if(!array_diff($data,$_SESSION['datasent'])){
                   exit;
                 }
               }
               if($this->inventModel->waybill($data)){
                 if($this->inventModel->updateInventory($data['model'],$data['qnt'],$data['cat'])){
                   reportLog(UID().' '.$data['cat'].' inventory ',lastID());
                   flash('register_success','success');
                   $_SESSION['datasent']=$data;
                   unset($data);
                 }
               }else{$data['cat_err']="Somthing went Wrong";}
             }
           }else{
             $data=[
               'cat'=>'',
               'cat_err'=>'',
               'date'=>'',
               'date_err'=>'',
               'qnt'=>'',
               'qnt_err'=>'',
               'model'=>'',
               'model_err'=>'',
               'rqs'=>'',
               'rqs_err'=>'',
               'apv'=>'',
               'apv_err'=>'',
               'rcv'=>'',
               'rcv_err'=>'',
               'store'=>'',
               'store_err'=>'',
               'unit'=>'',
               'unit_err'=>'',
               'dept'=>'',
               'dept_err'=>'',
               'rmk'=>'',
               'rmk_err'=>''
             ];
           }
          //$data = ['title'=>'welcome to about','description'=>'map project backend software'];
            $this->view('inventory/waybill', $data);
        }
        public function sr_in(){
          $data['inventory']=$this->inventModel->sr_in();
          $this->view('inventory/sr_in', $data);
        }
        public function sr_cn(){
          $data['inventory']=$this->inventModel->sr_cn();
          $this->view('inventory/sr_cn', $data);
        }
        function getDsc(){
          $id=escapeString($_POST['id']);
          if(!empty($id)){
            $row=$this->inventModel->getDescrictionById($id);
          }
          jsonDecode(array('dsc'=>$row->dsc,'name'=>$row->name,'qnt'=>$row->qnt));
        }
        // create new store
        public function createStore(){
          if(isset($_POST['createStore'])){
            parse_str($_POST['form'],$_POST);
            $data=[
              'store'=>escapeString($_POST['store']),
              'address'=>escapeString($_POST['address']),
              'manager'=>escapeString(@$_POST['manager']),
              'error'=>''
            ];
            if(empty($data['store'])){
              $data['error']="Enter Store name";
            }
            if(empty($data['address'])){
              $data['error']="Enter Store address";
            }
            if(empty($data['manager'])){
              $data['error']="Select Store manager";
            }
            if(empty($data['error'])){
              if(!findByCol(STORE_TBL,'store',$data['store'])){
                echo $this->inventModel->createStore($data) ? "Store created" : "Somthing Went wrong";
              }else{
                echo "Store Already Exist";
              }
            }else{echo$data['error'];}
          }
        }

        public function transfer(){
          if(isset($_POST['transferItems'])){
            parse_str($_POST['form'],$_POST);
            // print_r($_POST);
            $i = isset($_POST['id']) ? count($_POST['id']) : 0;$n=0;
            $error='';
            $data=[
              'rqs'=>escapeString($_POST['rqs']),
              'apv'=>escapeString($_POST['apv']),
              'rcb'=>escapeString($_POST['rcb']),
              'unit'=>escapeString($_POST['unit']),
              'dept'=>escapeString($_POST['dept']),
              'date'=>escapeString($_POST['date']),
              'remark'=>escapeString($_POST['remark']),
              'waybill'=>$this->wayBillId(),
              'to'=>escapeString(@$_POST['to']),
              'from'=>escapeString(@$_POST['from'])
            ];
            if(empty($data['rqs'])){
              $error='Enter request Originator';
            }
            if(empty($data['apv'])){
              $error='Enter Approver';
            }
            if(empty($data['rcb'])){
              $error='Enter Name of Receiver';
            }
            if(empty($data['unit'])){
              $error='Enter Unit';
            }
            if(empty($data['dept'])){
              $error='Enter Department';
            }
            if(empty($data['date'])){
              $error='Select Date';
            }
            // if(empty($data['remark'])){
            //   $error='transfer note is required';
            // }
            if(empty($data['to'])){
              $error='Select Destination Store';
            }
            if(empty($data['from'])){
              $error='Select Source Store';
            }
            if($data['to']==$data['from']){
              $error="Source and Destination can't be Same";
            }
            if(!confirmStoreManager($data['from'])){
              $error='You are not the Store Manager';
            }
            if(empty($error)){
              if($i>0){
                $this->inventModel->transferWayBill($data);
                while($n< $i){
                // $this->inventModel->createIteamInstance($_POST['id'][$n],$data['to']);
                 $this->inventModel->updateLog($data['waybill'],escapeString($_POST['from']),escapeString($_POST['to']),escapeString($_POST['qnt'][$n]),escapeString($_POST['old'][$n]),escapeString($_POST['id'][$n]));
                  // echo'q '.($_POST['qnt'][$n]).'<br>';
                  $n++;
                }
               $data['waybill'];
             }else{$error ="select an item to transfer";}
            }
            jsonDecode(array('error'=>$error,'id'=>$data['waybill']));
          }
        }
        public function printWaybill($id){
            $data['data']=$this->inventModel->wayBillDetails($id);
            $data['info']=$this->inventModel->wayBillInfo($id);
            $this->view('inventory/print', $data);
        }

        public function loadItem(){
          if(isset($_POST['loadItemDetails'])){
            $r='';
            $row=$this->inventModel->loadItemDetails(escapeString($_POST['id']));
            if($row){
              $r.='
              <div class="row pt-2" id="row'.escapeString($_POST['id']).'">
                <div class = "col-3">
                  <div class="form-group input-group">
                  <i class="fa fa-minus-square bg-primary text-light p-2 input-group-append remove pointer" id="'.escapeString($_POST['id']).'" ></i>
                    <input type = "hidden" name = "id[]" placeholder="quantity" class = "form-control form-control-sm" value="'.escapeString($_POST['id']).'" required>
                    <input type = "hidden" name = "old[]" placeholder="quantity" class = "form-control form-control-sm" value="'.$row->qnt.'" required>
                    <input type = "number" name = "qnt[]" placeholder="quantity" class = "form-control form-control-sm" value="1" required>
                  </div>
                </div>
                <div class ="col-9">
                  <span>Name: '.$row->name.' Qty: '.$row->qnt.' DSC: '.$row->dsc.' Condition: '.$row->status.'</span>
                </div>
              </div>';

            }
          }
          jsonDecode(array('item'=>$r));
        }
        private function wayBillId(){
          return strtoupper(date('yMdhis'));
        }

        public function lend(){
          userId();
          if($id>0 and isNum($id)){
            $data['inventory']=$this->inventModel->inventory($id);
            $data['storeName']=$this->inventModel->storeName($id);
          }
          $this->view('inventory/lend', $data);
        }
    }
