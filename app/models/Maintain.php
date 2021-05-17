<?php
class Maintain{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    public function faultyMeter(){
      $this->db->query("SELECT DISTINCT f.did, m.meter_no,m.status,u.uid FROM ". FAULTY_TBL ." f
                      INNER JOIN ".INSTALL_MET_TBL." m ON did= m.id LEFT JOIN ".USER_TBL." u ON u.id = f.asignedto WHERE device='meter' AND  m.pid= ? ");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $row;
    }
    public function faultyEdat(){
      $this->db->query("SELECT DISTINCT f.did,e.edatnumber,e.edatstatus,u.uid FROM ". FAULTY_TBL ." f
                        INNER JOIN ".EDAT_TBL." e ON did=eid LEFT JOIN ".USER_TBL." u ON u.id=f.asignedto WHERE device='edat' AND  f.pid= ? ");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadEdat(){
      $this->db->query("SELECT COUNT(mid) AS count,e.edatnumber,e.eid,e.dt_name,e.channel,e_address,e_x,e_y FROM ".EDAT_TBL." e LEFT JOIN ".MET_TBL."
                      ON eid=edat_id WHERE edatstatus='installed' AND e_pid=? GROUP BY edatnumber ");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadMeter($id=0){
      $this->db->query("SELECT meternum,m_x,m_y,rf,dt,edat_id,edatnumber,mid FROM ".MET_TBL." m INNER JOIN ".SCHEDULE_TBL." s
                        ON m.cid=s.id LEFT JOIN ".EDAT_TBL." e ON eid=edat_id ORDER BY edat_id ASC ");
      $row=$this->db->resultSet();
      return $row;
    }
    // write to database
    public function mapEdatToMeter($eid,$mid){
      $this->db->query("UPDATE ".MET_TBL." SET edat_id=:eid WHERE mid=:mid LIMIT 1");
      $this->db->bind(':eid',$eid);
      $this->db->bind(':mid',$mid);
      return $this->db->execute() ? true : false;
    }
    public function box(){
      $this->db->query("SELECT COUNT(mid) AS  count,box,tech,m_x,m_y,meterfoto,dt,feeder FROM ".MET_TBL." m
                        INNER JOIN ".SCHEDULE_TBL." s ON m.cid=s.id GROUP BY box");
      $results=$this->db->resultSet();
      return $results;
    }
    public function metersOnBox($box){
      $this->db->query("SELECT accountname,meternum,doi,rf,tech FROM ".MET_TBL." m INNER JOIN ".SCHEDULE_TBL." s
                        ON s.id=m.cid WHERE m.box=? ");
      $this->db->bind(1,$box);
      $results=$this->db->resultSet();
      return $results;
    }
}
