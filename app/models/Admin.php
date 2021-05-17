<?php
  class Admin{
    private $db;
    public function __construct(){
      $this->db = new Database;
    }
    // dashboards query start here
    // count edats conditionally

    // new dashboards stop here
    public function countPaidCustomer(){
      $this->db->query("SELECT COUNT(id) AS count FROM ". SCHEDULE_TBL." ");
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->count : 0;
    }
    public function countEdatByStatus($status){
      $this->db->query("SELECT COUNT(eid) AS count FROM  ".EDAT_TBL." WHERE edatstatus = ? ");
      $this->db->bind(1,$status);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    // count customer by status
    public function countCustomerByStatus($status){
      $this->db->query("SELECT COUNT(id) AS count FROM ".SCHEDULE_TBL." WHERE status = ? ");
      $this->db->bind(1,$status);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->count : 0;
    }
    public function countMeterByStatus($status){
      $this->db->query("SELECT COUNT(mid) AS count FROM ".MET_TBL." WHERE status = ? ");
      $this->db->bind(1,$status);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    public function countFautyDevice($device,$status){
      $this->db->query("SELECT COUNT(id) AS count FROM ". FAULTY_TBL ." WHERE status = ? AND device=? ");
      $this->db->bind(1,$status);
      $this->db->bind(2,$device);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->count : 0;
    }

    // count number of edat asigned
    public function countAsignedEdat(){
      $this->db->query("SELECT COUNT(eid) AS count FROM ". EDAT_TBL ." ");
      $row = $this->db->single();
     return $this->db->rowCount()>0 ? $row->count : 0;
    }
    // count number of meters asigned
    public function CountMetersWithoutEdat($status){
      $this->db->query("SELECT COUNT(mid) AS count FROM ".MET_TBL."  INNER JOIN  ".EDAT_TBL." ON edat_id = eid WHERE edatstatus =:edatstatus ");
      $this->db->bind(':edatstatus',$status);
      $row = $this->db->single();
     return $this->db->rowCount()>0 ? $row->count : 0;
    }
    // count number of staff
    public function countCompany(){
      $this->db->query('SELECT COUNT(*) AS count FROM  '. COMPANY_TBL .' ');
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->count : 0;
    }
    // dashboards stop here
    // staff Details goes here
    public function staffDetails($id){
      $this->db->query("SELECT u.id AS userId,u.mail,u.uid,u.userstatus,s.*, t.team, r.role AS level FROM ".USER_TBL." u
                        LEFT JOIN ".STAFF_TBL."  s ON u.id = s.id LEFT JOIN ".TEAM_TBL ." t ON
                        t.id=u.id LEFT JOIN ".ROLE_TBL." g ON u.id =r.id WHERE cm_id = ? ORDER BY uid ASC");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }

    // this method get company id
    public function getCompany(){
      $this->db->query("SELECT cm_id,names FROM ". USER_TBL ." LEFT JOIN ". COMPANY_TBL ." ON cmid=cm_id WHERE id = ?");
      $this->db->bind(1,userId());
      $row=$this->db->single();
      return $this->db->rowCount()>0 ? $row : 0;
    }

    // updating methods goes here
    public function updateGroup($data){
      $this->db->query("UPDATE ".USER_TBL." SET level=:level WHERE id=:id LIMIT 1");
      $this->db->bind(':level',$data['group']);
      $this->db->bind(':id',$data['id']);
     return $this->db->execute() ? true : false;
    }

    // read customer from database
    public function viewCustomer($id){
        $this->db->query("SELECT c.*,p.payment_date,p.gateway,p.reference,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN
              ". PAYMENT_TBL ." p ON p.cid=c.id LEFT JOIN ". USER_TBL ." u ON c.asignedto=u.id WHERE
        p.status='paid' AND cmp=:cmp ORDER BY c.status DESC");
         $this->db->bind(':cmp',$id);
        $results = $this->db->resultSet();
        return $results;
    }
    public function viewNoEdat(){
      $this->db->query("SELECT c.*,m.*,u.uid, m.doi AS payment_date FROM ".SCHEDULE_TBL." c LEFT JOIN ".MET_TBL." m
                      ON c.id=m.cid INNER JOIN ".EDAT_TBL." e ON edat_id=eid LEFT JOIN ".USER_TBL." u ON u.id = c.uid
                      WHERE edatstatus ='not install' ORDER BY m.doi DESC");
      // $this->db->query("SELECT COUNT(mid) AS count FROM ".MET_TBL."  INNER JOIN  ".EDAT_TBL." ON edat_id = eid  ");
       $results = $this->db->resultSet();
      return $results;
    }
    public function meters($sts=''){
      if($sts==''){
        $this->db->query("SELECT c.*,m.*,u.uid, m.doi AS payment_date FROM ".SCHEDULE_TBL." c LEFT JOIN ".MET_TBL." m
                        ON c.id=m.cid LEFT JOIN ".USER_TBL." u ON u.id = c.uid  ORDER BY m.doi DESC");
         $results = $this->db->resultSet();
      }else{
        $this->db->query("SELECT c.*,m.*,u.uid, m.doi AS payment_date FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m
                        ON c.id=m.cid LEFT JOIN ".USER_TBL." u ON u.id = c.uid WHERE m.status=:status ORDER BY m.doi DESC");
         $this->db->bind(':status',$sts);
         $results = $this->db->resultSet();
      }
       return $results;
    }
    // meters goes here

    //edats goes here
    public function asignedEdat(){
      $this->db->query("SELECT e.*, u.uid FROM ". EDAT_TBL. " e LEFT JOIN ". USER_TBL ." u ON u.id=e.installer  ");
      $results=$this->db->resultSet();
      return $results;
    }
    // fetch edat by status
    public function fetchEdats($sts){
      $this->db->query("SELECT e.*, u.uid FROM ".EDAT_TBL." e LEFT JOIN ". USER_TBL." u ON u.id=e.installer
                      WHERE edatstatus= ?");
      $this->db->bind(1,$sts);
      $results=$this->db->resultSet();
      return $results;
    }
    // count installation by companies
    public function countInstalledByCompanies(){
      $this->db->query("SELECT COUNT(s.id) AS count,created_on AS month,s.metertype,c.names,s.status FROM ".SCHEDULE_TBL." s
                      LEFT JOIN ".COMPANY_TBL." c ON s.cid=cmid GROUP BY c.names,s.metertype,s.status,MONTH(created_on)
                      ORDER BY created_on DESC");
      $results=$this->db->resultSet();
      return $results;
    }

  }
