<?php
  class Inventory{
    private $db;
    public function __construct(){
      $this->db= new Database;
    }
    // wirte to database start here
    // create new store
    public function createStore($data){
      $this->db->query("INSERT INTO ".STORE_TBL." SET store=:store,location=:location,manager=:manager ");
      $this->db->bind(':store',$data['store']);
      $this->db->bind(':location',$data['address']);
      $this->db->bind(':manager',$data['manager']);
      return $this->db->execute() ? true : false;
    }
    public function create($data){
      $this->db->query("INSERT INTO ".INVENT_TBL." (dsc, name, batch, status, units)
                        VALUES (:dsc, :name, :batch, :status, :units)");
      $this->db->bind(':dsc',$data['dsc']);
      $this->db->bind(':name',$data['brand']);
      $this->db->bind(':batch',$data['batch']);
      $this->db->bind(':status',$data['condition']);
      $this->db->bind(':units',$data['unit']);
      return ($this->db->execute()) ? $this->storeQnt(0,lastID(),$data['store']) : false;
    }
    private function storeQnt($qnt,$pid,$sid){
      $this->db->query("INSERT INTO ".INVENT_QNT." SET pid=:pid,qnt=:qnt,sid=:sid ");
      $this->db->bind(':pid',$pid);
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':sid',$sid);
      return ($this->db->execute()) ? true : false;
    }

    // pass Source id to get item id
    private function getPid($id){
      $this->db->query("SELECT pid FROM ".INVENT_QNT." WHERE id=?");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $row->pid;
    }

    // check if product exist or new and return id if exist
    private function storePrd($pid,$sid){
      $this->db->query("SELECT id FROM ".INVENT_QNT." WHERE pid = ? and sid=? LIMIT 1");
      $this->db->bind(1,$pid);
      $this->db->bind(2,$sid);
      $this->db->single();
      return $this->db->rowCount() ? true : false;
    }

    public function loadItemDetails($id){
      $this->db->query("SELECT name,status,dsc,qnt FROM ".INVENT_TBL." i INNER
                        JOIN ".INVENT_QNT." q ON i.id=pid WHERE q.id= ? ");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $row;
    }
    public function waybill($data){
      // $val=$this->getOldValue($data['model']);
      $this->db->query("INSERT INTO  ". INVENT_LOG ." (sid, quantity, date, dept, requestby, aprovedby, receivedby, unit,store, remark,category,old)
      VALUES (:sid,:quantity,:date,:dept,:requestby,:aprovedby,:receivedby,:unit,:store,:remark,:category,:old)");
      $this->db->bind(':sid',$data['model']);
      $this->db->bind(':quantity',$data['qnt']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':dept',$data['dept']);
      $this->db->bind(':requestby',$data['rqs']);
      $this->db->bind(':aprovedby',$data['apv']);
      $this->db->bind(':receivedby',$data['rcv']);
      $this->db->bind(':unit',$data['unit']);
      $this->db->bind(':store',$data['store']);
      $this->db->bind(':remark',$data['rmk']);
      $this->db->bind(':category',$data['cat']);
      $this->db->bind(':old',$val);
      unset($data);
      return $this->db->execute() ? true : false;
    }

    public function inOutWayBill($data){
      $this->db->query("INSERT INTO ".WAYBILL." SET requestby=:requestby,aprovedby=:aprovedby,receivedby=:receivedby,unit=:unit,
      dept=:dept,date=:date,waybill=:waybill,category=:category,remark=:remark " );
      $this->db->bind(':requestby',$data['rqs']);
      $this->db->bind(':aprovedby',$data['apv']);
      $this->db->bind(':receivedby',$data['rcb']);
      $this->db->bind(':unit',$data['unit']);
      $this->db->bind(':dept',$data['dept']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':waybill',$data['waybill']);
      $this->db->bind(':category',$data['cat']);
      $this->db->bind(':remark',$data['remark']);
      return $this->db->execute() ? true : false;
    }
    public function logFromStore($waybill,$itemId,$qnt,$old,$cat){
      $this->db->query("INSERT INTO ".INVENT_LOG." SET sid=:sid,quantity=:quantity,old=:old, waybill_id=:waybill_id ");
      $this->db->bind(':sid',$itemId);
      $this->db->bind(':quantity',$qnt);
      $this->db->bind(':old',$old);
      $this->db->bind(':waybill_id',$waybill);
      $this->db->execute();
      $this->updateInventory($itemId,$qnt,$cat);
    }

    public function updateInventory($id,$qnt,$cat){
      return strtoupper($cat)==='SR-IN' ? $this->increaseInventory($id,$qnt) : $this->decreaseInventory($id,$qnt);
    }
    private function increaseInventory($id,$qnt){
      $this->db->query("UPDATE ".INVENT_QNT." SET qnt= qnt + :qnt WHERE id=:id  LIMIT 1");
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':id',$id);
      return $this->db->execute() ? true : false;
    }
    private function decreaseInventory($id,$qnt){
      $this->db->query("UPDATE ".INVENT_QNT." SET qnt= qnt - :qnt WHERE id=:id  LIMIT 1");
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':id',$id);
      return $this->db->execute() ? true : false;
    }

    public function transferWayBill($data){
      $this->db->query("INSERT INTO ".WAYBILL." SET requestby=:requestby,aprovedby=:aprovedby,
                        receivedby=:receivedby,unit=:unit,dept=:dept,date=:date,waybill=:waybill,
                        category=:category,remark=:remark");
      $this->db->bind(':requestby',$data['rqs']);
      $this->db->bind(':aprovedby',$data['apv']);
      $this->db->bind(':receivedby',$data['rcb']);
      $this->db->bind(':unit',$data['unit']);
      $this->db->bind(':dept',$data['dept']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':waybill',$data['waybill']);
      $this->db->bind(':category','SR-CN');
      $this->db->bind(':remark',$data['remark']);
      // $this->db->execute();
      // $this->db->bind(':category','SR-IN');
      return $this->db->execute() ? true : false;
    }
    // update inventory log for transfer
    public function updateLog($waybill,$from,$to,$qnt,$old,$itemId){
      $this->updateFromStore($waybill,$itemId,$qnt,$old);
      $this->updateToStore($waybill,$itemId,$qnt,$to);
    }
    private function updateFromStore($waybill,$itemId,$qnt,$old){
      $this->db->query("INSERT INTO ".INVENT_LOG." SET sid=:sid,quantity=:quantity,old=:old, waybill_id=:waybill_id ");
      $this->db->bind(':sid',$itemId);
      $this->db->bind(':quantity',$qnt);
      $this->db->bind(':old',$old);
      $this->db->bind(':waybill_id',$waybill);
      $this->db->execute() ? $this->decreaseInventory($itemId,$qnt) : false;
    }

    private function updateToStore($waybill,$itemId,$qnt,$to){
      $id=$this->getPid($itemId);
      $old=$this->getOldValue($id,$to);
      $this->destinationInstance($id,$to,$qnt);
      $id= $this->getDestinationId($id,$to);
      $this->db->query("INSERT INTO ".INVENT_LOG." SET sid=:sid,quantity=:quantity,old=:old, waybill_id=:waybill_id ");
      $this->db->bind(':sid',$id);
      $this->db->bind(':quantity',$qnt);
      $this->db->bind(':old',$old);
      $this->db->bind(':waybill_id',$waybill);
      $this->db->execute() ? true : false;
    }
    private function getOldValue($id,$to){
      $this->db->query("SELECT qnt FROM ".INVENT_QNT." WHERE pid=:pid AND sid=:sid LIMIT 1");
      $this->db->bind(':pid',$id);
      $this->db->bind(':sid',$to);
      $row=$this->db->single();
      return ($this->db->rowCount() > 0) ? $row->qnt : 0;
    }
    private function getDestinationId($id,$to){
      $this->db->query("SELECT id FROM ".INVENT_QNT." WHERE pid=:pid AND sid=:sid LIMIT 1");
      $this->db->bind(':pid',$id);
      $this->db->bind(':sid',$to);
      $row=$this->db->single();
      return ($this->db->rowCount() > 0) ? $row->id : 0;
    }
    // update destination
    private function destinationInstance($id,$sid,$qnt){
      !$this->storePrd($id,$sid) ? $this->db->query("INSERT INTO ".INVENT_QNT." SET pid=:pid,sid=:sid,qnt=:qnt")  :
                                $this->db->query("UPDATE ".INVENT_QNT." SET qnt=qnt+:qnt WHERE pid=:pid AND sid=:sid");
      $this->db->bind(':pid',$id);
      $this->db->bind(':sid',$sid);
      $this->db->bind(':qnt',$qnt);
      return $this->db->execute() ? true : false;
    }
    // write to database stop here

    // read from database start here
    // read from database start here
    public function findItem($name,$batch){
      $this->db->query("SELECT id FROM ".INVENT_TBL. " WHERE name= ? AND batch = ? ");
      $this->db->bind(1,$name);//item name
      $this->db->bind(2,$batch);//item model or id or batch number
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? true : false;
    }
    // fetch inventory
    public function inventory($id){
      if($id>0){
        $this->db->query("SELECT i.*,s.store,qnt FROM ".INVENT_TBL." i INNER JOIN ".INVENT_QNT." q ON pid=i.id INNER JOIN  ".STORE_TBL." s ON s.sid=q.sid WHERE q.sid = ? ORDER BY name ASC ");
        $this->db->bind(1,$id);
      }else{
        $this->db->query("SELECT i.*,s.store,qnt FROM ".INVENT_TBL." i INNER JOIN ".INVENT_QNT." q ON pid=i.id INNER JOIN  ".STORE_TBL." s ON s.sid=q.sid  ORDER BY name ASC ");
      }
      $row=$this->db->resultSet();
      return $row;
    }
    // fetch sr-in
    public function sr_in($id=0){
      $this->db->query("SELECT l.quantity,l.old,w.*,q.qnt,s.store,i.* FROM ".WAYBILL." w INNER JOIN ".INVENT_LOG." l ON waybill=waybill_id
                       INNER JOIN ".INVENT_QNT." q ON q.id=l.sid INNER JOIN ".INVENT_TBL." i ON
                       i.id=q.pid INNER JOIN ".STORE_TBL." s ON s.sid=q.sid WHERE category='SR-IN' ORDER BY created_on DESC");
      $row=$this->db->resultSet();
      return $row;
    }
    // public function sr_in($id=0){
    //   $this->db->query("SELECT l.quantity,l.old,w.*,i.qnt,s.store,t.* FROM ".INVENT_LOG." l INNER JOIN ".WAYBILL." w
    //                     ON w.waybill=l.waybill_id INNER JOIN ".INVENT_QNT." i ON l.sid = i.id
    //                     INNER JOIN ".INVENT_TBL." t ON t.id=i.sid
    //                     INNER JOIN ".STORE_TBL." s ON s.sid=i.sid WHERE w.category='SR-IN' ORDER BY date DESC");
    //   $row=$this->db->resultSet();
    //   return $row;
    // }
    public function sr_cn($id=0){
      $this->db->query("SELECT l.quantity,l.old,w.*,q.qnt,s.store,i.* FROM ".WAYBILL." w INNER JOIN ".INVENT_LOG." l ON waybill=waybill_id
                       INNER JOIN ".INVENT_QNT." q ON q.id=l.sid INNER JOIN ".INVENT_TBL." i ON
                       i.id=q.pid INNER JOIN ".STORE_TBL." s ON s.sid=q.sid WHERE category='SR-CN' ORDER BY created_on DESC");
      $row=$this->db->resultSet();
      return $row;
    }
    // public function sr_cn($id=0){
    //   $this->db->query("SELECT * FROM ".INVENT_LOG." l INNER JOIN ".WAYBILL." w
    //                     ON w.waybill=l.waybill_id INNER JOIN ".INVENT_QNT." i ON l.sid = i.sid
    //                     INNER JOIN ".INVENT_TBL." t ON t.id=i.pid
    //                     INNER JOIN ".STORE_TBL." s ON s.sid=i.sid WHERE w.category='SR-CN' ORDER BY date DESC");
    //   $row=$this->db->resultSet();
    //   return $row;
    // }
    // get inventory name by id

    public function storeManager($id){
      $this->db->query("SELECT manager FROM ".STORE_TBL." WHERE sid=:sid LIMIT 1 ");
      $this->db->bind(':sid',$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->manager : false;
    }
    public function storeName($id){
      $this->db->query("SELECT store FROM ".STORE_TBL." WHERE sid=:sid LIMIT 1 ");
      $this->db->bind(':sid',$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->store : false;
    }
    public function wayBillInfo($id){
    //  $sid=$this->removeStoreItems($id);
      $this->db->query("SELECT l.quantity,s.store,i.* FROM ".INVENT_LOG." l INNER JOIN ".INVENT_QNT." q ON q.id=l.sid
                        INNER JOIN ".STORE_TBL." s ON s.sid=q.sid INNER JOIN ".INVENT_TBL." i
                        ON i.id=q.pid WHERE l.waybill_id=? ");
      $this->db->bind(1,$id);
      // $this->db->bind(2,$sid);
      $row=$this->db->resultSet();
      return $row;
    }
    private function removeStoreItems($id){
      $this->db->query("SELECT sid FROM ".INVENT_LOG." WHERE waybill_id=? LIMIT 1 ");
      $this->db->bind(1,$id);
      $row = $this->db->single();
      return ($this->db->rowCount()>0) ? $row->sid : 0;
    }
    public function wayBillDetails($id){
      $this->db->query("SELECT * FROM ".WAYBILL." WHERE waybill = ?  ");
       $this->db->bind(1,$id);
       $row=$this->db->single();
       return $row;
    }
    // public function wayBillDetails($id){
    //   $this->db->query("SELECT w.*,s.store,e.id FROM ".WAYBILL." w INNER JOIN ".INVENT_LOG." l ON w.waybill=l.waybill_id
    //                     INNER JOIN ".INVENT_QNT." i ON l.sid=i.sid INNER JOIN ".INVENT_TBL." e ON e.id=i.pid
    //                     INNER JOIN ".STORE_TBL." s ON s.sid=i.sid
    //                       WHERE w.waybill = ?  ");
    //    $this->db->bind(1,$id);
    //    $row=$this->db->single();
    //    return $row;
    // }
    public function wayBillStore($id){
      $this->db->query("SELECT w.*,s.store FROM ".WAYBILL." w INNER JOIN ".INVENT_LOG." l ON w.waybill=l.waybill_id
       INNER JOIN ".INVENT_TBL." i ON l.sid=i.id INNER JOIN ".STORE_TBL." s ON s.sid=i.store_id  WHERE w.waybill = ?  ");
       $this->db->bind(1,$id);
       $row=$this->db->resultSet();
       return $row;
    }

    // new store
    // load on store
    public function loadAllStore(){
      $this->db->query("SELECT s.*,COUNT(i.id) AS count FROM ".STORE_TBL." s LEFT JOIN ".INVENT_TBL." i ON i.sid=s.id GROUP BY s.id ORDER BY name ASC ");
      $row=$this->db->resultSet();
      return $row;
    }
    // load store by id
    public function loadStoreById($id){
      $this->db->query("SELECT * FROM ".STORE_TBL." WHERE id=? LIMIT 1 ");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row : false;
    }
    // load all store items
    public function loadAllStoreItems(){
      $this->db->query("SELECT t.*,i.qnt,s.name AS store FROM ".INVENT_ITM_TBL." t LEFT JOIN ".INVENT_TBL." i ON i.pid=t.id LEFT JOIN ".STORE_TBL." s ON s.id=i.sid ");
      $row=$this->db->resultSet();
      return $row;
    }
  }
