<?php
class Schedule{
    private $db;
    private $db_tbl="comsprime_customer";
    protected $payments='comsprime_payments';
    private $cust_tbl="customertbl";
    private $edat_tbl="edat_tbl";
    private $meterTbl = "metertbl";
    public function __construct(){
        $this->db = new Database;
    }
    public function scheduleCustomer($data){
        $this->db->query('INSERT INTO '.$this->cust_tbl.' (accountnum,accountname,gsm,address,clm,state,tzone,
        feeder33,feeder,dtname,dtcode,upriser,pole,customertype,metertype, surveystatus, pdate, asignedto)
        VALUES(:accountnum,:accountname,:gsm,:address,:clm,:state,:tzone,:feeder33,:feeder,:dtname,:dtcode,:upriser,
        :pole,:customertype,:metertype,:surveystatus,:pdate,:asignedto)');
        $this->db->bind(':accountnum',$data['accountnum']);
        $this->db->bind(':accountname',$data['accountname']);
        $this->db->bind(':gsm',$data['gsm']);
        $this->db->bind(':address',$data['address']);
        $this->db->bind(':clm',$data['clm']);
        $this->db->bind(':dtcode',$data['dtcode']);
        $this->db->bind(':state',$data['state']);
        $this->db->bind(':tzone',$data['region']);
        $this->db->bind(':feeder33',$data['kv33']);
        $this->db->bind(':feeder',$data['feeder']);
        $this->db->bind(':dtname',$data['dtname']);
        $this->db->bind(':upriser',$data['upriser']);
        $this->db->bind(':pole',$data['pole']);
        $this->db->bind(':customertype',$data['ctype']);
        $this->db->bind(':metertype',$data['metertype']);
        $this->db->bind(':surveystatus',$data['surveystatus']);
        $this->db->bind(':pdate',$data['date']);
        $this->db->bind(':asignedto',$data['asignedto']);
       // $this->db->bind(':accountnum',$data['email']);
       //execute
       unset($data);
       return ($this->db->execute()) ? true : false;
    }
    public function scheduleMeter($data){
      $this->db->query('INSERT INTO '.$this->meterTbl.' SET cid =:cid,edat_id =:edat_id, meternum =:meternum, seal =:seal,
      preload =:preload,tarif =:tarif,advicetarif =:advicetarif, doi=:doi,meterfoto=:meterfoto, m_x=:m_x, m_y=:m_y,
      remark=:remark, status=:status');
      $this->db->bind(':cid',$data['custId']);
      $this->db->bind(':edat_id',$data['eid']);
      $this->db->bind(':meternum',$data['meterNumber']);
      $this->db->bind(':seal',$data['seal']);
      $this->db->bind(':preload',$data['preload']);
      $this->db->bind(':tarif',$data['tariff']);
      $this->db->bind(':advicetarif',$data['advtariff']);
      $this->db->bind(':doi',$data['status']);
      $this->db->bind(':meterfoto',$data['meterfoto']);
      $this->db->bind(':m_x',$data['latitude']);
      $this->db->bind(':m_y',$data['longitude']);
      $this->db->bind(':remark',$data['remark']);
      $this->db->bind(':status',$data['status']);
     unset($data);
     return ($this->db->execute()) ? true : false;
    }
    // asign meter to installer for installation
    public function asignCompany($cm,$cid,$uid){
      $this->db->query("UPDATE ".SCHEDULE_TBL." SET uid = :uid, cid=:cid WHERE id = :id LIMIT 1");
      $this->db->bind(':cid',$cid);
      $this->db->bind(':id',$cm);
      $this->db->bind(':uid',$uid);
      return ($this->db->execute()) ? true : false;
    }

    public function scheduleEdat($data){
        $this->db->query('INSERT INTO '.$this->edat_tbl.' (edatnumber, channel, edatstatus, date, dt_name, pole, installer, e_pid)
        VALUES(:edatnumber,:channel,:edatstatus,:date,:dt_name,:pole,:installer,:e_pid)');
        $this->db->bind(':edatnumber',$data['edatnum']);
        $this->db->bind(':channel',$data['rf']);
        $this->db->bind(':edatstatus',$data['edatstatus']);
        $this->db->bind(':date',$data['date']);
        $this->db->bind(':dt_name',$data['dtname']);
        $this->db->bind(':pole',$data['pole']);
        $this->db->bind(':installer',$data['asignedto']);
        $this->db->bind(':e_pid',$data['project']);
        unset($data);
       //execute
       return ($this->db->execute()) ? true : false;
    }

    public function edatId($id){
      $this->db->query("SELECT eid FROM ".$this->edat_tbl." WHERE edatnumber = :edatnumber LIMIT 1");
      $this->db->bind(':edatnumber',$id);
      $row = $this->db->single();
      return ($this->db->rowCount()) ? $row->eid : $this->insertEdatNumber($id);
    }
    private function insertEdatNumber($id){
        $this->db->query('INSERT INTO '.$this->edat_tbl.' SET edatnumber = :edatnumber');
        $this->db->bind(':edatnumber',$id);
        return ($this->db->execute()) ? $this->db->lastId() : false;
    }
}
