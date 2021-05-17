<?php
/**
 *
 */
class Api{
  private $db;
  public function __construct()  {
    $this->db = new Database;
  }
  public function scheduleCustomer($data){
    $this->db->query("INSERT INTO ".SCHEDULE_TBL." SET accountnumber=:accountnumber,accountname=:accountname,address=:address,gsm=:gsm,region=:region,
    area=:area,feeder=:feeder,dt=:dt,metertype=:metertype,paymentdate=:paymentdate,duration=:duration,created_on=:created_on ");
    $this->db->bind(':accountnumber',$data['accountno']);
    $this->db->bind(':accountname',$data['accountname']);
    $this->db->bind(':address',$data['address']);
    $this->db->bind(':gsm',$data['phone']);
    $this->db->bind(':region',$data['region']);
    $this->db->bind(':area',$data['area']);
    $this->db->bind(':feeder',$data['feeder']);
    $this->db->bind(':dt',$data['dt']);
    $this->db->bind(':metertype',$data['metertype']);
    $this->db->bind(':paymentdate',$data['date']);
    $this->db->bind(':duration',$data['duration']);
    $this->db->bind(':created_on',DATE('d-m-Y H:i:s'));
    return ($this->db->execute()) ? true : false;
  }

  public function updateCustomerStatus($data){
    $this->db->query("UPDATE ".SCHEDULE_TBL." SET status =:status,edited_on=:edited_on WHERE id = :id ");
    $this->db->bind(':status',$data['status']);
    $this->db->bind(':edited_on',DATE('d-m-Y H:i:s'));
    $this->db->bind(':id',$data['id']);
    return ($this->db->execute()) ? true : false;
  }
  public function findByAccount($account){
    $this->db->query("SELECT * FROM ".SCHEDULE_TBL." WHERE accountnumber=? LIMIT 1");
    $this->db->bind(1,$account);
    $row=$this->db->single();
    return ($this->db->rowCount()>0) ? $row :false;
  }
  public function findById($id){
    $this->db->query("SELECT id FROM ".SCHEDULE_TBL." WHERE id=? LIMIT 1");
    $this->db->bind(1,$id);
    $row=$this->db->single();
    return ($this->db->rowCount()>0) ? true :false;
  }

}
