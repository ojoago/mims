<?php
if(isset($_POST['computeDays'])){
  if(date('h')==10){
    //computeDays();
  }
}
function computeDays(){
  $r='';
    $conn = new Database;
    $conn->query("SELECT p.payment_date ,c.id FROM ".CUSTOMER_TBL ." c INNER JOIN ". PAYMENT_TBL ." p ON c.id =p.cid WHERE c.status ='not metered'");
    $rows=$conn->resultSet();
    if($rows){
        foreach ($rows as $row){
        $wrkn=array('Mon','Tue','Wed','Fri','Thu');
        $day=date('D', strtotime($row->payment_date));
        if(in_array($day,$wrkn)){
          $conn->query("UPDATE ". CUSTOMER_TBL. " SET dayscount= dayscount+1 WHERE id = ".$row->id." LIMIT 1 ");
          $conn->execute();
        }
      }
    }
 }
 if(isset($_POST['myActivities'])){
   $database = new Database;
   $database->query("SELECT activity, time FROM ". LOGTBL." WHERE uid = ? ORDER BY time DESC LIMIT 100");
   $database->bind(1,base64_decode($_SESSION['comsPrimeUserId']));
   $rows=$database->resultSet();
   if($rows){
     $data='';
     foreach ($rows as $row){
       $data.='<i class="fa fa-sun"> '.$row->activity .' | <small>'.$row->time .'</small></i><hr>';
     }
   }else{$data="No activity";}
   jsonDecode(array('activity'=>$data));
 }
