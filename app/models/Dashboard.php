<?php
 /**
  *
  */
 class Dashboard{
   private $db;
   public function __construct(){
     $this->db = new Database;
   }
   // new dashboards start here
   public function lineChartDaily(){
     $this->db->query("SELECT date,SUM(meters) AS meter,SUM(replaced) AS replaced,SUM(installed) AS installed FROM ".TEAM_REC_TBL."
                      WHERE MONTH(date) =:m AND YEAR(date) = :y GROUP BY date ORDER BY date ASC");
     $this->db->bind(':m',date('m'));
     $this->db->bind(':y',date('Y'));
     $row=$this->db->resultSet();
     return $row;
   }
    // new dashboards start here
   public function lineChartMonth(){
     $this->db->query("SELECT date,SUM(meters) AS meter,SUM(replaced) AS replaced,SUM(installed) AS installed FROM ".TEAM_REC_TBL."
                       GROUP BY MONTH(date) ORDER BY date ASC");
     $row=$this->db->resultSet();
     return $row;
   }
   // new dashboards stop here
   // get what is asigned to each company
   public function companyInstallation($data=''){
     if(empty($data)){
       $this->db->query("SELECT COUNT(id) AS count,cid,names FROM ".SCHEDULE_TBL." LEFT JOIN ".COMPANY_TBL." ON cid=cmid GROUP BY cid");
     }else{
       $this->db->query("SELECT COUNT(id) AS count,cid,names FROM ".SCHEDULE_TBL." LEFT JOIN ".COMPANY_TBL." ON cid=cmid WHERE DATE(created_on) BETWEEN ? AND ? GROUP BY cid");
       $this->db->bind(1,$data['from']);
       $this->db->bind(2,$data['to']);
     }
     $row = $this->db->resultSet();
     return $row;
   }
   // get what is asigned to each company and Breakdown
   public function companyTypeStatus($data=''){
     if(empty($data)){
       $this->db->query("SELECT COUNT(id) AS count,cid,names,metertype,status FROM ".SCHEDULE_TBL."
                        LEFT JOIN ".COMPANY_TBL." ON cid=cmid GROUP BY cid,metertype,status
                        ORDER BY cid,metertype,status ASC");
     }else{
       $this->db->query("SELECT COUNT(id) AS count,cid,names,metertype,status FROM ".SCHEDULE_TBL."
                        LEFT JOIN ".COMPANY_TBL." ON cid=cmid WHERE DATE(created_on) BETWEEN ? AND ? GROUP BY cid,metertype,status
                        ORDER BY cid,metertype,status ASC");
       $this->db->bind(1,date('Y-m-d',strtotime($data['from'])));
       $this->db->bind(2,date('Y-m-d',strtotime($data['to'])));
     }
     $row = $this->db->resultSet();
     return $row;
   }

   // get what is in each region by type and status
   public function regionTypeStatus($data=[]){
     if(empty($data)){
       $this->db->query("SELECT COUNT(id) AS count,region,metertype,status FROM ".SCHEDULE_TBL."
                       GROUP BY region,metertype,status ORDER BY region,metertype,status ASC");
     }else{
       $this->db->query("SELECT COUNT(id) AS count,region,metertype,status FROM ".SCHEDULE_TBL."
                        WHERE DATE(created_on) BETWEEN ? AND ?
                        GROUP BY region,metertype,status ORDER BY region,metertype,status ASC");
       $this->db->bind(1,date('Y-m-d',strtotime($data['from'])));
       $this->db->bind(2,date('Y-m-d',strtotime($data['to'])));
     }
     $row = $this->db->resultSet();
     return $row;
   }
   // get schedule in each feeder
   public function groupSchedulByEdat($data=[]){
     if(empty($data)){
       $this->db->query("SELECT COUNT(id) AS count,feeder FROM ".SCHEDULE_TBL."
                       GROUP BY feeder ORDER BY feeder");
     }else{
       $this->db->query("SELECT COUNT(id) AS count,feeder FROM ".SCHEDULE_TBL."
                       WHERE DATE(created_on) BETWEEN ? AND ? GROUP BY feeder ORDER BY feeder");
       $this->db->bind(1,date('Y-m-d',strtotime($data['from'])));
       $this->db->bind(2,date('Y-m-d',strtotime($data['to'])));
     }

     $row = $this->db->resultSet();
     return $row;
   }

   // schedules that  drop in each region
   public function region($data=[]){
      if(empty($data)){
        $this->db->query("SELECT COUNT(id) AS count,region FROM ".SCHEDULE_TBL." LEFT JOIN ".COMPANY_TBL." ON cid=cmid GROUP BY region");
      }else{
        $this->db->query("SELECT COUNT(id) AS count,region FROM ".SCHEDULE_TBL." LEFT JOIN ".COMPANY_TBL." ON cid=cmid WHERE DATE(created_on) BETWEEN ? AND ? GROUP BY region");
        $this->db->bind(1,date('Y-m-d',strtotime($data['from'])));
        $this->db->bind(2,date('Y-m-d',strtotime($data['to'])));
      }
        $row = $this->db->resultSet();
        return $row;
   }

   // get meter status :install, replaced, fixed, faulty etc
   public function meterStatus($data=[]){
    if(empty($data)){
      $this->db->query("SELECT COUNT(mid) AS count,status FROM ".MET_TBL." GROUP BY status");
    }else{
      $this->db->query("SELECT COUNT(mid) AS count,status FROM ".MET_TBL." WHERE doi
                    BETWEEN ? AND ? GROUP BY status");
      $this->db->bind(1,$data['from']);
      $this->db->bind(2,$data['to']);
    }
    $row = $this->db->resultSet();
    return $row;
  }
  // get meter tech : RF, plc
  public function meterTech($data=[]){
    if(empty($data)){
      $this->db->query("SELECT COUNT(mid) AS count,tech FROM ".MET_TBL." GROUP BY tech");
    }else{
      $this->db->query("SELECT COUNT(mid) AS count,tech FROM ".MET_TBL." WHERE doi
                    BETWEEN ? AND ? GROUP BY tech");
      $this->db->bind(1,$data['from']);
      $this->db->bind(2,$data['to']);
    }
    $row = $this->db->resultSet();
    return $row;
  }
  // get meter statsu : edat installed not install
  public function meterNoEdat($data=[]){
    if(empty($data)){
      $this->db->query("SELECT COUNT(eid) AS count,region,edatstatus FROM ".MET_TBL."
                        INNER JOIN  ".EDAT_TBL." ON edat_id=eid INNER JOIN ".SCHEDULE_TBL." c
                        ON c.cid=id GROUP BY region,edatstatus");
    }else{
      $this->db->query("SELECT COUNT(eid) AS count,region,edatstatus FROM ".MET_TBL."
                        INNER JOIN  ".EDAT_TBL." ON edat_id=eid INNER JOIN ".SCHEDULE_TBL." c
                        ON c.cid=id WHERE doi BETWEEN ? AND ? GROUP BY region,edatstatus");
      $this->db->bind(1,$data['from']);
      $this->db->bind(2,$data['to']);
    }
    $row = $this->db->resultSet();
    return $row;
  }

  // get stuck in store
  public function inventory(){
    $this->db->query("SELECT qnt,i.name,s.name AS store FROM ".STORE_INVENT_ITEM." i INNER JOIN ".INVENT_TBL." q
                    ON q.pid=i.id INNER JOIN ".STORE_TBL." s ON s.id=q.sid  GROUP BY i.name,i.id,q.id
                     ORDER BY s.name ASC");
    $row = $this->db->resultSet();
    return $row;
  }
  // what comes in and go out
  public function inOut($data=[]){
    $this->db->query("SELECT SUM(quantity) AS sum,category,i.name,s.name AS store FROM ".INVENT_LOG." l
                      INNER JOIN ".INVENT_TBL." q ON q.id=l.sid INNER JOIN ".STORE_INVENT_ITEM." i ON
                      q.pid=i.id INNER JOIN ".WAYBILL." w
                      ON wbi=wbid INNER JOIN ".STORE_TBL." s
                      ON q.id=s.id GROUP BY s.name,i.name,i.id,category ORDER BY s.name ASC");
    $row = $this->db->resultSet();
    return $row;
  }


  // what comes to store alone
  public function srin($data=[]){
    $this->db->query("SELECT SUM(quantity) AS sum,i.name,s.name AS store FROM ".INVENT_LOG." l INNER JOIN ".INVENT_TBL." q
                      ON q.id=l.id INNER JOIN ".STORE_INVENT_ITEM." i ON q.pid=i.id INNER JOIN ".WAYBILL." w
                      ON wbid=wbi INNER JOIN ".STORE_TBL." s ON q.id=s.id  WHERE w.category = 'SR-IN'
                      GROUP BY i.name,i.id ORDER BY s.name ASC");
    $row = $this->db->resultSet();
    return $row;
  }

  // what goes out of store alone
  public function srcn($data=[]){
    $this->db->query("SELECT SUM(quantity) AS sum,i.name,s.name AS store FROM ".INVENT_LOG." l INNER JOIN ".INVENT_TBL." q
                      ON q.id=l.id INNER JOIN ".STORE_INVENT_ITEM." i ON q.pid=i.id INNER JOIN ".WAYBILL." w
                      ON wbi=wbid INNER JOIN ".STORE_TBL." s ON q.id=s.id  WHERE w.category = 'SR-CN'
                      GROUP BY i.name,i.id ORDER BY s.name ASC");
    $row = $this->db->resultSet();
    return $row;
  }

 }
