<?php
  class Installer{
    private $db;
    protected $cid;
    public function __construct(){
      $this->db = new Database;
    }
    // dashboards query start here
    // count edats conditionally
    public function countEdatByStatus($status,$id){
      $this->db->query("SELECT COUNT(eid) AS count FROM  ".EDAT_TBL." WHERE edatstatus = ? AND installer = ? ");
      $this->db->bind(1,$status);
      $this->db->bind(2,$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    // count meter by status
    public function countMeterByStatus($status,$id){
      $this->db->query("SELECT COUNT(id) AS count FROM ".SCHEDULE_TBL." WHERE status = ? AND uid = ? ");
      $this->db->bind(1,$status);
      $this->db->bind(2,$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    // count number of edat asigned
    public function countAsignedEdat($id){
      $this->db->query("SELECT COUNT(eid) AS count FROM ".EDAT_TBL." WHERE installer = ? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
     return ($this->db->rowCount()>0) ? $row->count : 0;
    }
    // count number of meters asigned
    public function countAsignedMeters($id){
      $this->db->query("SELECT COUNT(*) AS count FROM ".SCHEDULE_TBL." WHERE uid = ? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
     return ($this->db->rowCount()>0) ? $row->count : 0;
    }

    // dashboards stop here

    // this method get company id
    public function getCompany(){
      $this->db->query("SELECT cm_id,names FROM ". USER_TBL ." LEFT JOIN ". COMPANY_TBL ." ON cmid=cm_id WHERE id = ?");
      $this->db->bind(1,userId());
      $row=$this->db->single();
      return ($this->db->rowCount()>0) ? $row : 0;
    }

    // read customer from database
    public function viewCustomer($id){
      $this->db->query("SELECT s.*,u.uid FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
                       WHERE s.uid = ? ORDER BY created_on DESC");
      $this->db->bind(1,$id);
      $results = $this->db->resultSet();
      return $results;
    }
    public function meters($id,$status){
      $this->db->query("SELECT c.*,m.*,u.uid, m.doi AS payment_date FROM ".SCHEDULE_TBL." c
                        INNER JOIN ". MET_TBL ." m ON c.id=m.cid LEFT JOIN ".USER_TBL." u ON u.id = c.uid
                        WHERE c.uid=:uid AND m.status=:status ORDER BY m.doi DESC ");
       $this->db->bind(':uid',$id);
       $this->db->bind(':status',$status);
       $results = $this->db->resultSet();
       return $results;
    }
    // meters goes here


    //edats goes here
    public function asignedEdat($id){
      $this->db->query("SELECT e.*, u.uid FROM ". EDAT_TBL. " e LEFT JOIN ". USER_TBL ." u ON u.id=e.installer WHERE installer = ? ");
      $this->db->bind(1,$id);
      $results=$this->db->resultSet();
      return $results;
    }
    // fetch edat by status
    public function fetchEdats($id,$sts){
      $this->db->query("SELECT e.*, u.uid FROM ". EDAT_TBL ." e LEFT JOIN ". USER_TBL." u ON u.id=e.installer
                        WHERE installer = ? AND edatstatus= ?");
      $this->db->bind(1,$id);
      $this->db->bind(2,$sts);
      $results=$this->db->resultSet();
      return $results;
    }

    public function countMonthlyMeterInstallation(){
      $this->db->query("SELECT COUNT(id) AS count,created_on AS month,metertype FROM ".SCHEDULE_TBL." WHERE status= 'installed' AND uid=?
                        GROUP BY MONTH(created_on),metertype ORDER BY created_on DESC");
      $this->db->bind(1,userId());
      $row=$this->db->resultSet();
      return $this->db->rowCount() > 0 ? $row : 0;
    }
  }
