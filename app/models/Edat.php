<?php
  class Edat{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    // display edat on index pay
    public function viewEdats(){
      $this->db->query("SELECT e.*, u.uid,s.state_name FROM ".EDAT_TBL." e LEFT JOIN ".USER_TBL." u ON installer = id
        LEFT JOIN ".STATE." s ON s.id = state  ORDER BY date DESC LIMIT 200");
        $row = $this->db->resultSet();
        return $row;
    }
    // check type of request and update or add new record
    public function save($data){
    return $this->db->findById(EDAT_TBL,'edatnumber',$data['edatnum']) ? $this->update($data) : $this->create($data);
    }
    private function create($data){
      $this->db->query('INSERT INTO '.EDAT_TBL.' SET edatnumber=:edatnumber,channel=:channel,edatstatus=:edatstatus,date=:date,
                        dt_name=:dt_name,pole=:pole,installer=:installer,state=:state,e_address=:e_address');
      $this->db->bind(':edatnumber',$data['edatnum']);
      $this->db->bind(':channel',$data['rf']);
      $this->db->bind(':edatstatus',$data['edatstatus']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':dt_name',$data['dtname']);
      $this->db->bind(':pole',$data['pole']);
      $this->db->bind(':installer',$data['asignedto']);
      $this->db->bind(':state',$data['state']);
      $this->db->bind(':e_address',$data['address']);
      unset($data);
     //execute
     $r = ($this->db->execute()) ? true : false;
     reportLog('Schedule edat',lastID());
     return $r;
    }
    private function update($data){
      $this->db->query('UPDATE '.EDAT_TBL.' SET channel=:channel,edatstatus=:edatstatus,date=:date,dt_name=:dt_name,pole=:pole,
                    installer=:installer,state=:state,e_address=:e_address WHERE edatnumber=:edatnumber');
      $this->db->bind(':channel',$data['rf']);
      $this->db->bind(':edatstatus',$data['edatstatus']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':dt_name',$data['dtname']);
      $this->db->bind(':pole',$data['pole']);
      $this->db->bind(':installer',$data['asignedto']);
      $this->db->bind(':state',$data['state']);
      $this->db->bind(':edatnumber',$data['edatnum']);
      $this->db->bind(':e_address',$data['address']);
      unset($data);
     //execute
     $r= ($this->db->execute()) ? true : false;
     reportLog('Schedule edat',lastID());
     return $r;
    }
    public function installEdat($data){
      $this->db->query("UPDATE ".EDAT_TBL." SET date=:date,edatstatus=:edatstatus,edatfoto=:edatfoto,remark=:remark,
                        e_x=:e_x,e_y=:e_y,installer=:installer WHERE eid=:eid LIMIT 1");
      $this->db->bind(':date',$data['doi']);
      $this->db->bind(':edatstatus',$data['status']);
      $this->db->bind(':edatfoto',$data['edatfoto']);
      $this->db->bind(':remark',$data['remark']);
      $this->db->bind(':e_x',$data['lat']);
      $this->db->bind(':e_y',$data['long']);
      $this->db->bind(':installer',userId());
      $this->db->bind(':eid',$data['eid']);
      return $this->db->execute() ? true : false;
    }
    // update edat information
    public function updateEdat($data){
      $this->db->query("UPDATE ".EDAT_TBL." SET edatnumber=:edatnumber,channel=:channel,dt_name=:dt_name,pole=:pole,
                        e_address=:e_address,e_x=:e_x,e_y=:e_y WHERE eid =:eid LIMIT 1");
      $this->db->bind(':edatnumber',$data['edatnumber']);
      $this->db->bind(':channel',$data['rf']);
      $this->db->bind(':dt_name',$data['dtname']);
      $this->db->bind(':pole',$data['pole']);
      $this->db->bind(':e_address',$data['add']);
      $this->db->bind(':eid',$data['id']);
      $this->db->bind(':e_x',$data['x']);
      $this->db->bind(':e_y',$data['y']);
     return ($this->db->execute()) ? true : false;
    }
    // this method check if edat has been installed
    public function edatExist($num){
        $this->db->query("SELECT eid FROM ".EDAT_TBL." WHERE edatnumber = :edatnumber LIMIT 1 ");
        $this->db->bind(':edatnumber',$num);
        //$this->db->bind(':edatstatus','NOT INSTALL');
        $row = $this->db->single();
        return ($this->db->rowCount()) ? $row->eid : false;
    }
    // check if edat is not asign
    // public function edatNotAsign($id){
    //   // $_SESSION['comsPrimeUserId']
    //   $this->db->query("SELECT eid FROM EDAT_TBL WHERE");
    // }
    // asign edat to customer
    public function asignCompany($edat_id,$company_id,$installer_id){
      $this->db->query("UPDATE ".EDAT_TBL." SET installer = :installer, cmp=:cmp WHERE eid = :eid LIMIT 1");
      $this->db->bind(':installer',$installer_id);
      $this->db->bind(':cmp',$company_id);
      $this->db->bind(':eid',$edat_id);
      return ($this->db->execute()) ? true : false;
    }
  }
