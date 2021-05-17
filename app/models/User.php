<?php
class User{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    //load user model

    public function loadUsers(){
      $this->db->query("SELECT u.id AS userId,u.mail,u.uid,u.userstatus,s.*, t.team, r.role AS level,c.names
                      FROM ". USER_TBL." u
                      LEFT JOIN ".STAFF_TBL."  s ON u.id = s.id LEFT JOIN ".TEAM_TBL ." t ON
                      t.id=u.team LEFT JOIN ".ROLE_TBL." r ON u.level =r.id LEFT JOIN ".COMPANY_TBL." c
                      ON c.cmid = u.cm_id ORDER BY uid ASC");
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadCompany(){
        $this->db->query("SELECT c.*,uid,mail,gsm FROM ".COMPANY_TBL." c
                        LEFT JOIN ".STAFF_TBL." s on s.id=c.mngr LEFT JOIN ".USER_TBL." u
                        ON c.mngr=u.id  ORDER BY c.names ASC ");
        $results = $this->db->resultSet();
        return $results;
    }
    public function loadCompanyById($id){
        $this->db->query("SELECT * FROM ".COMPANY_TBL." WHERE cmid=?");
        $this->db->bind(1,$id);
        $results = $this->db->single();
        return $results;
    }
    // create goes down here
    // add new company record
    public function createCompany($data){
        $this->db->query('INSERT INTO '.COMPANY_TBL.' SET names=:names,address=:address,meter=:meter,edat=:edat,mngr=:mn');
        $this->db->bind(':names',$data['name']);
        $this->db->bind(':address',$data['address']);
        $this->db->bind(':meter',$data['mpay']);
        $this->db->bind(':mn',$data['id']);
        $this->db->bind(':edat',$data['epay']);
       return ($this->db->execute()) ? 'Account successfully created' : false;
    }
    // update company info
    public function updateCompany($data){
        $this->db->query('UPDATE '.COMPANY_TBL.' SET names=:names,address=:address,meter=:meter,
                                    edat=:edat,mngr=:mn WHERE cmid=:id');
        $this->db->bind(':names',$data['name']);
        $this->db->bind(':address',$data['address']);
        $this->db->bind(':mn',$data['mail']);
        $this->db->bind(':id',$data['id']);
        $this->db->bind(':meter',$data['mpay']);
        $this->db->bind(':edat',$data['epay']);
       return ($this->db->execute()) ? 'Account successfully Updated' : false;
    }
    // asign user role
    public function updateGroup($data){
      $this->db->query("UPDATE ".USER_TBL." SET level=? WHERE id=? LIMIT 1");
      $this->db->bind(1,$data['group']);
      $this->db->bind(2,$data['id']);
     return ($this->db->execute()) ? true : false;
    }
    // asign team
    public function updateTeam($data){
      $this->db->query("UPDATE ".USER_TBL." SET team=:team WHERE id=:id LIMIT 1");
      $this->db->bind(':team',$data['team']);
      $this->db->bind(':id',$data['id']);
     return ($this->db->execute()) ? true : false;
    }
    // update user status
    public function userStatus($data){
      $this->db->query("UPDATE ". USER_TBL." SET userstatus =:userstatus WHERE id=:id LIMIT 1");
      $this->db->bind(':userstatus',$data['status']);
      $this->db->bind(':id',$data['id']);
      unset($data);
     return ($this->db->execute()) ? true : false;
    }
    public function fetchAccess($id){
      $this->db->query("SELECT access_right FROM ".USER_TBL." WHERE id=:id ");
      $this->db->bind(':id',$id);
      $row=$this->db->single();
      return ($this->db->rowCount()>0) ? $row->access_right : false;
    }
    public function updateAccess($id,$param){
      $this->db->query("UPDATE ".USER_TBL." SET access_right = :access_right WHERE id=:id ");
      $this->db->bind(':id',$id);
      $this->db->bind(':access_right',$param);
      return ($this->db->execute()) ? true : false;
    }
}
