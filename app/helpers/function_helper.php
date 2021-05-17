<?php
    function countMeters($id){
        $db = new Database;
        $db->query("SELECT COUNT(meternum) AS count FROM ".MET_TBL." WHERE edat_id = :edat_id ");
        $db->bind(':edat_id',$id);
        $row = $db->single();
        return $row;
    }
    function countStaff($id){
        $db = new Database;
        $db->query("SELECT COUNT(id) AS count FROM ".USER_TBL." WHERE cm_id = :id ");
        $db->bind(':id',$id);
        $row = $db->single();
        return $row->count;
    }

    function escapeString($str){
      $str = trim(stripslashes(htmlspecialchars($str)));
      return $str;
    }
    function isNum($n){
      return is_numeric($n) ? $n : false;
    }
    function redirectAccess($func){
      $redirect=0;
      $row=visibleRight();
      $row=str_replace('"','',$row);
      $arr=explode('=> 1,',$row);
      foreach($arr as $v){
        if(trim($v) == $func){
            $redirect=1;
           break;
        }
      }
      if($redirect==0){
        redirect('installers');
      }
    }
    function visibleRight(){
      $db = new Database;
      $db->query('SELECT access_right FROM '.USER_TBL.' WHERE id= ? LIMIT 1');
      $db->bind(1,userId());
      $row=$db->single();
      return $db->rowCount()>0 ? $row->access_right : 0;
    }
    // user Activity log
    function reportLog($activity,$aid=0){
      $conn= new Database;
      $conn->query("INSERT INTO log SET uid=:uid,aid=:aid,activity=:activity");
        $conn->bind(':uid',userId());
        $conn->bind(':aid',$aid);
        $conn->bind(':activity',$activity);
        $conn->execute();
    }
    // encode output to json then send back to ajax
    function jsonDecode($data){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json: charset-UTF-8");
        http_response_code(200);
        echo json_encode($data);
        exit;
    }
    function jsonEncode($data){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json: charset-UTF-8");
        http_response_code(200);
        echo json_encode($data);
        exit;
    }
    function lastID(){
      $db = new Database;
      return $db->lastId();
    }

    function userId(){
      return isset($_SESSION['mimsUserId']) ? base64_decode($_SESSION['mimsUserId']) : false;
    }
    function UID(){
      return isset($_SESSION['mimsUid']) ? base64_decode($_SESSION['mimsUid']) : false;
    }
    function userSession(){
      return strpos(UID(),'_') ? substr(UID(),0,strpos(UID(),'_',0)) : UID();
    }
    function getValue($db,$col,$val){
      $conn = new Database;
      $conn->query("SELECT * FROM ".$db." WHERE ".$col." = :".$col." ");
      $conn->bind(':'.$col.'',$val);
      $row = $conn->single();
      return $conn->rowCount() > 0 ? $row->$col : false;
    }
    function idToName($id){
      $conn = new Database;
      $conn->query("SELECT uid FROM ".USER_TBL." WHERE id=:id ");
      $conn->bind(':id',$id);
      $row = $conn->single();
      return $conn->rowCount() > 0 ? ucfirst($row->uid) : false;
    }
    function idToMail($id){
      $conn = new Database;
      $conn->query("SELECT mail FROM ".USER_TBL." WHERE id=:id ");
      $conn->bind(':id',$id);
      $row = $conn->single();
      return $conn->rowCount() > 0 ? $row->mail : false;
    }
    function getMail(){
        return base64_decode(@$_SESSION['mimsUserMail']);
    }
    function getPID(){
      return isset($_SESSION['mims_PID']) ? base64_decode($_SESSION['mims_PID']) : false;
    }
    function confirmStoreManager($id){
      $db = new Database;
      $db->query("SELECT manager_id AS id FROM ".STORE_TBL." WHERE id=? LIMIT 1 ");
      $db->bind(1,$id);
      $row = $db->single();
      return  @$row->id===userId() ? true : false;
    }
    if(isset($_POST['updateWaybillSentMethod'])){
      $id=escapeString($_POST['id']);
      $m=escapeString($_POST['sentBy']);
      $db=new Database;
      $db->query("UPDATE ".WAYBILL." SET sentby = ? WHERE waybill=? LIMIT 1 ");
      $db->bind(1,$m);
      $db->bind(2,$id);
      $db->execute();
      reportLog('update '.$id.' Sent Through to '.$m);
    }
    function resetArray($array){
      foreach ($array as $key => $r) {
        $array[$key]='';
      }
      return $array;
    }

    function printMsg($msg,$class='alert-success'){
      echo '<div class="alert alert-dismissible '.$class.' p-1" role ="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        '.$msg.'
      </div>';
      exit;
    }
    function removeSpace($str){
      return escapeString(str_replace(' ','',$str));
    }
    function prettyMsg($msg,$class='alert-success'){
      $msg= '<div class="alert alert-dismissible '.$class.' p-1" role ="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        '.$msg.'
      </div>';
      return $msg;
    }
    function trimSTR($str,$len=20){
      $str=decodeHtmlEntity($str);
      return strlen($str) > $len ? substr($str,0,$len).'...' : $str ;
    }
    function decodeHtmlEntity($str){
      return replaceQuote(htmlspecialchars_decode(html_entity_decode($str),ENT_QUOTES));
    }
    function replaceQuote($str){
      return trim(str_ireplace('&#39;',"'",str_ireplace('&amp;#39;',"'",htmlspecialchars_decode($str,ENT_QUOTES))));
    }
    function verifyEmail($mail){
      return filter_var($mail,FILTER_VALIDATE_EMAIL) ? true : false;
    }
    function dateTime(){
      return date('Y-m-d H:i:s');
    }
    function toDay(){
      return date('Y-m-d');
    }
    function findByCol($db,$col,$val){
        $conn = new Database;
        $conn->query("SELECT {$col} FROM {$db} WHERE {$col} = ? LIMIT 1 ");
        $conn->bind(1,$val);
        $row = $conn->single();
        return $conn->rowCount() > 0 ? true : false;
    }

    function updateByCol($db,$ccol,$cval,$vcol,$vval){//db=table,ccol=condition,cval=condition value,vcol=updating column,vval=updating value
      $conn = new Database;
      $conn->query("UPDATE {$db} SET {$vcol} = ? WHERE {$ccol}= ? LIMIT 1");
      $conn->bind(1,$vval);
      $conn->bind(2,$cval);
      return $conn->execute() ? 'Update Successful' : 'Something Went Wrong';
    }
    function deleteByCol($db,$col,$val){
      $conn = new Database;
      $conn->query("DELETE FROM {$db} WHERE {$col} = ? LIMIT 1");
      $conn->bind(1,$val);
      return $conn->execute() ? 'Delete Successful' : 'Something Went Wrong';
    }
    function findDupByCol($tbl,$cnd,$col,$val){
      $db = new Database;
      $db->query("SELECT {$cnd} FROM {$tbl} WHERE {$col} = ? LIMIT 1");
      $db->bind(1,$val);
      $row=$db->single();
      return $db->rowCount()> 0 ? $row->{$cnd}: 0;
    }
    function maxLength($n,$l=11){
      return strlen($n)==$l ? true : false;
    }

    function coordinate($x){
      $dot = strpos($x,'.');
			return strlen(substr($x,$dot+1)) == 6 ? true : false;
    }
    function coordinateDot($x){
      return strpos($x,'.') ? true : false;
    }
    function coordinateNum($x){
      $dot = strpos($x,'.');
      return strlen(substr($x,0,$dot)) < 3 ? true : false;
    }
    function prettyDate($date){
      return date('d-M, Y',strtotime($date));
    }
