<?php
  class Meter{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    // write to database goes down here
    public function installCustomer($data){
      return empty($data['id']) ? $this->newCustomer($data) : $this->updateCustomer($data);
    }
    public function newCustomer($data){
      $this->db->query("INSERT INTO ".INSTALL_MET_TBL." SET meter_no=:meter_no,preload=:preload,state=:state,date=:date,
                        zone=:zone,dt_name=:dt_name,dt_code=:dt_code,dt_type=:dt_type,upriser=:upriser,pole=:pole,
                        presenet_tariff=:presenet_tariff,advised_tariff=:advised_tariff,din=:din,phone_number=:gsm,
                        customer_email=:mail,use_of_premises=:premises,customer_address=:address,feeder=:feeder,
                        feeder_kv=:feeder_kv,customer_phase=:phase,meter_brand=:brand,meter_tech=:tech,seal_number=:seal,
                        estimated=:estimated,account_number=:account_no,customer_remark=:remark,latitude=:x_c,longitude=:y_c,
                        installer_id=:installer,installer_supervisor=:super,rf=:rf,meter_type=:meter_type,operator=:user,
                        b_unit=:b_unit,fullname=:fullname,created_on=:created_on,pid=:pid");
      $this->db->bind(':meter_no',$data['meter_num']);
      $this->db->bind(':preload',$data['preload']);
      $this->db->bind(':state',strtoupper($data['state']));
      $this->db->bind(':date',date('Y-m-d',strtotime($data['doi'])));
      $this->db->bind(':zone',strtoupper($data['zone']));
      $this->db->bind(':dt_name',strtoupper($data['dt_name']));
      $this->db->bind(':dt_code',strtoupper($data['dt_code']));
      $this->db->bind(':dt_type',strtoupper($data['dt_type']));
      $this->db->bind(':upriser',$data['upriser']);
      $this->db->bind(':pole',$data['pole']);
      $this->db->bind(':presenet_tariff',strtoupper($data['tariff']));
      $this->db->bind(':advised_tariff',strtoupper($data['advtariff']));
      $this->db->bind(':din',$data['din']);
      $this->db->bind(':gsm',$data['gsm']);
      $this->db->bind(':mail',strtolower($data['mail']));
      $this->db->bind(':premises',strtoupper($data['premises']));
      $this->db->bind(':address',strtoupper($data['address']));
      $this->db->bind(':feeder',$data['feeder_11kv']);
      $this->db->bind(':feeder_kv',$data['feeder_33kv']);
      $this->db->bind(':phase',strtoupper($data['phase']));
      $this->db->bind(':brand',strtoupper($data['meter_brand']));
      $this->db->bind(':tech',strtoupper($data['meter_tech']));
      $this->db->bind(':seal',strtoupper($data['seal']));
      $this->db->bind(':estimated',strtoupper($data['estimated']));
      $this->db->bind(':account_no',$data['account_no']);
      $this->db->bind(':remark',strtoupper($data['remark']));
      $this->db->bind(':x_c',$data['x']);
      $this->db->bind(':y_c',$data['y']);
      $this->db->bind(':installer',$data['installer']);
      $this->db->bind(':super',$data['super']);
      $this->db->bind(':rf',$data['rf']);
      $this->db->bind(':meter_type',strtoupper($data['meter_type']));
      $this->db->bind(':b_unit',strtoupper($data['b_unit']));
      $this->db->bind(':fullname',strtoupper($data['fullname']));
      $this->db->bind(':user',userId());
      $this->db->bind(':created_on',dateTime());
      $this->db->bind(':pid',getPID());
      return $this->db->execute() ? $this->updateJedAccountCustomer($data['account_no']) : false;
    }
    private function updateJedAccountCustomer($num){
        $this->db->query("UPDATE ".JED_CUST." SET status ='installed' WHERE account_number = ? AND pid =? LIMIT 1");
        $this->db->bind(1,$num);
        $this->db->bind(2,getPID());
        return $this->db->execute() ? true : false;
    }
    public function updateCustomer($data){
      $this->db->query("UPDATE ".INSTALL_MET_TBL." SET meter_no=:meter_no,preload=:preload,state=:state,date=:date,zone=:zone,dt_name=:dt_name,
                        dt_code=:dt_code,dt_type=:dt_type,upriser=:upriser,pole=:pole,presenet_tariff=:presenet_tariff,advised_tariff=:advised_tariff,
                        din=:din,phone_number=:gsm,customer_email=:mail,use_of_premises=:premises,
                        customer_address=:address,feeder=:feeder,feeder_kv=:feeder_kv,customer_phase=:phase,meter_brand=:brand,meter_tech=:tech,
                        seal_number=:seal,estimated=:estimated,account_number=:account_no,customer_remark=:remark,latitude=:x_c,longitude=:y_c,
                        installer_id=:installer,installer_supervisor=:super,rf=:rf,meter_type=:meter_type,b_unit=:b_unit,fullname=:fullname,updated_for=:updated_for WHERE id=:id");
      $this->db->bind(':meter_no',$data['meter_num']);
      $this->db->bind(':preload',$data['preload']);
      $this->db->bind(':state',$data['state']);
      $this->db->bind(':date',date('Y-m-d',strtotime($data['doi'])));
      $this->db->bind(':zone',$data['zone']);
      $this->db->bind(':dt_name',$data['dt_name']);
      $this->db->bind(':dt_code',$data['dt_code']);
      $this->db->bind(':dt_type',$data['dt_type']);
      $this->db->bind(':upriser',$data['upriser']);
      $this->db->bind(':pole',$data['pole']);
      $this->db->bind(':presenet_tariff',$data['tariff']);
      $this->db->bind(':advised_tariff',$data['advtariff']);
      $this->db->bind(':din',$data['din']);
      $this->db->bind(':gsm',$data['gsm']);
      $this->db->bind(':mail',strtolower($data['mail']));
      $this->db->bind(':premises',$data['premises']);
      $this->db->bind(':address',$data['address']);
      $this->db->bind(':feeder',$data['feeder_11kv']);
      $this->db->bind(':feeder_kv',$data['feeder_33kv']);
      $this->db->bind(':phase',$data['phase']);
      $this->db->bind(':brand',$data['meter_brand']);
      $this->db->bind(':tech',$data['meter_tech']);
      $this->db->bind(':seal',$data['seal']);
      $this->db->bind(':estimated',$data['estimated']);
      $this->db->bind(':account_no',$data['account_no']);
      $this->db->bind(':remark',$data['remark']);
      $this->db->bind(':x_c',$data['x']);
      $this->db->bind(':y_c',$data['y']);
      $this->db->bind(':installer',$data['installer']);
      $this->db->bind(':super',$data['super']);
      $this->db->bind(':rf',$data['rf']);
      $this->db->bind(':meter_type',$data['meter_type']);
      $this->db->bind(':b_unit',$data['b_unit']);
      $this->db->bind(':fullname',ucwords($data['fullname']));
      $this->db->bind(':id',$data['id']);
      $this->db->bind(':updated_for',$data['updated_for']);
      return $this->db->execute() ? true : false;
    }
    public function verifyMeterNumberOnUpdate($num){
      $this->db->query("SELECT id FROM ".INSTALL_MET_TBL." WHERE meter_no=? ");
      $this->db->bind(1,$num);
      $row=$this->db->single();
      return $this->db->rowCount()> 0 ? $row->id: 0;
    }
    public function verifyAccountNumberOnUpdate($num){
      $this->db->query("SELECT id FROM ".INSTALL_MET_TBL." WHERE account_number=? ");
      $this->db->bind(1,$num);
      $row=$this->db->single();
      return $this->db->rowCount()> 0 ? $row->id: 0;
    }
    public function confirmMeterNumber($num){
      $this->db->query("SELECT id FROM ".MET_NUM_TBL." WHERE number = ? AND pid=? LIMIT 1");
      $this->db->bind(1,$num);
      $this->db->bind(2,getPID());
      $this->db->single();
      return $this->db->rowCount() > 0 ? true : false;
    }
    // schedule customers
    public function scheduleCustomer($data){
      $this->db->query("INSERT INTO ".SCHEDULE_TBL." SET accountnumber=:no,accountname=:name,address=:adr,gsm=:gsm,
                        region=:rgn,feeder=:fed,dt=:dt,metertype=:type,
                        paymentdate=:date,status=:sts,created_on=:date,uid=:tm ");
      $this->db->bind('no',$data['accountno']);
      $this->db->bind('name',$data['accountname']);
      $this->db->bind('adr',$data['address']);
      $this->db->bind('gsm',$data['gsm']);
      $this->db->bind('rgn',$data['region']);
      $this->db->bind('fed',$data['feeder']);
      $this->db->bind('dt',$data['dt']);
      $this->db->bind('type',$data['metertype']);
      $this->db->bind('date',$data['date']);
      $this->db->bind('sts',$data['status']);
      $this->db->bind('tm',$data['uid']);
      return $this->db->execute() ? true : false;
    }
    // install meter
    public function scheduleMeter($data){
      $this->db->query("INSERT INTO ".MET_TBL." SET cid =:cid,box=:box, meternum =:meternum, seal =:seal,
                      preload =:preload,tarif =:tarif,advicetarif =:advicetarif, doi=:doi,meterfoto=:meterfoto,
                      m_x=:m_x, m_y=:m_y,comment=:comment, status=:status,rf=:rf");
      $this->db->bind(':cid',$data['custId']);
      $this->db->bind(':box',$data['box']);
      $this->db->bind(':meternum',$data['meterNumber']);
      $this->db->bind(':seal',$data['seal']);
      $this->db->bind(':preload',$data['preload']);
      $this->db->bind(':tarif',$data['tariff']);
      $this->db->bind(':advicetarif',$data['advtariff']);
      $this->db->bind(':doi',$data['doi']);
      $this->db->bind(':meterfoto',$data['meterfoto']);
      $this->db->bind(':m_x',$data['latitude']);
      $this->db->bind(':m_y',$data['longitude']);
      $this->db->bind(':comment',$data['remark']);
      $this->db->bind(':status',$data['status']);
      $this->db->bind(':rf',$data['rf']);
      return $this->db->execute() ? true : false;
    }
    public function updateStatus($id){
      $this->db->query("UPDATE ".SCHEDULE_TBL." SET status = :status WHERE id = :id ");
      $this->db->bind(':status','installed');
      $this->db->bind(':id',$id);
      return $this->db->execute() ? true : false;
    }
    // write to database stop here
    // read from database goes down here
    public function viewCompleteInfo(){
        $this->db->query("SELECT * FROM ".$this->cust_tbl." LEFT JOIN ".MET_TBL." ON
        ".$this->cust_tbl.".cid = ".MET_TBL.".cid LEFT JOIN ".EDAT_TBL." ON eid=edat_id LEFT JOIN ".USER_TBL."
        ON ".USER_TBL.".id=installer ORDER BY pdate DESC LIMIT 200");
        $results = $this->db->resultSet();
        return $results;
    }
    // viw schedule
    public function viewCustomer(){
        $this->db->query("SELECT s.*,u.uid,c.names FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
        LEFT JOIN ".COMPANY_TBL." c ON cmid=cid WHERE s.status <> 'installed' ORDER BY created_on DESC");
        $results = $this->db->resultSet();
        return $results;
    }
    // find by dt code
    public function findByDtName($dt){
        $this->db->query("SELECT s.*,u.uid,c.names FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
        LEFT JOIN ".COMPANY_TBL." c ON cmid=cid WHERE dt=? AND s.status<> 'installed' ORDER BY created_on DESC");
        $this->db->bind(1,$dt);
        $results = $this->db->resultSet();
        return $results;
    }
    // find by dt code
    public function findByFeederName($feeder){
        $this->db->query("SELECT s.*,u.uid,c.names FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
        LEFT JOIN ".COMPANY_TBL." c ON cmid=cid WHERE feeder=?  AND s.status <> 'installed' ORDER BY created_on DESC");
        $this->db->bind(1,$feeder);
        $results = $this->db->resultSet();
        return $results;
    }
    public function findByDate($from,$to){
        $this->db->query("SELECT s.*,u.uid,c.names FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
                          LEFT JOIN ".COMPANY_TBL." c ON cmid=cid WHERE DATE(created_on) BETWEEN ? AND ?
                           AND s.status <> 'installed' ORDER BY created_on DESC");
        $this->db->bind(1,$from);
        $this->db->bind(2,$to);
        $results = $this->db->resultSet();
        return $results;
    }
    public function findSingleSchedule($id){
        $this->db->query("SELECT s.*,u.uid,c.names FROM ".SCHEDULE_TBL." s LEFT JOIN ".USER_TBL." u ON u.id=s.uid
                          LEFT JOIN ".COMPANY_TBL." c ON cmid=cid WHERE id=? ");
        $this->db->bind(1,$id);
        $row = $this->db->resultSet();
        return $this->db->rowCount() > 0 ? $row: false;
    }
    // display custmer that are metered
    public function installedCustomer(){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM  ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m ON
                        c.id= m.cid LEFT JOIN ".EDAT_TBL." e ON m.edat_id = e.eid LEFT JOIN ".USER_TBL." u
                        ON c.uid = u.id ORDER BY m.doi DESC LIMIT 200 ");
      $results = $this->db->resultSet();
      return $results;
    }
    public function findInstalledCustomer($key){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m ON
      c.id= m.cid LEFT JOIN EDAT_TBL e ON m.edat_id = e.eid LEFT JOIN USER_TBL u ON c.uid = u.id WHERE  ORDER BY m.doi DESC LIMIT 200 ");
      $results = $this->db->resultSet();
      return $results;
    }
    public function findInstalledCustomerByDateRange($data){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m ON c.id= m.cid LEFT JOIN
                      ".EDAT_TBL." e ON m.edat_id = e.eid LEFT JOIN USER_TBL u ON c.uid = u.id
                      WHERE DATE(doi) BETWEEN ? AND ? ");
       $this->db->bind(1,$data['from']);
       $this->db->bind(2,$data['to']);
      $results = $this->db->resultSet();
      return $results;
    }
    public function findInstalledCustomerByColumn($data){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m ON
                        c.id = m.cid LEFT JOIN ".EDAT_TBL." e ON m.edat_id = e.eid LEFT JOIN USER_TBL u ON c.uid = u.id
                        WHERE ".$data['to']." =:".$data['to']." ");
       $this->db->bind(':'.$data['to'].'',$data['num']);
      $results = $this->db->resultSet();
      return $results;
    }
    public function bycompany($id){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m ON
                      c.id = m.cid LEFT JOIN ".EDAT_TBL." e ON m.edat_id = e.eid LEFT JOIN ".USER_TBL." u ON c.uid = u.id
                        WHERE c.cid =:cmp ");
       $this->db->bind(':cmp',$id);
      $results = $this->db->resultSet();
      return $results;
    }
    public function companyrByDateRange($data){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m
                      ON c.id= m.cid LEFT JOIN ".EDAT_TBL." e ON m.edat_id = e.eid LEFT JOIN ".USER_TBL." u
                      ON c.uid = u.id WHERE c.cid= ? AND DATE(doi) BETWEEN ? AND ? ");
       $this->db->bind(1,$data['company']);
       $this->db->bind(2,$data['from']);
       $this->db->bind(3,$data['to']);
      $results = $this->db->resultSet();
      return $results;
    }
    public function viewEdat(){
        $this->db->query("SELECT * FROM ".EDAT_TBL." LEFT JOIN ".USER_TBL." ON installer=id");
        $results = $this->db->resultSet();
        return $results;
    }
    public function viewMeter(){
        $this->db->query("SELECT * FROM ".MET_TBL." ");
        $results = $this->db->resultSet();
        return $results;
    }
    public function edatId($id){
      $this->db->query("SELECT eid FROM ".EDAT_TBL." WHERE edatnumber = :edatnumber LIMIT 1");
      $this->db->bind(':edatnumber',$id);
      $row = $this->db->single();
      return ($this->db->rowCount()) ? $row->eid : $this->insertEdatNumber($id);
    }
    private function insertEdatNumber($id){
        $this->db->query('INSERT INTO '.EDAT_TBL.' SET edatnumber = :edatnumber');
        $this->db->bind(':edatnumber',$id);
        return ($this->db->execute()) ? $this->db->lastId() : false;
    }
    public function findId($id){
      $this->db->query("SELECT c.*,m.*,e.edatnumber,e.edatstatus,u.uid FROM ".SCHEDULE_TBL." c INNER JOIN ".MET_TBL." m ON
                        c.id = m.cid LEFT JOIN ".EDAT_TBL." e ON m.edat_id = e.eid LEFT JOIN ".USER_TBL." u ON c.asignedto = u.id
                        WHERE c.id = :id ");
      $this->db->bind(':id',$id);
      $row = $this->db->resultSet();
      return $row;
    }
    function findnum($num){
      $this->db->query("SELECT id,accountname FROM ".SCHEDULE_TBL." WHERE accountnumber LIKE ? ");
      $this->db->bind(1,"%$num%");
      $row = $this->db->resultSet();
      return $row;
    }

    // load JED customers
    public function jedSchedule(){
      $this->db->query("SELECT * FROM ".JED_CUST." WHERE status ='not_install' AND pid=? ORDER BY account_number LIMIT 100");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $row;
    }

    public function loadCustomerById($id){
      $this->db->query("SELECT * FROM ".JED_CUST." WHERE id=? AND pid=? ");
      $this->db->bind(1,$id);
      $this->db->bind(2,getPID());
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row : false;
    }

    // load installed customers
    public function loadCustomers(){
      $this->db->query("SELECT s.*, u.uid,f.feeder AS feeder_11,k.feeder_33kv AS feeder_3,c.names FROM ".INSTALL_MET_TBL." s
                        LEFT JOIN ".USER_TBL." u ON u.id=s.installer_id INNER JOIN ".FEEDER11KV." f
                        ON f.id=s.feeder INNER JOIN ".FEEDER33KV." k ON k.id=s.feeder_kv INNER JOIN ".COMPANY_TBL." c ON c.cmid=s.meter_brand WHERE s.date=? AND s.pid=? ORDER BY fullname ASC ");
      $this->db->bind(1,toDay());
      $this->db->bind(2,getPID());
      $row=$this->db->resultSet();
      return $data=['row'=>$row,'count'=>$this->db->rowCount()];
    }
    public function loadAllCustomers(){
      $this->db->query("SELECT s.*, u.uid,f.feeder AS feeder_11,k.feeder_33kv AS feeder_33,c.names FROM ".INSTALL_MET_TBL." s
                        LEFT JOIN ".USER_TBL." u ON u.id=s.installer_id INNER JOIN ".FEEDER11KV." f
                        ON f.id=s.feeder INNER JOIN ".FEEDER33KV." k ON k.id=s.feeder_kv INNER JOIN ".COMPANY_TBL." c ON c.cmid=s.meter_brand WHERE s.pid=? ORDER BY fullname ASC ");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $data=['row'=>$row,'count'=>$this->db->rowCount()];
    }
    public function loadCustomerByDates($from,$to){
      $this->db->query("SELECT s.*, u.uid,f.feeder AS feeder_11,k.feeder_33kv AS feeder_33,c.names FROM ".INSTALL_MET_TBL." s
                        LEFT JOIN ".USER_TBL." u ON u.id=s.installer_id INNER JOIN ".FEEDER11KV." f
                        ON f.id=s.feeder INNER JOIN ".FEEDER33KV." k ON k.id=s.feeder_kv INNER JOIN ".COMPANY_TBL." c ON c.cmid=s.meter_brand WHERE s.pid=? AND DATE(s.date) BETWEEN ? AND ? ORDER BY fullname ASC ");
      $this->db->bind(1,getPID());
      $this->db->bind(2,$from);
      $this->db->bind(3,$to);
      $row=$this->db->resultSet();
      return $data=['row'=>$row,'count'=>$this->db->rowCount()];
    }
    public function loadCustomersById($id){
      $this->db->query("SELECT s.*, u.uid,f.feeder AS feeder_11,k.feeder_33kv AS feeder_33,c.names FROM ".INSTALL_MET_TBL." s
                        INNER JOIN ".USER_TBL." u ON u.id=s.installer_id INNER JOIN ".FEEDER11KV." f
                        ON f.id=s.feeder INNER JOIN ".FEEDER33KV." k ON k.id=s.feeder_kv INNER JOIN ".COMPANY_TBL." c ON c.cmid=s.meter_brand WHERE s.id= ? AND s.pid=? ORDER BY fullname ASC ");
      $this->db->bind(1,$id);
      $this->db->bind(2,getPID());
      $row=$this->db->resultSet();
      return $data=['row'=>$row,'count'=>$this->db->rowCount()];
    }
    public function loadCustomersBySup($from,$to,$id){
      $this->db->query("SELECT s.*, u.uid,f.feeder AS feeder_11,k.feeder_33kv AS feeder_33,c.names FROM ".INSTALL_MET_TBL." s
                        LEFT JOIN ".USER_TBL." u ON u.id=s.installer_id INNER JOIN ".FEEDER11KV." f
                        ON f.id=s.feeder INNER JOIN ".FEEDER33KV." k ON k.id=s.feeder_kv INNER JOIN ".COMPANY_TBL." c ON c.cmid=s.meter_brand WHERE s.pid=? AND installer_supervisor = ? AND (DATE(s.date) BETWEEN ? AND ?) ORDER BY fullname ASC ");
      $this->db->bind(1,getPID());
      $this->db->bind(2,$id);
      $this->db->bind(3,$from);
      $this->db->bind(4,$to);
      $row=$this->db->resultSet();
      return $data=['row'=>$row,'count'=>$this->db->rowCount()];
    }
    public function findByNumber($num){
      $this->db->query("SELECT first_name AS first,last_name AS last ,custormer_title AS t,id  FROM ".INSTALL_MET_TBL." WHERE pid=? AND meter_no LIKE ? OR account_number LIKE ? OR din LIKE ? ORDER BY first_name ASC LIMIT 20 ");
      $this->db->bind(1,getPID());
      $this->db->bind(2,"%$num%");
      $this->db->bind(3,"%$num%");
      $this->db->bind(4,"%$num%");
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadInstalledCustomerById($id){
      $this->db->query("SELECT * FROM ".INSTALL_MET_TBL." WHERE id=? AND pid =? ");
      $this->db->bind(1,$id);
      $this->db->bind(2,getPID());
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row : false;
    }

    // add daily record
    public function loadDailyRecord(){
      $this->db->query("SELECT t.id,t.date,t.meters,t.installed,t.replaced,c.team,u.uid,t.writer FROM ".TEAM_REC_TBL." t INNER JOIN ".TEAM_TBL." c
                        ON c.id=t.team_id LEFT JOIN ".USER_TBL." u ON u.id=sup WHERE t.pid=? ORDER BY date DESC ");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadDailyRecordByDates($from,$to){
      $this->db->query("SELECT t.id,t.date,t.meters,t.installed,t.replaced,c.team,u.uid,t.writer FROM ".TEAM_REC_TBL." t INNER JOIN ".TEAM_TBL." c
                        ON c.id=t.team_id LEFT JOIN ".USER_TBL." u ON u.id=sup WHERE t.pid=? AND (DATE(t.date) BETWEEN ? AND ?) ORDER BY date DESC ");
      $this->db->bind(1,getPID());
      $this->db->bind(2,$from);
      $this->db->bind(3,$to);
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadDailyRecordByDateId($from,$to,$id){
      $this->db->query("SELECT t.id,t.date,t.meters,t.installed,t.replaced,c.team,u.uid,t.writer FROM ".TEAM_REC_TBL." t
                        INNER JOIN ".TEAM_TBL." c ON c.id=t.team_id LEFT JOIN ".USER_TBL." u ON u.id=sup
                        WHERE t.pid=? AND t.sup = ? AND (DATE(t.date) BETWEEN ? AND ?) ORDER BY date DESC ");
      $this->db->bind(1,getPID());
      $this->db->bind(2,$id);
      $this->db->bind(3,$from);
      $this->db->bind(4,$to);
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadDailyRecordById($id){
      $this->db->query("SELECT t.id,t.date,t.meters,t.installed,t.replaced,c.team,u.uid,t.writer FROM ".TEAM_REC_TBL." t INNER JOIN ".TEAM_TBL." c
                        ON c.id=t.team_id LEFT JOIN ".USER_TBL." u ON u.id=sup WHERE t.id=? AND t.pid=? LIMIT 1");
      $this->db->bind(1,$id);
      $this->db->bind(2,getPID());
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row : false;
    }
    // public function manageDailyRecord($data){
    //   return empty($data['id']) ? $this->addDailyRecord($data) : $this->updateDailyRecord($data);
    // }
    public function addDailyRecord($data){
      $this->db->query("INSERT INTO ".TEAM_REC_TBL." SET sup=:sup,meters=:meters,date=:date,replaced=:replaced,
                      installed=:installed,team_id=:tid,pid=:pid,writer=:writer");
      $this->db->bind(':sup',$data['sup']);
      $this->db->bind(':meters',$data['schedule']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':replaced',$data['replaced']);
      $this->db->bind(':installed',$data['installed']);
      $this->db->bind(':tid',$data['team']);
      $this->db->bind(':writer',$data['writer']);
      $this->db->bind(':pid',getPID());
      return $this->db->execute() ? true : false;
    }
    public function updateDailyRecord($data){
      $this->db->query("UPDATE ".TEAM_REC_TBL." SET meters=:meters,replaced=:replaced,installed=:installed WHERE id=:id LIMIT 1");
      $this->db->bind(':meters',$data['meter']);
      $this->db->bind(':replaced',$data['replaced']);
      $this->db->bind(':installed',$data['forms']);
      $this->db->bind(':id',$data['id']);
      return $this->db->execute() ? true : false;
    }
    public function loadDailyCoupling(){
      $this->db->query("SELECT c.*, u.uid FROM ".COU_TBL." c INNER JOIN ".USER_TBL." u ON c.coupler=u.id WHERE c.pid=? ORDER BY date DESC");
      $this->db->bind(1,getPID());
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadDailyCouplingByDates($from,$to){
      $this->db->query("SELECT c.*, u.uid FROM ".COU_TBL." c INNER JOIN ".USER_TBL." u ON c.coupler=u.id WHERE c.pid=?
                        AND DATE(date) BETWEEN ? AND ? ORDER BY date DESC");
      $this->db->bind(1,getPID());
      $this->db->bind(2,$from);
      $this->db->bind(3,$to);
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadDailyCouplingByDateId($from,$to,$id){
      $this->db->query("SELECT c.*, u.uid FROM ".COU_TBL." c INNER JOIN ".USER_TBL." u ON c.coupler=u.id WHERE c.pid=? AND coupler=?
                        AND (DATE(date) BETWEEN ? AND ?) ORDER BY date DESC");
      $this->db->bind(1,getPID());
      $this->db->bind(2,$id);
      $this->db->bind(3,$from);
      $this->db->bind(4,$to);
      $row=$this->db->resultSet();
      return $row;
    }
    public function manageCoupling($data){
      empty($data['id']) ?
                    $this->db->query("INSERT INTO ".COU_TBL." SET single_phase=:sp, three_phase=:tp,single_phase_coupled=:spc,
                                      three_phase_coupled=:tpc,remarks=:remarks,updated_on=:on, date=:date,coupler=:coupler
                                      ,operator=:operator,pid=:pid ") :
                    $this->db->query("UPDATE ".COU_TBL." SET single_phase=:sp, three_phase=:tp,single_phase_coupled=:spc,
                                    three_phase_coupled=:tpc,remarks=:remarks,updated_on=:on, date=:date,coupler=:coupler,operator=:operator
                                    WHERE id=:id LIMIT 1");
      $this->db->bind(':sp',$data['spio']);
      $this->db->bind(':tp',$data['tpio']);
      $this->db->bind(':spc',$data['spc']);
      $this->db->bind(':tpc',$data['tpc']);
      $this->db->bind(':remarks',$data['remark']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':on',dateTime());
      $this->db->bind(':coupler',$data['installerId']);
      $this->db->bind(':operator',userId());
      empty($data['id']) ? $this->db->bind(':pid',getPID()) : $this->db->bind(':id',$data['id']);
      return $this->db->execute() ? true : false;
    }
    // move meter to removed table
    public function moveMeter($data){
      $this->db->query("INSERT INTO ".DL_MT_TBL." SELECT m.* FROM ".INSTALL_MET_TBL." m WHERE id=?");
      $this->db->bind(1,$data['id']);
      return $this->db->execute() ? $this->conpleteInfo($data) : false;
    }
    private function conpleteInfo($data){
      $this->db->query("INSERT INTO ".DL_MT_INFO_TBL." SET delete_by=:id,reason=:re,delete_date=:date,mid=:mid");
      $this->db->bind(':id',userId());
      $this->db->bind(':re',$data['reason']);
      $this->db->bind(':mid',$data['id']);
      $this->db->bind(':date',dateTime());
      return $this->db->execute() ? $this->deleteCustomerById($data['id']) : false;
    }
    private function deleteCustomerById($id){
      $this->db->query("DELETE FROM ".INSTALL_MET_TBL." WHERE id = ? LIMIT 1");
      $this->db->bind(1,$id);
      return $this->db->execute() ? true : false;
    }
  }
