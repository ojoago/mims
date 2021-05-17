<?php
    class Dependency extends Controller{
        public function __construct(){
          isLoggedIn() ?: redirect('pages');
          $this->depModel=$this->model('Dependecy');
        }

      public function index(){
        redirectAccess('settings');
          // $state=$this->fitchModel->loadState();
          // $region=$this->fitchModel->loadRegion();
          // $big=$this->fitchModel->loadBig();
          // $feeder=$this->fitchModel->loadFeeder();
          $data=['team'=>$this->depModel->loadTeam(),
                  'role'=>$this->depModel->loadLevel(),
                'projects'=>$this->depModel->loadProject()
                ];
          $this->view('dependency/index',$data);
      }
      public function addTeam(){
          if(isset($_POST['newTeam'])){
             $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
              $txt=escapeString($_POST['team']);
              if(!is_numeric($txt) and !empty($txt)){
                  if(!(findByCol(TEAM_TBL,'team',$txt))){
                      $msg = ($this->depModel->addTeam($txt)) ? 'success' : 'Something Went Wrong!';
                  }else{ $msg='State Exist!';}
              }else{$msg='Wrong input!';}
              jsonDecode($msg);
          }
          if(isset($_POST['updateTeam'])){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $txt=escapeString($_POST['team']);
            $id=escapeString($_POST['id']);
            if(!is_numeric($txt) and !empty($txt) and isNum($id)){
              $msg = $this->depModel->updateTeam($txt,$id) ? 'success' : 'Something Went Wrong!';
            }else{$msg='Wrong input!';}
            jsonDecode($msg);
          }
      }

      public function addRole(){
          if(isset($_POST['newRole'])){
             $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
              $txt=escapeString($_POST['role']);
              if(!is_numeric($txt) and !empty($txt)){
                  if(!(findByCol(ROLE_TBL,'role',$txt))){
                      $msg = ($this->depModel->addRole($txt)) ? 'success' : 'Something Went Wrong!';
                  }else{ $msg='State Exist!';}
              }else{$msg='Wrong input!';}
              jsonDecode($msg);
          }
          if(isset($_POST['updateRole'])){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $txt=escapeString($_POST['role']);
            $id=escapeString($_POST['id']);
            if(!is_numeric($txt) and !empty($txt) and isNum($id)){
              $msg = $this->depModel->updateRole($txt,$id) ? 'success' : 'Something Went Wrong!';
            }else{$msg='Wrong input!';}
            jsonDecode($msg);
          }
      }

      public function manageProject(){
        if(isset($_POST['assignProject'])){
          parse_str($_POST['form'],$_POST);
          if(isset($_POST['project']) and isset($_POST['id'])){
            updateByCol(USER_TBL,'id',escapeString($_POST['id']),'pid',escapeString($_POST['project'])) ? jsonEncode('success'): jsonEncode(prettyMsg('Something Went Wrong!','alert-danger'));
          }else{
            jsonEncode(prettyMsg('Select Project!!!','alert-danger'));
          }
        }

        if(isset($_POST['addProject'])){
          parse_str($_POST['form'],$_POST);
          $data=[
            'id'=> isset($_POST['id']) ? escapeString($_POST['id']) : '',
            'cid'=>escapeString(@$_POST['cid']),
            'name'=>escapeString($_POST['project']),
            'dsc'=>escapeString($_POST['dsc']),
            'state'=>escapeString($_POST['state']),
            'zone'=>escapeString($_POST['zone']),
          ];
          if(empty($data['cid'])){
            $error="Select Company!";
          }
          if(empty($data['name'])){
            $error="Enter Project Name!";
          }
          if(empty($data['dsc'])){
            $error='Enter Project Description!';
          }
          if(empty($data['state'])){
            $error='Select State!';
          }
          if(empty($data['zone'])){
            $error='Select Trading Zone!';
          }
          if(!empty($data['id'])){
            $id=findDupByCol(PRJ_TBL,'id','pname',$data['name']);
            if($id !=0 and $id !=$data['id']){
              $error=="Projects Exist";
            }
          }
          elseif(findByCol(PRJ_TBL,'pname',$data['name'])){
              $error="Project Exist";
          }
          if(empty($error)){
            $error=$this->depModel->manageProject($data) ? 'success' : prettyMsg($error,'alert-danger');
          }else{
            $error=prettyMsg($error,'alert-danger');
          }
          jsonEncode($error);
        }
      }
}
