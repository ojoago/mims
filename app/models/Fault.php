<?php
  class Fault{
    private $db;
    public function __construct(){
      $this->db = new Database;
    }
    public function asignFaultyMeter($data){
      return !empty($data['cmp']) ? $this->asignToCompany($data) : $this->asignedToInstaller($data);
    }
    // asign meter or edat to installer
    private function asignedToInstaller($data){
      $this->db->query("INSERT INTO ".FAULTY_TBL. " (did,asignedto,device) VALUES(:did,:asignedto,:device)");
      $this->db->bind(':did',$data['did']);
      $this->db->bind(':asignedto',$data['installer']);
      $this->db->bind(':device',$data['device']);
      unset($data);
     //execute
      if($this->db->execute()){
        return ($data['device']=='meter') ? $this->updateMeterStatus($data['did']) : $this->updateEdatStatus($data['did']);
      }
    }
    private function asignToCompany($data){
      $this->db->query("INSERT INTO ". FAULTY_TBL ." (did,asignedto,cmp,device) VALUES(:did,:asignedto,:cmp,:device) ");
      $this->db->bind(':did',$data['did']);
      $this->db->bind(':asignedto',$data['installer']);
      $this->db->bind(':cmp',$data['cmp']);
      $this->db->bind(':device',$data['device']);
     //execute
     if($this->db->execute()){
       return ($data['device']=='meter') ? $this->updateMeterStatus($data['did']) : $this->updateEdatStatus($data['did']);
     }
    }
    private function updateMeterStatus($id){
      $this->db->query("UPDATE ".INSTALL_MET_TBL." SET status=:status WHERE id=:id LIMIT 1 ");
      $this->db->bind(':status','faulty');
      $this->db->bind(':id',$id);
     //execute
      return ($this->db->execute()) ? true : false;
    }
    public function fixfaultyMeter($data){
      $this->db->query("INSERT INTO ".RVD_MET_TBL ." (mid,oldseal,new_seal,oldmeter,newmeter,fault,solution,status,foto,date,installer)
                        VALUES(:mid,:oldseal,:new_seal,:oldmeter,:newmeter,:fault,:solution,:status,:foto,:date,:installer)");
       $this->db->bind(':mid',$data['id']);
       $this->db->bind(':oldseal',$data['oldseal']);
       $this->db->bind(':new_seal',$data['seal']);
       $this->db->bind(':oldmeter',$data['oldmeter']);
       $this->db->bind(':newmeter',$data['newmeter']);
       $this->db->bind(':fault',$data['fault']);
       $this->db->bind(':solution',$data['solution']);
       $this->db->bind(':status',$data['status']);
       $this->db->bind(':foto',$data['meterfoto']);
       $this->db->bind(':date',$data['date']);
       $this->db->bind(':installer',$data['installer']);
       return $this->db->execute() ? true : false;
    }
    public function reportFault($data){
      if(!$this->idExist($data['id'])){
        $this->db->query("INSERT INTO ".FAULTY_TBL." SET did=:id, asignedto=:sid,device=:met, status=:sts ");
        $this->db->bind(':id',$data['id']);
        $this->db->bind(':sid',userId());
        $this->db->bind(':met','meter');
        $this->db->bind(':sts',$data['status']);
        $this->db->execute();
      }
      return $this->updateMeterStatus($data['id']);
    }
    private function idExist($id){
      $this->db->query("SELECT id FROM ".FAULTY_TBL." WHERE did=? AND device='meter' LIMIT 1");
      $this->db->bind(1,$id);
      $this->db->single();
      $this->db->rowCount() > 0 ? true :false;
    }
    public function updateMeterNumber($id,$num){
      $this->db->query("UPDATE ".INSTALL_MET_TBL." SET meter_no=:meternum,status=:sts WHERE id=:id LIMIT 1 ");
      $this->db->bind(':meternum',$num);
      $this->db->bind(':sts','Replacement');
      $this->db->bind(':id',$id);
      return $this->db->execute() ? true : false;
    }
    public function updateSealNStatus($id,$seal,$status){
      $this->db->query("UPDATE ".INSTALL_MET_TBL." SET seal_number=:seal,status=:status WHERE id=:id LIMIT 1 ");
      $this->db->bind(':seal',$seal);
      $this->db->bind(':status',$status);
      $this->db->bind(':id',$id);
      return $this->db->execute() ? true : false;
    }
    public function findMetandSeal($id){
      $this->db->query("SELECT seal_number,meter_no FROM ".INSTALL_MET_TBL." WHERE id=? ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row : 0;
    }
    // edat goes here
    public function asignFaultyEdat($data){
      return !empty($data['cmp']) ? $this->asignToCompany($data) : $this->asignedToInstaller($data);
    }

    private function updateEdatStatus($id){
      $this->db->query("UPDATE ". EDAT_TBL." SET edatstatus=:edatstatus WHERE eid=:eid LIMIT 1 ");
      $this->db->bind(':edatstatus','faulty');
      $this->db->bind(':eid',$id);
      return $this->db->execute() ? true : false;
    }
    // fix edat process goes here
    // find existing edat and seal
    public function findedatandSeal($id){
      $this->db->query("SELECT edatnumber,seal FROM ".EDAT_TBL." WHERE eid=:eid");
      $this->db->bind(':eid',$id);
      $row=$this->db->single();
      return $this->db->rowCount()>0 ? $row : false;
    }
    // update edat status after updating resolved_edat table
    public function fixfaultyEdat($data){
      $this->db->query("INSERT INTO ". RVD_EDT_TBL ." (edatid,fault,status,solution,date,foto,oldseal,newseal,oldnum,newnum)
                        VALUES (:edatid,:fault,:status,:solution,:date,:foto,:oldseal,:newseal,:oldnum,:newnum) ");
      $this->db->bind(':edatid',$data['eid']);
      $this->db->bind(':fault',$data['fault']);
      $this->db->bind(':status',$data['status']);
      $this->db->bind(':solution',$data['solution']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':foto',$data['foto']);
      $this->db->bind(':oldseal',$data['oldsel']);
      $this->db->bind(':newseal',$data['seal']);
      $this->db->bind(':oldnum',$data['oldedat']);
      $this->db->bind(':newnum',$data['edatnum']);
      return $this->db->execute() ? true : false;
    }
    public function updateEdatInfo($eid,$seal,$status){
      $this->db->query("UPDATE ". EDAT_TBL ."  SET seal=:seal,edatstatus=:edatstatus WHERE eid=:eid ");
      $this->db->bind(':eid',$eid);
      $this->db->bind(':seal',$seal);
      $this->db->bind(':edatstatus',$status);
      return ($this->db->execute()) ? true : false;
    }
    // update edat number when replaced
    public function updateEdatNumber($eid,$num){
      $this->db->query("UPDATE ". EDAT_TBL ."  SET edatnumber=:edatnumber WHERE eid=:eid ");
      $this->db->bind(':eid',$eid);
      $this->db->bind(':edatnumber',$num);
      return $this->db->execute() ? true : false;
    }
  }
