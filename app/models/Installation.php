<?php
  class Installation{
    private $db;
    public function __construct(){
      $this->db = new Database;
    }
    // dashboards query start here
    // count edats conditionally
    public function countEdatByStatus($status,$id){
      $this->db->query("SELECT COUNT(eid) AS count FROM  ".EDAT_TBL." WHERE edatstatus = ? AND cmp = ? ");
      $this->db->bind(1,$status);
      $this->db->bind(2,$id);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->count : 0;
    }
    // count meter by status
    public function countMeterByStatus($status,$id){
      $this->db->query("SELECT COUNT(id) AS count FROM ".SCHEDULE_TBL." WHERE status = ? AND cid = ? ");
      $this->db->bind(1,$status);
      $this->db->bind(2,$id);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->count : 0;
    }
    public function countMeter($status,$id){
      $this->db->query("SELECT COUNT(id) AS count FROM ".FAULTY_TBL." WHERE status = ? AND cmp = ? AND device=? ");
      $this->db->bind(1,$status);
      $this->db->bind(2,$id);
      $this->db->bind(3,'meter');
      $row = $this->db->single();
      return $this->db->rowCount()> 0 ? $row->count : 0;
    }
    // count number of edat asigned
    public function countAsignedEdat($id){
      $this->db->query("SELECT COUNT(eid) AS count FROM ".EDAT_TBL." WHERE cmp = ? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
     return $this->db->rowCount()> 0 ? $row->count : 0;
    }
    public function countMonthlyMeterInstallation($id){
      $this->db->query("SELECT COUNT(id) AS count,metertype,created_on AS month FROM ".SCHEDULE_TBL." WHERE status= 'installed' AND cid=?
                        GROUP BY MONTH(created_on),metertype ORDER BY created_on DESC");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $this->db->rowCount() > 0 ? $row : 0;
    }
    // count number of meters asigned
    public function countAsignedMeters($id){
      $this->db->query("SELECT COUNT(id) AS count FROM ".SCHEDULE_TBL." WHERE cid = ? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
     return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    // count number of staff
    public function totalStaff($id){
      $this->db->query('SELECT COUNT(id) AS count FROM  '.USER_TBL.' WHERE cm_id=?');
      $this->db->bind(1,$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    // dashboards stop here
    // staff Details goes here
    public function staffDetails($id){
      $this->db->query("SELECT u.id AS userId,u.mail,u.uid,u.userstatus,s.*, t.team, r.role AS level FROM ".USER_TBL." u
                      LEFT JOIN ". STAFF_TBL ."  s ON u.id = s.id LEFT JOIN ".TEAM_TBL." t ON
                      t.id=u.team LEFT JOIN ".ROLE_TBL." r ON u.level =r.id WHERE cm_id = ? ORDER BY uid ASC");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }

    // this method get company id
    public function getCompany(){
      $this->db->query("SELECT cm_id,names FROM ".USER_TBL." LEFT JOIN ".COMPANY_TBL." ON cmid=cm_id WHERE id = ?");
      $this->db->bind(1,userId());
      $row=$this->db->single();
      return ($this->db->rowCount()>0) ? $row : 0;
    }

    // group method stop here


    // read customer from database
    public function viewCustomer($id){
      $this->db->query("SELECT s.*,u.uid FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
                       WHERE s.status = 'not install' AND cid = ? ORDER BY created_on DESC");
      $this->db->bind(1,$id);
      $results = $this->db->resultSet();
      return $results;
    }
    public function meters($id,$status){
      $this->db->query("SELECT c.*,m.*,u.uid, m.doi AS payment_date FROM ".SCHEDULE_TBL. " c INNER JOIN ". MET_TBL ." m ON
                    c.id=m.cid LEFT JOIN ". USER_TBL ." u ON u.id = c.uid WHERE c.cid=:cmp AND m.status=:status ORDER BY m.doi DESC ");
       $this->db->bind(':cmp',$id);
       $this->db->bind(':status',$status);
       $results = $this->db->resultSet();
       return $results;
    }
    // meters goes here


    //edats goes here
    public function asignedEdat($id){
      $this->db->query("SELECT e.*, u.uid FROM ". EDAT_TBL. " e LEFT JOIN ". USER_TBL ." u ON u.id=e.installer WHERE cmp = ? ");
      $this->db->bind(1,$id);
      $results=$this->db->resultSet();
      return $results;
    }
    // fetch edat by status
    public function fetchEdats($id,$sts){
      $this->db->query("SELECT e.*, u.uid FROM ".EDAT_TBL." e LEFT JOIN ". USER_TBL." u ON u.id=e.installer
                        WHERE cmp= ? AND edatstatus= ?");
      $this->db->bind(1,$id);
      $this->db->bind(2,$sts);
      $results=$this->db->resultSet();
      return $results;
    }
    // load staff activity
    public function report($id){
      $this->db->query("SELECT activity,time FROM ".LOG_TBL." l INNER JOIN ".USER_TBL." u
                      ON u.id=l.uid WHERE u.cm_id=? ORDER BY time DESC LIMIT 300");
      $this->db->bind(1,$id);
      $results=$this->db->resultSet();
      return $results;
    }
  }
