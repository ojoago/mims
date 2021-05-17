<?php
// edats goes down
 // load customer on edat modal
 if(isset($_POST['loadMeterDetailsOnEdat'])){
    $edat=$msg=$table='';
    $database = new Database;
    $id = escapeString($_POST['id']);
    $database->query("SELECT m.*,u.uid,e.edatnumber,c.accountname,c.accountnumber,c.gsm,c.address FROM ".EDAT_TBL." e
                      INNER JOIN ".MET_TBL." m ON eid=edat_id INNER JOIN ".SCHEDULE_TBL." c ON c.id=m.cid LEFT JOIN
                      ".USER_TBL." u ON c.uid=u.id WHERE eid =:eid");
    $database->bind(':eid',$id);
    $rows=$database->resultSet();
    if($rows){
      $table.='
      <div class="card-header"><i class="fas fa-table mr-1"></i>METER INFORMATION</div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover small" width="100%">
            <thead>
            <tr class="small">
              <th width="3%">S/N</th>
              <th width="3%">Account</th>
              <th width="3%">Names</th>
              <th width="3%">Address</th>
              <th width="10%">Meter Number</th>
              <th width="4%">SEAL</th>
              <th width="3%">units</th>
              <th width="5%">TARIF</th>
              <th width="5%">X</th>
              <th width="5%">Y</th>
              <th width="20%">REMARKS</th>
              <th width="10%">STATUS</th>
              <th width="15%">INSTALLER</th>
              <th width="5%">PHOTO</th>
              <th width="10%">date</th>
            </tr>
            </thead>
            <tbody>';
            $n=0;
              foreach($rows as $row){
                $edat= 'METERS ON THIS '.$row->edatnumber.' EDAT';
              $table.= '<tr class="small customerDetails" id ="">
                    <td>'.++$n.'</td>
                    <td class="meter" >'.$row->accountnumber.'</td>
                    <td class="meter" >'.$row->accountname.'</td>
                    <td class="meter" >'.$row->address.'</td>
                    <td class="meter" >'.$row->meternum.'</td>
                    <td class="seal" >'.$row->seal.'</td>
                    <td class="preload" >'.$row->preload.'</td>
                    <td class="tarif" >'.$row->tarif.'</td>
                    <td class="m_x">'.$row->m_x.'</td>
                    <td class="m_y" >'.$row->m_y.'</td>
                    <td class="remark" >'.$row->comment.'</td>
                    <td class="status" >'.$row->status.'</td>
                    <td class="installer" >'.$row->uid.'</td>
                    <td class="photo" ><img src="'.URLROOT.'/images/'.$row->meterfoto.'" class="img img-responsive img-small" alt="image"></td>
                    <td class="date" >'.$row->doi.'</td>
              </tr>';
            }
            $table.='</tbody></table></div></div>';
    }else{$msg='THIS EDAT has no METER on it yet!';}
    $array=array('msg'=>$msg,'table'=>$table,'edat'=>$edat);
    jsonDecode($array);
  }

 // load edat stop here
 // load faulty meters log start here
 if(isset($_POST['fualtyMeterDetails'])){
   $id = escapeString($_POST['id']);
   $msg=$table='';
   $conn = new Database;
   $conn->query("SELECT r.*,u.uid FROM ".RVD_MET_TBL." r LEFT JOIN ".USER_TBL." u ON u.id=r.installer WHERE mid=:mid ORDER BY date DESC");
   $conn->bind(':mid',$id);
   $rows = $conn->resultSet();
  if($rows){
    $table.='
    <div class="card-header"><i class="fas fa-table mr-1"></i>Faulty Meter History</div>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover small" width="100%">
          <thead>
          <tr class="small">
            <th width="3%">S/N</th>
            <th width="3%">old seal</th>
            <th width="3%">New seal</th>
            <th width="3%">old meter</th>
            <th width="10%">new Meter</th>
            <th width="3%">fault</th>
            <th width="5%">solution</th>
            <th width="5%">status</th>
            <th width="10%">date</th>
            <th width="10%">Installer</th>
            <th width="5%">PHOTO</th>
          </tr>
          </thead>
          <tbody>';
          $n=0;
    foreach($rows as $row) {
      $table.= '<tr class="small" >
            <td>'.++$n.'</td>
            <td >'.$row->oldseal.'</td>
            <td >'.$row->new_seal.'</td>
            <td >'.$row->oldmeter.'</td>
            <td >'.$row->newmeter.'</td>
            <td >'.$row->fault.'</td>
            <td >'.$row->solution.'</td>
            <td >'.$row->status.'</td>
            <td >'.$row->date.'</td>
            <td >'.decodeHtmlEntity($row->uid).'</td>
            <td ><img src="'. URLROOT .'/images/'. $row->foto .'" class="img img-responsive img-small" alt="image"></td>
      </tr>';
    }
      $table.='</tbody></table></div></div>';
  }else{$msg='Something is Wrong';}
  $array=array('msg'=>$msg,'table'=>$table);
  jsonDecode($array);
 }

 // load faulty edat log start here
 if(isset($_POST['fualtyEdatDetails'])){
   $id = escapeString($_POST['id']);
   $msg=$table='';
   $conn = new Database;
   $conn->query("SELECT * FROM ". RVD_EDT_TBL ." WHERE edatid=:edatid ORDER BY date DESC");
   $conn->bind(':edatid',$id);
   $rows = $conn->resultSet();
  if($rows){
    $table.='
    <div class="card-header"><i class="fas fa-table mr-1"></i>Faulty Edat History</div>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover small" width="100%">
          <thead>
          <tr class="small">
            <th width="3%">S/N</th>
            <th width="3%">old seal</th>
            <th width="3%">New seal</th>
            <th width="3%">old edat</th>
            <th width="10%">new edat</th>
            <th width="3%">fault</th>
            <th width="5%">solution</th>
            <th width="5%">status</th>
            <th width="10%">date</th>
            <th width="5%">PHOTO</th>
          </tr>
          </thead>
          <tbody>';
          $n=0;
    foreach($rows as $row) {
      $table.= '<tr class="small" >
            <td>'.++$n.'</td>
            <td >'.$row->oldseal.'</td>
            <td >'.$row->newseal.'</td>
            <td >'.$row->oldnum.'</td>
            <td >'.$row->newnum.'</td>
            <td >'.decodeHtmlEntity($row->fault).'</td>
            <td >'.decodeHtmlEntity($row->solution).'</td>
            <td >'.$row->status.'</td>
            <td >'.$row->date.'</td>
            <td ><img src="'. URLROOT .'/images/'. $row->foto .'" class="img img-responsive img-small" alt="image"></td>
      </tr>';
    }
      $table.='</tbody></table></div></div>';
  }else{$msg='Something is Wrong';}
  $array=array('msg'=>$msg,'table'=>$table);
  jsonDecode($array);
 }

 // search edat on pair
 if(isset($_POST['searchEdatForPair'])){
   $db = new Database;
   $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
   $txt=escapeString($_POST['txt']);
   $db->query("SELECT COUNT(mid) AS count,e.edatnumber,e.eid,e.dt_name,e.channel,e_address,e_x,e_y FROM ".EDAT_TBL." e
                  LEFT JOIN ".MET_TBL." ON eid=edat_id WHERE edatstatus='installed' AND
                  (edatnumber LIKE  ? OR dt_name LIKE ? OR channel= ?) GROUP BY edatnumber ");
   $db->bind(1,"%$txt%");
   $db->bind(2,"%$txt%");
   $db->bind(3,"%$txt%");
   $rows=$db->resultSet();
   $table='';
   if($db->rowCount()>0){
     $table.='<table class="table table-bordered table-striped table-hover small" width="100%">
       <thead>
         <tr class="small">
           <th width="4%">S/N</th>
           <th width="10%">Edat</th>
           <th width="3%">RF</th>
           <th width="35%">Edat Address</th>
           <th width="45%">DT Name</th>
           <th width="3%">#</th>
         </tr>
       </thead>
       <tbody>';
     $n=0; foreach($rows as $row){
        $table.= '
        <tr class="getDatials pointer" id="'.$row->eid.'">
          <td>'. ++$n.'</td>
          <td> '. $row->edatnumber.'</td>
          <td>'. $row->channel .'</td>
          <td>'. $row->e_address.'</td>
          <td>'. $row->dt_name .'</td>
          <td>'. $row->count .'</td>
        </tr>';
     }
       $table.='</tbody>
     </table>';
   }
   jsonDecode($table);
 }
 // search Meter on pair
 if(isset($_POST['searchMeterForPair'])){
   $db = new Database;
   $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
   $txt=escapeString($_POST['txt']);
   $db->query("SELECT meternum,m_x,m_y,rf,dt,edat_id,edatnumber,mid FROM ".MET_TBL." m INNER JOIN ".SCHEDULE_TBL." s
                     ON m.cid=s.id LEFT JOIN ".EDAT_TBL." e ON eid=edat_id WHERE meternum LIKE ? OR dt LIKE ?
                      OR rf=? ORDER BY edat_id ASC ");
   $db->bind(1,"%$txt%");
   $db->bind(2,"%$txt%");
   $db->bind(3,"%$txt%");
   $rows=$db->resultSet();
   $table='';
   if($db->rowCount()>0){
     $table.='<table class="table table-bordered table-striped table-hover small" width="100%">
       <thead>
         <tr class="small">
           <th width="3%">S/N</th>
           <th width="12%">Meter</th>
           <th width="60%">DT</th>
           <th width="10%">X</th>
           <th width="10%">Y</th>
           <th width="5%"><i class="fa fa-cog"></i></th>
         </tr>
       </thead>
       <tbody>';
     $n=0; foreach($rows as $row){
       $ed= $row->edatnumber ? '<small>'.$row->edatnumber.'</small>' : '';
       $ck = $row->edatnumber ? 'checked' : '';
      $table.= '<tr >
         <td> '.++$n .'</td>
         <td>'. $row->meternum.' <small class="text-info">'. $row->rf.'</small> '.$ed.' </td>
         <td> '.$row->dt.' </td>
         <td>'.$row->m_x.'</td>
         <td>'.$row->m_y.'</td>
         <td>
           <div class="btn-group">
             <input type="checkbox" name="pair[]" value="'.$row->mid .'" '.$ck.' >
             <i class="fa fa-map-pin text-info ml-1 pointer pair" title="map to an Edat" data-toggle="tooltip" data-placement="left" id="'. $row->mid.'"></i>
           </div>
         </td>
       </tr>';
     }
       $table.='</tbody>
     </table>';
   }
   jsonDecode($table);
 }
 // load faulty meters log stop here
// load individual activity log
if(isset($_POST['myActivities'])){
  $database = new Database;
  $database->query("SELECT activity, time FROM ". LOG_TBL." WHERE uid = ? ORDER BY time DESC LIMIT 500");
  $database->bind(1,userId());
  $rows=$database->resultSet();
  if($rows){
    $data='';
    foreach ($rows as $row){
      $data.='<i class="fa fa-sun"> '.$row->activity .' | <small>'.$row->time .'</small></i><hr>';
    }
  }else{$data="No activity";}
  jsonDecode(array('activity'=>$data));
}


if(isset($_POST['findCustomerByNumber'])){
  $db=new Database;$table='';
  $db->query("SELECT * FROM ".JED_CUST." WHERE account_number LIKE ? OR fullname LIKE ? ORDER BY account_number LIMIT 20");
  $num=escapeString($_POST['num']);
  $db->bind(1,"%$num%");
  $db->bind(2,"%$num%");
  $data=$db->resultSet();
  if($db->rowCount()>0){
    $table='
    <table class="table table-bordered table-stripe table-hover" width="100%">
      <thead>
        <tr class="small">
          <th width="2%">S/N</th>
          <th width="5%">Number</th>
          <th width="15%">Names</th>
          <th width="5%">GSM</th>
          <th width="20%">Address</th>
          <th width="7%">Feeder</th>
          <th width="3%">TARIFF</th>
          <th width="5%">Area</th>
          <th width="10%">DT Name</th>
           <th width="20%">CIN</th>
          <th width="10%">DT CODE</th>

        </tr>
      </thead>
      <tbody>
    ';
    $n=0;
    foreach($data as $row){
      $href=URLROOT."/meters/load/".$row->id;
      if($row->status=='installed'){
          $href="#";
      }
      $table.='
      <tr>
        <td>'. ++$n.'</td>
        <td> <a href="'.$href.'">'. $row->account_number.'</a> <small> '. $row->status.'</small></td>
        <td>'. $row->fullname.'</td>
        <td>'. $row->gsm.'</td>
        <td>'. $row->address.'</td>
        <td>'. $row->feeder.'</td>
        <td>'. $row->tariff_code.'</td>
        <td>'. $row->area.'</td>
        <td>'. $row->dt_name.'</td>
        <td>'. $row->cin.'</td>
        <td>'. $row->transformer_number.'</td>
      </tr>
      ';
    }
    $table.='
      </tbody>
    </table>
    ';
  }
  jsonEncode($table);
}

if(isset($_POST['installedCustomerByNumberOrName'])){
  $db=new Database;$table='';
  $num=escapeString($_POST['num']);$n=0;
  $db->query("SELECT s.*, u.uid,f.feeder AS feeder_11,k.feeder_33kv AS feeder_33 FROM ".INSTALL_MET_TBL." s
              INNER JOIN ".USER_TBL." u ON u.id=s.installer_id INNER JOIN ".FEEDER11KV." f
              ON f.id=s.feeder INNER JOIN ".FEEDER33KV." k ON k.id=s.feeder_kv WHERE fullname LIKE ? OR meter_no LIKE ?
              OR account_number LIKE ? ORDER BY fullname ASC ");
  $db->bind(1,"%$num%");
  $db->bind(2,"%$num%");
  $db->bind(3,"%$num%");
  $data=$db->resultSet();
  if($db->rowCount()>0){
  $table='<table class="table table-bordered table-stripe table-hover" width="100%">
      <thead>
        <tr class="">
          <th>S/N</th>
          <th>Meter Number</th>
          <th>Seal </th>
          <th>Preload</th>
          <th>State</th>
          <th>Zone</th>
          <th>Date</th>
          <th>DT Name</th>
          <th>DT CODE</th>
          <th>DT Type</th>
          <th>Upriser</th>
          <th>pole </th>
          <th>tariff</th>
          <th>advised tariff</th>
          <th>Customer Name</th>
          <th>Phone Number</th>
          <th>email</th>
          <th>premises Type</th>
          <th>customer phase</th>
          <th>address</th>
          <th>remark</th>
          <th>33 kv feeder</th>
          <th>11 kv feeder</th>
          <th>meter type</th>
          <th>estimated CUMULATIVE</th>
          <th>account number</th>
          <th>X</th>
          <th>Y</th>
          <th>installer</th>
          <th>Supervisor</th>
          <th>din</th>
          <th>rf</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
    foreach($data as $row) {
    $table.=
      '<tr class="">
          <td>'.++$n.'</td>
          <td>'. decodeHtmlEntity($row->meter_no) .'</td>
          <td>'. decodeHtmlEntity($row->seal_number) .'</td>
          <td >'. decodeHtmlEntity($row->preload) .'</td>
          <td >'. decodeHtmlEntity($row->state) .'</td>
          <td >'. decodeHtmlEntity($row->zone) .'</td>
          <td >'. decodeHtmlEntity($row->date) .'</td>
          <td >'. decodeHtmlEntity($row->dt_name) .'</td>
          <td >'. decodeHtmlEntity($row->dt_code) .'</td>
          <td >'. decodeHtmlEntity($row->dt_type) .'</td>
          <td >'. decodeHtmlEntity($row->upriser) .'</td>
          <td >'. decodeHtmlEntity($row->pole) .'</td>
          <td >'. decodeHtmlEntity($row->presenet_tariff) .'</td>
          <td >'. decodeHtmlEntity($row->advised_tariff) .'</td>
          <td >'. decodeHtmlEntity($row->fullname)  .'</td>
          <td >'. decodeHtmlEntity($row->phone_number) .'</td>
          <td >'. decodeHtmlEntity($row->customer_email) .'</td>
          <td >'. decodeHtmlEntity($row->use_of_premises) .'</td>
          <td >'. decodeHtmlEntity($row->customer_phase) .'</td>
          <td >'. decodeHtmlEntity($row->customer_address) .'</td>
          <td >'. decodeHtmlEntity($row->customer_remark) .'</td>
          <td >'. decodeHtmlEntity($row->feeder_11) .'</td>
          <td >'. decodeHtmlEntity($row->feeder_33) .'</td>
          <td >'. decodeHtmlEntity($row->meter_type) .'</td>
          <td >'. decodeHtmlEntity($row->estimated) .'</td>
          <td >'. decodeHtmlEntity($row->account_number) .'</td>
          <td >'. decodeHtmlEntity($row->latitude) .'</td>
          <td >'. decodeHtmlEntity($row->longitude) .'</td>
          <td >'. decodeHtmlEntity($row->uid) .'</td>
          <td >'. decodeHtmlEntity(supervisorName($row->installer_supervisor)) .'</td>
          <td >'. decodeHtmlEntity($row->din) .'</td>
          <td >'. decodeHtmlEntity($row->rf) .'</td>
          <td >
            <a href="'.URLROOT.'/meters/edit/'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Edit Info"> <i class="fa fa-edit text-warning"></i> </a>
          </td>
    </tr>';
    }
    $table.='</tbody>
    </table>';
  }
  jsonEncode($table);
}

if(isset($_POST['searchSingleInstalledCustomerByVal'])){
  $db = new Database;
  $num=escapeString($_POST['num']);$n=0;
  $db->query("SELECT id,fullname,meter_no FROM ".INSTALL_MET_TBL." WHERE meter_no LIKE ? OR fullname LIKE ? OR account_number LIKE ? LIMIT 20");
  $db->bind(1,"%$num%");
  $db->bind(2,"%$num%");
  $db->bind(3,"%$num%");
  $row = $db->resultSet();
  if($db->rowCount()>0){
    $data='<ul class="list-unstyled">';
      foreach ($row as $r) {
        $data.="<a href='". URLROOT."/meters/find/".base64_encode($r->id)."'><li class = 'list-group-item pointer' >".ucwords(decodeHtmlEntity($r->fullname)). ' -> '.$r->meter_no."</li></a>";
  }
  $data.='</ul>';
  }else{
    $data="Empty Result set";
  }
  jsonEncode($data);
}

if(isset($_POST['loadProjectRadio'])){
  $db=new Database;$radio='<input type="hidden"  name="id" value="'.escapeString($_POST['id']).'">';
  $db->query("SELECT id,pname FROM ".PRJ_TBL." ORDER BY pname ASC ");
  $results=$db->resultSet();
  if($db->rowCount()>0){
    foreach($results as $row){
     $radio.=$row->pname.' <input type="radio" name="project" value="'.$row->id.'"><br>';
    }
  }
  jsonEncode($radio);
}

function loadProject(){
  $db=new Database;$radio='';
  $db->query("SELECT id,pname FROM ".PRJ_TBL." ORDER BY pname ASC ");
  $results=$db->resultSet();
  if($db->rowCount()>0){
    foreach($results as $row) {
      ?><?php echo $row->pname ?> <input type="radio" name="role[project]" value="<?php echo $row->id ?>" <?php if(@$role['project']==$row->id){ echo 'checked';} ?>><br>
    <?php }
  }
}

// store
if(isset($_POST['loadAllStoreItemsSrIN'])){
  if(isset($_SESSION['sr_in'])){
    unset($_SESSION['sr_in']);
  }
  $db= new  Database;$table='';
  $db->query("SELECT * FROM ".STORE_INVENT_ITEM." ORDER BY name ASC");
  $sql = $db->resultSet();
  if($db->rowCount()>0){
    $table=displayContent($sql);
  }
  jsonEncode($table);
}

if(isset($_POST['loadAllStoreItemOnSrCN'])){
  if(isset($_SESSION['sr_in'])){
    unset($_SESSION['sr_in']);
  }
  $db= new  Database;$n=0;$table='';
  $db->query("SELECT n.qnt,n.pid,i.id,name,dsc,batch,unit FROM ".STORE_INVENT_ITEM." i INNER JOIN ".INVENT_TBL." n ON
              i.id=n.pid WHERE sid=?  ORDER BY name ASC");
  $db->bind(1,escapeString($_POST['id']));
  $sql = $db->resultSet();
  if($db->rowCount()>0){
    $table=displayContent($sql);
  }
  jsonEncode($table);
}

function displayContent($sql){
  $table='
        <div class = "table table-responsive mt-1">
        <table class="table table-striped table-hover table-bordered small">
          <tr>
            <th >#</th>
            <th >Name</th>
            <th >Description</th>
            <th >Batch</th>
            <th >Units</th>
            <th >QNT</th>
            <th ></th>
          </tr>
        ';
  foreach($sql as $row){
    $n=0;
    $table.='
    <tr>
        <td>'.++$n.'</td>
        <td class="text-primary" id ="'. $row->id .'">'.strtolower(decodeHtmlEntity($row->name)).'</td>
        <td class="text-success">'.strtolower(decodeHtmlEntity($row->dsc)).'</td>
        <td>'.strtolower(decodeHtmlEntity($row->batch)).'</td>
        <td class="text-info">'.strtolower(decodeHtmlEntity($row->unit)).'</td>
        <td class="text-primary">'.@$row->qnt.'</td>
        <td align="center"> <i class="fa fa-plus-circle addToTransfer pointer text-danger"  id ="'. $row->id .'"></i> </td>
      </tr>';
  }
  $table.='</table></div>';
  return $table;
}
