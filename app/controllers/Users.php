<?php
    class Users extends Controller{
      public function __construct(){
          isLoggedIn() ?: redirect('pages');
          $this->userModel=$this->model('User');
      }

      public function index(){
        $data = ['title'=>'MAP','description'=>'t7 map system'];
        $this->view('users/index', $data);
      }
      public function user(){
        $data['users']=$this->userModel->loadUsers();
        $this->view('users/user',$data);
      }
      public function manage(){
        $data['company']=$this->userModel->loadCompany();
        $this->view('users/manage',$data);
      }
      public function edit($id=0){
        if(!empty($id) and isNum($id)){
          $row=$this->userModel->loadCompanyById(escapeString($id));
          $data=['name'=>$row->names,
                 'name_err'=>'',
                 'edit'=>$row->cmid,
                 'address'=>$row->address,
                 'address_err'=>'',
                 'mpay'=>$row->meter,
                 'mpay_err'=>'',
                 'epay'=>$row->edat,
                 'epay_err'=>''
            ];
          }
        $this->view('users/create_company', $data);
      }
      public function create(){
          //if is form submit then process it
         if($_SERVER['REQUEST_METHOD']=='POST'){
            // sanitize input
         $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
         $data=['name'=>escapeString($_POST['name']),
               'name_err'=>'',
               'mail'=>escapeString($_POST['mail']),
               'mail_err'=>'',
               'address'=>escapeString($_POST['address']),
               'address_err'=>'',
               'mpay'=>escapeString($_POST['mpay']),
               'mpay_err'=>'',
               'epay'=>escapeString($_POST['epay']),
               'epay_err'=>'',
               'id'=>isset($_POST['id']) ? escapeString($_POST['id']) : ''
            ];
         if(empty($data['name'])){
            $error=$data['name_err']="Please enter Company's name";
         }
         if(empty($data['id']) and findByCol(COMPANY_TBL,'names',$data['name'])){
              $error=$data['name_err']=" Company name Exist";
         }
         if(empty($data['mpay'])){
            $error=$data['mpay_err']="Enter amount per meter installed";
         }
         if(empty($data['epay'])){
            $error=$data['epay_err']="Enter amount per meter installed";
         }
         if(empty($data['address'])){
            $error=$data['address_err']="Enter address";
         }
         if(empty($data['mail'])){
            $error=$data['mail_err']="Select Company PM";
         }
         if(empty($error)){
              $re= empty($data['id']) ? $this->userModel->createCompany($data) : $this->userModel->updateCompany($data);
               if($re){
                  flash('register_success',$re);
                $data=['name'=>'',
                     'name_err'=>'',
                     'mail'=>'',
                     'mail_err'=>'',
                     'address'=>'',
                     'address_err'=>'',
                     'mpay'=>'',
                     'mpay_err'=>'',
                     'epay'=>'',
                     'epay_err'=>''
                  ];
              }else{
               flash('register_success','Account successfully created','alert alert-danger');
            }
         }
         }else{
            $data=['name'=>'',
               'name_err'=>'',
               'manager'=>'',
               'manager_err'=>'',
               'mail'=>'',
               'mail_err'=>'',
               'gsm'=>'',
               'gsm_err'=>'',
               'address'=>'',
               'address_err'=>'',
               'mpay'=>'',
               'mpay_err'=>'',
               'epay'=>'',
               'epay_err'=>''
            ];
         }
         $this->view('users/create_company', $data);
      }

      public function activity(){
        $company=$this->userModel->loadCompany();
        $data = ['company'=>$company];
        $this->view('users/activity',$data);
      }
      public function deleteUser(){
        if(isset($_POST['deleteUserById'])){
          jsonEncode(deleteByCol(USER_TBL,'id',escapeString($_POST['id'])));
        }
      }
      public function updateUser(){

      }
      public function access(){
        $content='';
        if(isset($_POST['id'])){
          $id=escapeString($_POST['id']);
          $right=$this->userModel->fetchAccess($id);
          $str='$role='.'array('.$right.');';
      		eval($str);

          ?>
              <form method = "post" id ="access_right">
                <input type="hidden" name="id" value="<?php echo@$id ?>">
                <div id="accordion">
                  <div class="row">
                  <div class = "col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#all" aria-expanded="false" aria-controls="all">
                      Basic </a><input type="checkbox" name="role[basic]" value="1" checked>
                    </div>
                    <div id="all" class="collapse" aria-labelledby="all" data-parent="#accordion">
                      <div class="card-body p-2">
                        If you unselect this option is as good as suspending user
                        <p>View Only <input type="checkbox" name="role[button]" value="1" <?php if(@$role['button']==1){ echo 'checked';} ?> ></p>
                        <p>Admin Management <input type="checkbox" name="role[home]" value="1" <?php if(@$role['home']==1){ echo 'checked';} ?> ></p>
                      </div>
                      <div class="card-body p-2">
                        landing page
                        <p>Dashboard <input type="radio" name="role[landing]" value="1" <?php if(@$role['landing']==1){ echo 'checked';} ?> >
                          Home <input type="radio" name="role[landing]" value="2" <?php if(@$role['landing']==2){ echo 'checked';} ?> >
                          Company <input type="radio" name="role[landing]" value="3" <?php if(@$role['landing']==3){ echo 'checked';} ?> ></p>
                      </div>
                    </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                          <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#inventory" aria-expanded="false" aria-controls="inventory">
                          Inventory Management </a><input type="checkbox" name="role[inventory]" value="1" <?php if(@$role['inventory']==1){ echo 'checked';} ?>  >
                        </div>
                        <div id="inventory" class="collapse" aria-labelledby="inventory" data-parent="#accordion">
                          <div class="card-body p-2">
                            <p>Bin-Card <input type="checkbox" name="role[bin]" value="1" <?php if(@$role['bin']==1){ echo 'checked';} ?> ></p>
                            <p>Create Store <input type="checkbox" name="role[creatstore]" value="1" <?php if(@$role['creatstore']==1){ echo 'checked';} ?> ></p>
                            <p>New Item <input type="checkbox" name="role[newitem]" value="1" <?php if(@$role['newitem']==1){ echo 'checked';} ?> ></p>
                            <p>Transfer <input type="checkbox" name="role[transfer]" value="1" <?php if(@$role['transfer']==1){ echo 'checked';} ?> ></p>
                          </div>
                          <div class="card-body p-2">
                            <p>Waybills <input type="checkbox" name="role[waybill]" value="1" <?php if(@$role['waybill']==1){ echo 'checked';} ?> ></p>
                            <p>SR-IN <input type="checkbox" name="role[sr_in]" value="1" <?php if(@$role['sr_in']==1){ echo 'checked';} ?>  ></p>
                            <p>SR-CN <input type="checkbox" name="role[sr_cn]" value="1" <?php if(@$role['sr_cn']==1){ echo 'checked';} ?>  ></p>
                            <p>My Request<input type="checkbox" name="role[myrequest]" value="1" <?php if(@$role['myrequest']==1){ echo 'checked';} ?>  ></p>
                            <p>Request<input type="checkbox" name="role[request]" value="1" <?php if(@$role['request']==1){ echo 'checked';} ?>  ></p>
                            <p>Request List<input type="checkbox" name="role[requestlist]" value="1" <?php if(@$role['requestlist']==1){ echo 'checked';} ?>  ></p>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                          <div class="card-header">
                            <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#compani"  aria-expanded="false" aria-controls="compani">
                            Company </a><input type="checkbox" name="role[company]" value="1" <?php if(@$role['company']==1){ echo 'checked';} ?>  >
                          </div>
                          <div id="compani" class="collapse" aria-labelledby="compani" data-parent="#accordion">
                            <div class="card-body p-2">
                            <p>Company <input type="checkbox" name="role[cmp]" value="1" <?php if(@$role['cmp']==1){ echo 'checked';} ?> ></p>
                            <p>Installer <input type="checkbox" name="role[installer]" value="1" <?php if(@$role['installer']==1){ echo 'checked';} ?>  ></p>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                        <div class="card-header">
                          <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#people" aria-expanded="false" aria-controls="people">
                          Users Management </a><input type="checkbox" name="role[users]" value="1" <?php if(@$role['users']==1){ echo 'checked';} ?>  >
                        </div>
                        <div id="people" class="collapse" aria-labelledby="people" data-parent="#accordion">
                          <div class="row">
                            <div class="col">
                              <div class="card-body p-2">
                              <p>users <input type="checkbox" name="role[user]" value="1" <?php if(@$role['user']==1){ echo 'checked';} ?> ></p>
                              <p>access right <input type="checkbox" name="role[rights]" value="1" <?php if(@$role['rights']==1){ echo 'checked';} ?> ></p>
                              <p>Asign Project <input type="checkbox" name="role[projects]" value="1" <?php if(@$role['projects']==1){ echo 'checked';} ?> ></p>
                              <p>level <input type="checkbox" name="role[level]" value="1" <?php if(@$role['level']==1){ echo 'checked';} ?>  ></p>
                              <p>update User <input type="checkbox" name="role[updateUser]" value="1" <?php if(@$role['updateUser']==1){ echo 'checked';} ?>  ></p>
                              <p>Delete User <input type="checkbox" name="role[deleteUser]" value="1" <?php if(@$role['deleteUser']==1){ echo 'checked';} ?>  ></p>
                              <p>team <input type="checkbox" name="role[team]" value="1" <?php if(@$role['team']==1){ echo 'checked';} ?>  ></p>
                              <p>status <input type="checkbox" name="role[status]" value="1" <?php if(@$role['status']==1){ echo 'checked';} ?>  ></p>
                              </div>
                            </div>
                            <div class="col">
                              <div class="card-body p-2">
                              <p>Create Company <input type="checkbox" name="role[create]" value="1" <?php if(@$role['create']==1){ echo 'checked';} ?> ></p>
                              <p>Edit Company<input type="checkbox" name="role[editcompany]" value="1" <?php if(@$role['editcompany']==1){ echo 'checked';} ?>  ></p>
                              <p>View Company<input type="checkbox" name="role[viewcompany]" value="1" <?php if(@$role['editcompany']==1){ echo 'checked';} ?>  ></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class = "col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#meter" aria-expanded="false" aria-controls="meter">
                      Meter Management </a><input type="checkbox" name="role[meter]" value="1" <?php if(@$role['meter']==1){ echo 'checked';} ?>  >
                    </div>
                    <div id="meter" class="collapse" aria-labelledby="meter" data-parent="#accordion">
                      <div class="card-body p-2">
                      <p>Bash <input type="checkbox" name="role[bash]" value="1" <?php if(@$role['bash']==1){ echo 'checked';} ?> ></p>
                      <p>Schedule <input type="checkbox" name="role[paid]" value="1" <?php if(@$role['paid']==1){ echo 'checked';} ?>  ></p>
                      <p>Installed <input type="checkbox" name="role[installed]" value="1" <?php if(@$role['installed']==1){ echo 'checked';} ?> ></p>
                      <p>Edit Meter info <input type="checkbox" name="role[editmeter]" value="1" <?php if(@$role['editmeter']==1){ echo 'checked';} ?> ></p>
                      <p>Delete Meter<input type="checkbox" name="role[deleteMeter]" value="1" <?php if(@$role['deleteMeter']==1){ echo 'checked';} ?> ></p>
                      <p>Fix Meter<input type="checkbox" name="role[fixMeter]" value="1" <?php if(@$role['fixMeter']==1){ echo 'checked';} ?> ></p>
                      <p>asign Meter <input type="checkbox" name="role[asignMeter]" value="1" <?php if(@$role['asignMeter']==1){ echo 'checked';} ?> ></p>
                      <p>maintaninace <input type="checkbox" name="role[maintain]" value="1" <?php if(@$role['maintain']==1){ echo 'checked';} ?> ></p>
                      <p>Daily Record <input type="checkbox" name="role[record]" value="1" <?php if(@$role['record']==1){ echo 'checked';} ?> ></p>
                      </div>
                    </div>
                    </div>

                    <div class="card">
                      <div class="card-header">
                        <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#edat" aria-expanded="false" aria-controls="edat">
                        Edat Management </a><input type="checkbox" name="role[manage_edat]" value="1" <?php if(@$role['manage_edat']==1){ echo 'checked';} ?>  >
                      </div>
                      <div id="edat" class="collapse" aria-labelledby="edat" data-parent="#accordion">
                        <div class="card-body p-2">
                        <p>Schedule <input type="checkbox" name="role[schedule]" value="1" <?php if(@$role['schedule']==1){ echo 'checked';} ?> ></p>
                        <p>view <input type="checkbox" name="role[view]" value="1" <?php if(@$role['view']==1){ echo 'checked';} ?>  ></p>
                        <p>Edit Edat info <input type="checkbox" name="role[editedat]" value="1" <?php if(@$role['editedat']==1){ echo 'checked';} ?>  ></p>
                        <p>maintaninace <input type="checkbox" name="role[maintain_e]" value="1" <?php if(@$role['maintain_e']==1){ echo 'checked';} ?> ></p>
                        </div>
                      </div>
                      </div>

                    <div class="card">
                        <div class="card-header">
                          <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#maintain" aria-expanded="false" aria-controls="maintain">
                          mantainance </a><input type="checkbox" name="role[maintaninace]" value="1" <?php if(@$role['maintaninace']==1){ echo 'checked';} ?>  >
                        </div>
                        <div id="maintain" class="collapse" aria-labelledby="maintain" data-parent="#accordion">
                          <div class="card-body p-2">
                          <p>Meter <input type="checkbox" name="role[m_meter]" value="1" <?php if(@$role['m_meter']==1){ echo 'checked';} ?> ></p>
                          <p>Edat <input type="checkbox" name="role[m_edat]" value="1" <?php if(@$role['m_edat']==1){ echo 'checked';} ?> ></p>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header">
                          <a class="btn btn-link collapsed" data-toggle="collapse" data-parent="#accordion" href="#button" aria-expanded="false" aria-controls="meter">
                          Setting </a><input type="checkbox" name="role[setting]" value="1" <?php if(@$role['setting']==1){ echo 'checked';} ?>  >
                        </div>
                        <div id="button" class="collapse" aria-labelledby="meter" data-parent="#accordion">
                          <div class="card-body p-2">
                          <p>Filter <input type="checkbox" name="role[filter]" value="1" <?php if(@$role['filter']==1){ echo 'checked';} ?> ></p>
                          <p>Download <input type="checkbox" name="role[download]" value="1" <?php if(@$role['download']==1){ echo 'checked';} ?>  ></p>
                          <p>Create Team <input type="checkbox" name="role[createteam]" value="1" <?php if(@$role['createteam']==1){ echo 'checked';} ?> ></p>
                          <p>Edit Team <input type="checkbox" name="role[edit_team]" value="1" <?php if(@$role['edit_team']==1){ echo 'checked';} ?> ></p>
                          <p>Create Role  <input type="checkbox" name="role[role]" value="1" <?php if(@$role['role']==1){ echo 'checked';} ?> ></p>
                          <p>Edit Role  <input type="checkbox" name="role[editrole]" value="1" <?php if(@$role['editrole']==1){ echo 'checked';} ?> ></p>
                          <p>dropdown  <input type="checkbox" name="role[settings]" value="1" <?php if(@$role['settings']==1){ echo 'checked';} ?> ></p>
                          </div>
                        </div>
                        </div>

                  </div>
                </div>
              </form>
            </div>
          <?php
        }
//        jsonDecode($content);
      }

      public function updateAccess(){
        if(isset($_POST['updateAccessRight'])){
          parse_str($_POST['form'],$_POST);
          $param='';
          if(isset($_POST['role'])){
            foreach(@$_POST['role'] as $key => $value) {
               if($value){
                    $param .=  '"'.$key.'"'.' => '. '"'. $value .'"'.',';
               }
             }
             if(!empty($_POST['id'])){
               echo ($this->userModel->updateAccess(escapeString($_POST['id']),$param)) ? 'access right updated!!!' : 'update failed';
               smtpmailer(idToMail($_POST['id']),'Notification','Your access right has been Modified on MIMS');
             }else{echo"Please logout, login and try again!!!!";}
          }else{echo "select 1 role at least";}

        }
      }
   }
