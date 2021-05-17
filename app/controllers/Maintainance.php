<?php
    class Maintainance extends Controller{
        public function __construct(){
           isLoggedIn() ?: redirect('pages');
           $this->maintainModal=$this->model('Maintain');
        }

        public function index(){
           $this->view('view/index', $data);
        }

        public function meter(){
           $data=$this->maintainModal->faultyMeter();
           $this->view('maintainance/meter', $data);
        }
        public function edat(){
           $data=$this->maintainModal->faultyEdat();
           $this->view('maintainance/edat', $data);
        }
        public function pair($id=0){
            if(isNum($id) and $id > 0){
              $data['meter']=$this->maintainModal->loadMeter(escapeString($id));
            }
           $data['meters']=$this->maintainModal->loadMeter();
           $data['edats']=$this->maintainModal->loadEdat();
           $this->view('maintainance/pair', $data);
        }
        public function mapEdatMeter(){
          if($_POST['mapEdatToMeter']){
            parse_str($_POST['form'],$_POST);
            echo $this->maintainModal->mapEdatToMeter(escapeString($_POST['eid']),escapeString($_POST['mid'])) ? 'success': 'Somthing Went Wrong!';
            reportLog(idToName(userId()).' map and meter');
          }
        }
        public function box($box=''){
          $data['box']=$this->maintainModal->box();
          if(!empty($box)){
            $data['metersOnBox']=$this->maintainModal->metersOnBox(escapeString($box));
          }
          $this->view('maintainance/box', $data);
        }
    }
