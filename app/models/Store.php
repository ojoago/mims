<?php
  class Store{
    private $db;
    public function __construct(){
      $this->db= new Database;
    }
    // wirte to database start here
    // create new store
    public function createStore($data){
      $this->db->query("INSERT INTO ".STORE_TBL." SET name=:store,location=:location,manager_id=:manager ");
      $this->db->bind(':store',$data['name']);
      $this->db->bind(':location',$data['address']);
      $this->db->bind(':manager',$data['id']);
      return $this->db->execute() ? true : false;
    }
    // edit store
    public function editStore($data){
      $this->db->query("UPDATE ".STORE_TBL." SET name=:store,location=:location,manager_id=:manager WHERE id=:sid LIMIT 1");
      $this->db->bind(':store',$data['name']);
      $this->db->bind(':location',$data['address']);
      $this->db->bind(':manager',$data['id']);
      $this->db->bind(':sid',$data['sid']);
      return $this->db->execute() ? true : false;
    }
    public function createItem($data){
      $this->db->query("INSERT INTO ".STORE_INVENT_ITEM." SET name=:name,dsc=:dsc,batch=:batch,unit=:unit");
      $this->db->bind(':dsc',$data['dsc']);
      $this->db->bind(':name',$data['brand']);
      $this->db->bind(':batch',$data['batch']);
      $this->db->bind(':unit',$data['unit']);
      // $this->db->bind(':status',$data['condition']);
      return $this->db->execute() ? true : false;
    }
    public function storeManager($id){
      $this->db->query("SELECT manager FROM ".STORE_TBL." WHERE id=:sid LIMIT 1 ");
      $this->db->bind(':sid',$id);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->manager : false;
    }
    public function storeName($id){
      $this->db->query("SELECT name FROM ".STORE_TBL." WHERE id=:sid LIMIT 1 ");
      $this->db->bind(':sid',$id);
      $row = $this->db->single();
      return $this->db->rowCount()>0 ? $row->name : false;
    }

    // load on store
    public function loadAllStore(){
      $this->db->query("SELECT s.*,COUNT(sid) AS count FROM ".STORE_TBL." s LEFT JOIN ".INVENT_TBL." i ON i.sid=s.id GROUP BY s.id ORDER BY name ASC ");
      $row=$this->db->resultSet();
      return $row;
    }
    // load store by id
    public function loadStoreById($id){
      $this->db->query("SELECT * FROM ".STORE_TBL." WHERE id=? LIMIT 1");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row : false;
    }
    // load all store items
    public function loadAllStoreItems(){
      $this->db->query("SELECT t.*,i.qnt,s.name AS store FROM ".STORE_INVENT_ITEM." t LEFT JOIN ".INVENT_TBL." i ON i.pid=t.id LEFT JOIN ".STORE_TBL." s ON s.id=i.sid ");
      $row=$this->db->resultSet();
      return $row;
    }
    // load all store items
    public function loadSingleStoreItems($id){
      $this->db->query("SELECT t.*,i.qnt,s.name AS store FROM ".STORE_INVENT_ITEM." t LEFT JOIN ".INVENT_TBL." i ON i.pid=t.id
                        LEFT JOIN ".STORE_TBL." s ON s.id=i.sid WHERE s.id=? ");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }
    //
    public function loadMyStore(){
      $this->db->query("SELECT s.name AS store,t.*,i.qnt,i.id AS pid FROM ".STORE_INVENT_ITEM." t INNER JOIN ".INVENT_TBL." i ON i.pid=t.id
                        INNER JOIN ".STORE_TBL." s ON s.id=i.sid WHERE manager_id=?  ORDER BY s.name,t.name ASC");
      $this->db->bind(1,userId());
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadMyStoreById($id){
      $this->db->query("SELECT s.name AS store,t.*,i.qnt FROM ".STORE_INVENT_ITEM." t INNER JOIN ".INVENT_TBL." i ON i.pid=t.id
                        INNER JOIN ".STORE_TBL." s ON s.id=i.sid WHERE manager_id=? AND i.sid=? ORDER BY name ASC");
      $this->db->bind(1,userId());
      $this->db->bind(2,$id);
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadItemDetails($id){
      $this->db->query("SELECT name,dsc FROM ".STORE_INVENT_ITEM." WHERE id= ? ");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $row;
    }
    public function confirmQnt($id){
      $this->db->query("SELECT qnt FROM ".INVENT_TBL." WHERE pid = ? LIMIT 1");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row->qnt : 0;
    }
    public function lendableDetails($id){
      $this->db->query("SELECT t.name,s.name AS store FROM ".STORE_INVENT_ITEM." t INNER JOIN ".INVENT_TBL." i ON i.pid=t.id
                      INNER JOIN ".STORE_TBL." s ON i.sid=s.id WHERE i.id=? LIMIT 1 ");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row : false;
    }
    // processing lending items
    public function processLend($data){
      $this->db->query("INSERT INTO ".LEND_INFO." SET collector=:clt,collection_date=:cdate,lid=:lid,user=:id,r_date=:rdate,remark=:remark,time=:time");
      $this->db->bind(':clt',$data['clt']);
      $this->db->bind(':lid',$data['lid']);
      $this->db->bind(':cdate',$data['cdate']);
      $this->db->bind(':rdate',$data['rdate']);
      $this->db->bind(':remark',$data['remark']);
      $this->db->bind(':id',userId());
      $this->db->bind(':time',dateTime());
      $this->db->execute() ? true : false;
    }
    public function processingLendItem($pid,$lid,$qnt){
      $this->db->query("INSERT INTO ".LEND_DTL." SET qnt=:qnt,pid=:pid,lid=:lid ");
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':pid',$pid);
      $this->db->bind(':lid',$lid);
      $this->db->execute() ? $this->deductQnt($pid,$qnt) : false;
    }
    private function deductQnt($id,$qnt){
      $this->db->query("UPDATE ".INVENT_TBL." SET qnt=qnt-:qnt WHERE id =:id LIMIT 1");
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':id',$id);
      $this->db->execute() ? true : false;
    }


    public function itemLend(){
      $this->db->query("SELECT COUNT(d.lid) AS count,u.uid,i.* FROM ".LEND_DTL." d INNER JOIN ".LEND_INFO." i
                    ON i.lid=d.lid INNER JOIN ".USER_TBL." u ON u.id=i.collector GROUP BY d.lid ");
      $row=$this->db->resultSet();
      return $row;
    }
    public function loadLendDetail($id){
      $this->db->query("SELECT d.qnt,d.pid,t.name,s.name AS store FROM ".LEND_DTL." d INNER JOIN ".INVENT_TBL." i ON i.id=d.pid INNER JOIN ".STORE_INVENT_ITEM." t
                        ON t.id=i.pid INNER JOIN ".STORE_TBL." s ON s.id=i.sid  WHERE lid=? ");
      // $this->db->query("SELECT t.name,s.name AS store FROM ".STORE_INVENT_ITEM." t INNER JOIN ".INVENT_TBL." i ON i.pid=t.id
      //                 INNER JOIN ".STORE_TBL." s ON i.sid=s.id WHERE i.id=? LIMIT 1 ");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }
    // log waybill
    public function wayBillLog($data){
      $this->db->query("INSERT INTO ".WAYBILL." SET requestby=:rqs,aprovedby=:apv,receivedby=:rcb,units=:unit,dept=:dept,
                                        date=:date,wbi=:wbi,category=:type,remark=:remark,created_on=:crtd ");
      $this->db->bind(':rqs',$data['rqs']);
      $this->db->bind(':apv',$data['apv']);
      $this->db->bind(':rcb',$data['rcb']);
      $this->db->bind(':unit',$data['unit']);
      $this->db->bind(':dept',$data['dept']);
      $this->db->bind(':date',$data['date']);
      $this->db->bind(':remark',$data['remark']);
      $this->db->bind(':type',$data['type']);
      $this->db->bind(':wbi',$data['wbid']);
      $this->db->bind(':crtd',dateTime());
      $this->db->execute() ? true : false;
    }
    // processData waybill
    public function processData($id,$sid,$qnt,$wib,$cat,$cmt=''){
      return strtoupper($cat)==='SR-IN' ? $this->addToStore($id,$sid,$qnt,$wib,$cmt) : $this->removeFromStore($id,$sid,$qnt,$wib,$cmt);
    }
    // add item to the selected store
    public function addToStore($id,$sid,$qnt,$wib,$cmt){//id= item id, sid= store id, qnt = quantity
      $this->itemInStore($id,$sid);
      $old=$this->oldQnt($id,$sid);
      $this->db->query("UPDATE ".INVENT_TBL." SET qnt=qnt+:qnt WHERE pid=:id AND sid=:sid LIMIT 1");
              // $this->db->query("INSERT INTO ".INVENT_TBL." SET pid=:id,sid=:sid,qnt=:qnt");
      $this->db->bind(':id',$id);
      $this->db->bind(':sid',$sid);
      $this->db->bind(':qnt',$qnt);
      $this->db->execute() ? $this->logItemQnt($id,$sid,$qnt,$old,$wib,$cmt) : false;
    }
    // remove selected item from store
    public function removeFromStore($id,$sid,$qnt,$wib,$cmt){//id= item id, sid= store id, qnt = quantity
      $this->itemInStore($id,$sid);
      $old=$this->oldQnt($id,$sid);
      $this->db->query("UPDATE ".INVENT_TBL." SET qnt=qnt-:qnt WHERE pid=:id AND sid=:sid LIMIT 1");
              // $this->db->query("INSERT INTO ".INVENT_TBL." SET pid=:id,sid=:sid,qnt=:qnt");
      $this->db->bind(':id',$id);
      $this->db->bind(':sid',$sid);
      $this->db->bind(':qnt',$qnt);
      $this->db->execute() ? $this->logItemQnt($id,$sid,$qnt,$old,$wib,$cmt) : false;
    }
    // load quantity before adding
    private function logItemQnt($id,$sid,$qnt,$old,$wib,$cmt){
      $id=$this->getPID($id,$sid);
      $this->db->query("INSERT INTO ".INVENT_LOG." SET sid=:id,quantity=:qnt,old=:o,wbid=:wb,comment=:cmt ");
      $this->db->bind(':id',$id);
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':o',$old);
      $this->db->bind(':wb',$wib);
      $this->db->bind(':cmt',$cmt);
      $this->db->execute() ? true : false;
    }
    // check if item exist in store
    public function itemInStore($id,$sid){
      $this->db->query("SELECT id FROM ".INVENT_TBL." WHERE pid=? AND sid=? LIMIT 1");
      $this->db->bind(1,$id);
      $this->db->bind(2,$sid);
      $this->db->single();
      return $this->db->rowCount() > 0 ? true : $this->createNewId($id,$sid);
    }

    private function createNewId($id,$sid){
      $this->db->query("INSERT INTO ".INVENT_TBL." SET pid=:id,sid=:sid");
      $this->db->bind(':id',$id);
      $this->db->bind(':sid',$sid);
      $this->db->execute() ? true : false;
    }
    // check initial quantity
    private function oldQnt($id,$sid){
      $this->db->query("SELECT qnt FROM ".INVENT_TBL." WHERE pid=:id AND sid=:sid LIMIT 1");
      $this->db->bind(':id',$id);
      $this->db->bind(':sid',$sid);
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row->qnt : 0;
    }
    private function getPID($id,$sid){
      $this->db->query("SELECT id FROM ".INVENT_TBL." WHERE pid=:id AND sid=:sid LIMIT 1");
      $this->db->bind(':id',$id);
      $this->db->bind(':sid',$sid);
      $row=$this->db->single();
      return $this->db->rowCount() > 0 ? $row->id : false;
    }
    // load srin and srcn
    public function inventory($id){
      if($id>0){
        $this->db->query("SELECT i.*,s.store,qnt FROM ".INVENT_TBL." i INNER JOIN ".INVENT_QNT." q ON pid=i.id INNER JOIN  ".STORE_TBL." s ON s.sid=q.sid WHERE q.sid = ? ORDER BY name ASC ");
        $this->db->bind(1,$id);
      }else{
        $this->db->query("SELECT t.*,s.name AS store,w.* g.quantity,q.old qnt FROM ".INVENT_TBL." i INNER JOIN ".STORE_INVENT_ITEM." t
                          ON t.id=i.pid INNER JOIN ".INVENT_LOG." l ON i.id=l.sid INNER JOIN ".INVENT_QNT." ");
        $this->db->query("SELECT i.*,s.store,qnt FROM ".INVENT_TBL." i INNER JOIN ".INVENT_QNT." q ON pid=i.id INNER JOIN  ".STORE_TBL." s ON s.sid=q.sid  ORDER BY name ASC ");
      }
      $row=$this->db->resultSet();
      return $row;
    }

    // sr_in
    public function sr_in($id){
      $this->db->query("SELECT l.quantity,l.old,w.*,i.qnt,t.*,s.name AS store FROM ".INVENT_LOG." l INNER JOIN ".WAYBILL." w ON w.wbi=l.wbid INNER JOIN ".INVENT_TBL." i
                        ON i.id=l.sid INNER JOIN ".STORE_INVENT_ITEM." t ON t.id=i.pid INNER JOIN ".STORE_TBL." s ON s.id=i.sid  WHERE w.category='SR-IN'  ");
      $row=$this->db->resultSet();
      return $row;
    }
    public function sr_cn($id){
      $this->db->query("SELECT l.quantity,l.old,w.*,i.qnt,t.*,s.name AS store FROM ".INVENT_LOG." l INNER JOIN ".WAYBILL." w ON w.wbi=l.wbid INNER JOIN ".INVENT_TBL." i
                        ON i.id=l.sid INNER JOIN ".STORE_INVENT_ITEM." t ON t.id=i.pid INNER JOIN ".STORE_TBL." s ON s.id=i.sid  WHERE w.category='SR-CN'  ");
      $row=$this->db->resultSet();
      return $row;
    }
    public function wayBillDetails($id){
      $this->db->query("SELECT * FROM ".WAYBILL." WHERE wbi = ?  ");
       $this->db->bind(1,$id);
       $row=$this->db->single();
       return $row;
    }
    public function wayBillInfo($id){
      $this->db->query("SELECT quantity,name,dsc,unit,batch FROM ".INVENT_LOG." l INNER JOIN ".INVENT_TBL." i ON i.id=l.sid
                        INNER JOIN ".STORE_INVENT_ITEM." t ON t.id = i.pid WHERE wbid=?  ");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }

    // request goes here
    public function addRequestInfo($data){
      $this->db->query("INSERT INTO ".REQUEST_TBL." SET rid=:rid,request_by=:rqb,request_on=:date,comment=:remark,receiver=:rcv,
                        store=:store ");
      $this->db->bind(':rid',$data['requestId']);
      $this->db->bind(':rqb',userId());
      $this->db->bind(':date',dateTime());
      $this->db->bind(':remark',$data['remark']);
      $this->db->bind(':rcv',$data['receiver']);
      $this->db->bind(':store',$data['store']);
      $this->db->execute() ? true : false;
    }
    public function addRequestItems($rid,$id,$qnt){
      $this->db->query("INSERT INTO ".REQUEST_DETAILS_TBL." SET rid=:rid, pid=:id,qnt=:qnt");
      $this->db->bind(':rid',$rid);
      $this->db->bind(':id',$id);
      $this->db->bind(':qnt',$qnt);
      $this->db->execute() ? true : false;
    }
    public function myRequest(){
      $this->db->query("SELECT r.rid,u.uid,s.name AS store,request_on AS date,r.status FROM ".REQUEST_TBL." r INNER JOIN
                      ".USER_TBL." u ON u.id=r.receiver INNER JOIN ".STORE_TBL." s ON s.id=r.store WHERE request_by=?
                      ORDER BY request_on DESC ");
      $this->db->bind(1,userId());
      $row=$this->db->resultSet();
      return $row;
    }

    public function requestDetail($id){
      $this->db->query("SELECT rid,pid,qnt,name,dsc FROM ".REQUEST_DETAILS_TBL." r
                        INNER JOIN ".STORE_INVENT_ITEM." i ON i.id=r.pid WHERE r.rid= ? ");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }
    public function getItemStatus($id){
      $this->db->query("SELECT status FROM ".REQUEST_TBL." WHERE rid=? LIMIT 1");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $row->status=='pending' ? true : false;
    }
    public function updateRequestQnt($id,$rid,$qnt){
      $this->db->query("UPDATE ".REQUEST_DETAILS_TBL." SET qnt=:qnt WHERE pid=:id AND rid=:rid LIMIT 1");
      $this->db->bind(':qnt',$qnt);
      $this->db->bind(':id',$id);
      $this->db->bind(':rid',$rid);
      return $this->db->execute() ? true : false;
    }
    // remove and item from request
    public function removeItemFromRequest($id,$rid){
      $this->db->query("DELETE FROM ".REQUEST_DETAILS_TBL." WHERE pid=? AND rid=? LIMIT 1");
      $this->db->bind(1,$id);
      $this->db->bind(2,$rid);
      $this->db->execute() ? 'item removed' : 'something went wrog';
    }
    // delete request
    public function deleteRequest($id){

    }
    // request list
    public function requestList(){
      $this->db->query("SELECT r.rid,u.uid,s.name AS store,request_on AS date,r.status,r.request_by FROM ".REQUEST_TBL." r INNER JOIN
                      ".USER_TBL." u ON u.id=r.receiver INNER JOIN ".STORE_TBL." s ON s.id=r.store  WHERE s.manager_id=?
                      ORDER BY request_on DESC ");
      $this->db->bind(1,userId());
      $row=$this->db->resultSet();
      return $row;
    }



    // processing request

    public function getRequestDetail($id){
      $this->db->query("SELECT uid,store,receiver,comment FROM ".REQUEST_TBL." r INNER JOIN ".USER_TBL." u ON u.id=r.request_by WHERE r.rid = ? LIMIT 1");
      $this->db->bind(1,$id);
      $row=$this->db->single();
      return $row;
    }

    public function getRequestItems($id){
      $this->db->query("SELECT pid,qnt FROM ".REQUEST_DETAILS_TBL." WHERE rid=? ");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }
    // updated processed request status
    public function updateRequestStatus($id){
      $this->db->query("UPDATE ".REQUEST_TBL." SET status='TREATED', approved_on=:date WHERE rid=:rid ");
      $this->db->bind(':rid',$id);
      $this->db->bind(':date',dateTime());
      $this->db->execute() ? true : false;
    }
    public function fetchRequestItem($id){
      $this->db->query("SELECT qnt,n.name,uid,receiver,request_by,manager_id FROM ".REQUEST_DETAILS_TBL." t INNER JOIN
                        ".STORE_INVENT_ITEM." n ON
                        n.id=t.pid INNER JOIN ".REQUEST_TBL." r ON r.rid=t.rid INNER JOIN ".USER_TBL." u
                        ON u.id=r.request_by INNER JOIN ".STORE_TBL." s ON r.store=s.id WHERE r.rid=?");
      $this->db->bind(1,$id);
      $row=$this->db->resultSet();
      return $row;
    }
  }
