<?php
 class Guest{
     private $db;
     private $usertbl="user_tbl";
     public function __construct(){
        $this->db= new Database;
    }
    public function register($data){
        $this->db->query('INSERT INTO '.USER_TBL.' (mail,pwd,uid) VALUES(:mail,:pwd,:uid)');
        $this->db->bind(':mail',strtolower($data['email']));
        $this->db->bind(':pwd',$data['pwd']);
        $this->db->bind(':uid',str_replace(' ','_',ucwords($data['name'])));
        //execute
        if($this->db->execute()){
          $lastid=lastID();
          reportLog($data['name'].' Signed up',$lastid);
            $this->createId($lastid);
            return true;
        }else{return false;}
    }
    private function createId($id){
      $this->db->query("INSERT INTO ".STAFF_TBL." SET id=:id ");
      $this->db->bind(':id',$id);
      $this->db->execute();
    }
    // update password
    public function updatePwd($pwd){
      $this->db->query("UPDATE ".USER_TBL." SET pwd=:pwd WHERE id=:id ");
      $this->db->bind(':pwd',$pwd);
      $this->db->bind(':id',userId());
      return $this->db->execute() ? true : false;
    }
    //login User
    public function login($mail,$pwd){
        $this->db->query('SELECT id,mail,uid,pwd,access_right,userstatus,pid FROM '.USER_TBL.' WHERE mail= :mail');
        $this->db->bind(':mail',$mail);
        $row=$this->db->single();
        return password_verify($pwd,$row->pwd) ? $row : false;
    }
    //  find user by by column

    // load account details for editing
    public function loadMyDetails($id){
      $this->db->query("SELECT * FROM ".STAFF_TBL." WHERE id = ? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row : 0;
    }
    public function loadMyBasic($id){
      $this->db->query("SELECT mail,uid FROM ".USER_TBL." WHERE id = ? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row : 0;
    }
    public function updateMyBasicInfo($data){
      $this->db->query("UPDATE  ".USER_TBL." SET mail=:mail,uid=:uid WHERE id=:id LIMIT 1");
      $this->db->bind(':mail',$data['mail']);
      $this->db->bind(':uid',str_replace(' ','_',ucwords(strtolower($data['uid']))));
      $this->db->bind(':id',$data['id']);
      return $this->db->execute() ? true : false;
    }
    public function updateMyInfo($data){
      return ($this->loadMyDetails($data['id'])) ? $this->editMyinfo($data) : $this->addMyinfo($data);
    }
    private function addMyinfo($data){
      $this->db->query("INSERT INTO ".STAFF_TBL." (id,firstname,lastname,othername,gsm,address)
      VALUES(:id,:firstname,:lastname,:othername,:gsm,:address) ");
      $this->db->bind(':id',$data['id']);
      $this->db->bind(':firstname',$data['fname']);
      $this->db->bind(':lastname',$data['lname']);
      $this->db->bind(':othername',$data['oname']);
      $this->db->bind(':gsm',$data['gsm']);
      $this->db->bind(':address',$data['address']);
      return $this->db->execute() ? true : false;
    }
    private function editMyinfo($data){
      $this->db->query("UPDATE ".STAFF_TBL." SET firstname=:firstname,lastname=:lastname,othername=:othername,
      gsm=:gsm,address=:address WHERE id=:id LIMIT 1 ");
      $this->db->bind('id',$data['id']);
      $this->db->bind(':firstname',$data['fname']);
      $this->db->bind(':lastname',$data['lname']);
      $this->db->bind(':othername',$data['oname']);
      $this->db->bind(':gsm',$data['gsm']);
      $this->db->bind(':address',$data['address']);
      return $this->db->execute() ? true : false;
    }
}
