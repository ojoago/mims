<?php
    class Guests extends Controller{
        public function __construct(){
            $this->userModel=$this->model('Guest');
        }

        public function register(){
            # check for post
            if($_SERVER['REQUEST_METHOD']=='POST'){
                // sanitize input
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                $data=[
                    'name'=>escapeString($_POST['name']),
                    'email'=>escapeString($_POST['email']),
                    'pwd'=>$_POST['pwd'],
                    'cpwd'=>$_POST['cpwd'],
                    'name_err'=>'',
                    'email_err'=>'',
                    'pwd_err'=>'',
                    'cpwd_err'=>''
                ];
                // validate email
                if(empty($data['email'])){
                    $error=$data['email_err']='Please enter email';
                }elseif(findByCol(USER_TBL,'mail',$data['email'])){
                    $error=$data['email_err']='Email is aready taken';
                }
                // validate name
                if(empty($data['name'])){
                    $error=$data['name_err']='Please enter name';
                }elseif(findByCol(USER_TBL,'uid',$data['name'])){
                    $error=$data['name_err']='name is aready taken';
                }
                // validate password
                if(empty($data['pwd'])){
                    $error=$data['pwd_err']='Please enter password';
                }elseif(strlen($data['pwd'])<5){
                    $error=$data['pwd_err']='password is short';
                }
                if($data['cpwd'] != $data['pwd']){
                    $error=$data['cpwd_err']='password did not match!';
                }
                if(empty($error)){
                    $body="Your Account has been created on Mims, please contact Triple Seventh to verify your Account!";
                   if(smtpmailer($data['email'],'Notification',$body)){
                        $data['pwd']=password_hash($data['pwd'],PASSWORD_DEFAULT);
                    // register user
                    if($this->userModel->register($data)){
                        smtpmailer('dhasmom01@gmail.com','Notification', $data['name'].' Has created an account on mims please verify');
                        flash('register_success','you are resgistered and can log in');
                        redirect('guests/login');
                    }else{
                      flash('register_success','Somthing Went Wrong','alert-danger');
                    }
                   }else{flash('register_success','Could not verify your Email Address','alert-danger');}
                }
            }else{
               $data=[
                   'name'=>'',
                   'email'=>'',
                   'pwd'=>'',
                   'cpwd'=>'',
                   'name_err'=>'',
                   'email_err'=>'',
                   'pwd_err'=>'',
                   'cpwd_err'=>''
                ];
            }
            $this->view('guest/register',$data);
        }
        public function login(){
            # check for post
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
                $data=[
                    'email'=>escapeString($_POST['email']),
                    'pwd'=>$_POST['pwd'],
                    'email_err'=>'',
                    'pwd_err'=>''
                ];
                if(empty($data['email'])){
                    $error=$data['email_err']='Please enter email';
                }
                if(empty($data['pwd'])){
                    $error=$data['pwd_err']='Please enter password';
                }
                if(!findByCol(USER_TBL,'mail',$data['email'])){
                  $error=$data['email_err']='No User found!';
                }
                // make sure error are empty
                if(empty($error)){
                    $loggedInUser=$this->userModel->login($data['email'],$data['pwd']);
                    if($loggedInUser){
                      $loggedInUser->userstatus==='active' ? $this->createUserSession($loggedInUser) : $data['email_err']='Contact Triple Seventh to Verify Your Account';
                    }else{
                      $data['pwd_err']='Wrong Password';
                    }
                }
            }else{
               $data=[
                   'email'=>'',
                   'pwd'=>'',
                   'email_err'=>'',
                   'pwd_err'=>''
                ];
            }
            $this->view('guest/login',$data);
        }
        public function createUserSession($user){
            $_SESSION['mimsUserId']=base64_encode($user->id);
            $_SESSION['mimsUserMail']=base64_encode($user->mail);
            $_SESSION['mimsUid']=base64_encode($user->uid);
            $_SESSION['mims_PID']=base64_encode($user->pid);
            reportLog($user->uid.' Logged in, ip address: '.$this->ipAddress());
            $str='$role='.'array('.$user->access_right.');';
        		eval($str);
            switch(@$role['landing']) {
              case 1:
                redirect('dashboards');
                break;
              case 2:
                redirect('admins');
                break;
              case 3:
                redirect('installations');
                break;
              default:
                redirect('meters');
                break;
            }
        }
        public function logout(){
          if(isLoggedIn()){
            reportLog(base64_decode($_SESSION['mimsUid']).' Logged out');
            unset($_SESSION['mimsUserId']);
            unset($_SESSION['mimsUserMail']);
            unset($_SESSION['mimsUid']);
            unset($_SESSION["lend_cart"]);
            unset($_SESSION["sr_in"]);
            unset($_SESSION["sr_cn"]);
          }
          redirect('pages');
        }
      private function preg($str){
        return preg_match('[@_!#$%^&*()/\|}{~:]',$str) ? true : false;
      }
      private function findCap($str){
        return preg_match('/[A-Z]/',$str) ? true : false;
      }
      public function loadMyAccount(){
        $form='';
        if(isset($_POST['loadMyDetails'])){
          $row= $this->userModel->loadMyDetails(escapeString($_POST['id']));
          $form.='
            <form id = "updateMyInfo" method="post">
                <div class="form-group input-group">
                  <input type = "hidden" name = "id" placeholder="First name" class = "form-control input-sm" value ="'.@escapeString($_POST['id']).'">
                  <input type = "text" name = "fname" placeholder="First name" class = "form-control input-sm" value ="'.@$row->firstname.'" required>
                </div>
                <div class="form-group input-group">
                  <input type = "text" name = "lname" placeholder="Last Name" class = "form-control input-sm" value ="'.@$row->lastname.'" required>
                </div>
                <div class="form-group input-group">
                  <input type = "text" name = "oname" placeholder="other name" class = "form-control input-sm" value ="'.@$row->othername.'" required>
                </div>
                <div class="form-group input-group">
                  <input type = "text" name = "gsm" placeholder="Phone number " class = "form-control input-sm" value ="'.@$row->gsm.'" required>
                </div>
                <div class="form-group input-group">
                  <textarea type = "text" name = "address" placeholder="Address" class = "form-control input-sm"  required>'.@$row->address.'</textarea>
                </div>
            </form>
          ';
        }
        if(isset($_POST['loadUserBasicInfoById'])){
            $row= $this->userModel->loadMyBasic(escapeString($_POST['id']));
            $form.='
              <form id = "updateBasicInfo" method="post">
                  <div class="form-group input-group">
                    <input type = "text" name = "uid" placeholder="Last Name" class = "form-control input-sm" value ="'.@decodeHtmlEntity($row->uid).'" required>
                  </div>
                  <div class="form-group input-group">
                    <input type = "hidden" name = "id" placeholder="First name" class = "form-control input-sm" value ="'.@escapeString($_POST['id']).'">
                    <input type = "email" name = "mail" placeholder="Email" class = "form-control input-sm" value ="'.@decodeHtmlEntity($row->mail).'" required>
                  </div>
              </form>
            ';
        }
        jsonEncode($form);
      }
      public function updateMyAccount(){
        if(isset($_POST['updatingMyAccount'])){
          parse_str($_POST['form'],$_POST);
          $data=[
            'id'=>escapeString($_POST['id']),
            'fname'=>escapeString($_POST['fname']),
            'lname'=>escapeString($_POST['lname']),
            'oname'=>escapeString($_POST['oname']),
            'gsm'=>escapeString($_POST['gsm']),
            'address'=>escapeString($_POST['address']),
            'error'=>''
          ];
          if(empty($data['fname'])){
            $data['error']='enter your first name';
          }
          if(empty($data['lname'])){
            $data['error']='enter your last name';
          }
          if(empty($data['gsm'])){
            $data['error']='enter your gsm number';
          }elseif(strlen($data['gsm'])<11){
            $data['error']='Wrong phone number';
          }
          if(empty($data['address'])){
            $data['error']='enter your Address';
          }
          if(empty($data['error'])){
            if($this->userModel->updateMyInfo($data)){
              reportLog(UID().' Update account details',$data['id']);
              echo "success";
            }
          }else{echo $data['error'];}
        }

        if(isset($_POST['updateBasicInfo'])){
          parse_str($_POST['form'],$_POST);$error='';
          $data=[
            'id'=>escapeString($_POST['id']),
            'mail'=>strtolower(escapeString($_POST['mail'])),
            'uid'=>escapeString($_POST['uid']),
          ];
          if(!isNum($data['id'])){
            $error='Wrong Info';
          }
          if(empty($data['mail'])){
            $error='Email is required';
          }elseif(!verifyEmail($data['mail'])) {
            $error='Enter A valid Email';
          }
          if(empty($data['uid'])){
            $error='Enter Username';
          }
          if(empty($error)){
            if($this->userModel->updateMyBasicInfo($data)){
              reportLog(UID().' Update Username and Email',$data['id']);
              $error= "success";
            }
          }else{
            $error=prettyMsg($error,'alert-danger');
          }
          jsonEncode($error);
        }
      }

      public function updatePwd(){
        if(isset($_POST['updatingPwd'])){
          parse_str($_POST['form'],$_POST);
          $pwd  =$_POST['pwd'];
          $npwd =$_POST['npwd'];
          $cpwd =$_POST['cpwd'];
          if($npwd===$cpwd){
            if($this->userModel->login(base64_decode($_SESSION['mimsUserMail']),$pwd)){
              $pwd=password_hash($npwd,PASSWORD_DEFAULT);
              echo $this->userModel->updatePwd($pwd) ? 'success' : 'Somthing Went Wrong';
              reportLog(base64_decode($_SESSION['mimsUid']).' Updated password');
            }else{echo "old password not match!";}
          }else{ echo "new password and comfirm password did not match!";
          }
        }
      }

      private function ipAddress(){
        if(isset($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
      }
  }
