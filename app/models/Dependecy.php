<?php
class Dependecy{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    public function loadTeam(){
        $this->db->query("SELECT * FROM ".TEAM_TBL." ORDER BY team ASC");
        $results = $this->db->resultSet();
        return $results;
    }
    public function loadLevel(){
        $this->db->query("SELECT * FROM ".ROLE_TBL." ORDER BY role ASC");
        $results = $this->db->resultSet();
        return $results;
    }
    // load projects
    public function loadProject(){
        $this->db->query("SELECT p.id,p.pname,p.pdsc,c.names  FROM ".PRJ_TBL." p LEFT JOIN ".COMPANY_TBL." c
                          ON c.cmid=p.cmid ORDER BY pname ASC");
        $results = $this->db->resultSet();
        return $results;
    }

    public function manageProject($data){
      empty($data['id']) ?
        $this->db->query("INSERT INTO ".PRJ_TBL." SET pname=:name,pdsc=:dsc,cmid=:cid,state=:state,region=:zone ") :
        $this->db->query("UPDATE ".PRJ_TBL." SET pname=:name,pdsc=:dsc,cmid=:cid,state=:state,region=:zone WHERE id=:id LIMIT 1");
      $this->db->bind(':name',$data['name']);
      $this->db->bind(':dsc',$data['dsc']);
      $this->db->bind(':cid',$data['cid']);
      $this->db->bind(':state',$data['state']);
      $this->db->bind(':zone',$data['zone']);
      empty($data['id']) ?: $this->db->bind(':id',$data['id']);
      return $this->db->execute() ? true : false;
    }

    public function addTeam($str){
        $this->db->query("INSERT INTO ".TEAM_TBL." SET team=:team");
        $this->db->bind(':team',$str);
        return $this->db->execute() ? true : false;
    }
    public function updateTeam($str,$id){
        $this->db->query("UPDATE ".TEAM_TBL." SET team=:team WHERE id=:id");
        $this->db->bind(':team',$str);
        $this->db->bind(':id',$id);
        return ($this->db->execute()) ? true : false;
    }
    public function addRole($str){
        $this->db->query("INSERT INTO ".ROLE_TBL." SET role=:role");
        $this->db->bind(':role',$str);
        return $this->db->execute() ? true : false;
    }
    public function updateRole($str,$id){
        $this->db->query("UPDATE ".ROLE_TBL." SET role=:role WHERE id=:id");
        $this->db->bind(':role',$str);
        $this->db->bind(':id',$id);
        return $this->db->execute() ? true : false;
    }
}
