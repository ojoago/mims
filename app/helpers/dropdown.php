<?php
    function state(){
        $db= new  Database;
        $db->query("SELECT * FROM ".STATE." ");
        $sql = $db->resultSet();
        $r='';
        foreach($sql as $row){
            $r .='<option value = "'.$row->id.'">'.$row->state_name.'</option>';
        }
        return $r;
    }
    function asign($id=0){
        $db= new  Database;
        $db->query("SELECT id,uid FROM ".USER_TBL." ORDER BY uid ASC");
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php echo $row->id==$id ? 'selected': ''; ?>><?php echo $row->uid ?></option><?php
          }
        }
    }
    function feeders(){
        $db= new  Database;
        $db->query("SELECT DISTINCT feeder FROM ".SCHEDULE_TBL." ORDER BY feeder ASC");
        $sql = $db->resultSet();
        $r='';
        foreach($sql as $row){
            $r .='<option value = "'.$row->feeder.'">'.$row->feeder.'</option>';
        }
        return $r;
    }
    function dtNames($dt=''){
        $db= new  Database;
        $db->query("SELECT DISTINCT dt FROM ".SCHEDULE_TBL." ORDER BY dt ASC");
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option <?php echo $row->dt==$dt ? 'selected': ''; ?>><?php echo $row->dt ?></option><?php
          }
        }
    }
    function feeder33kv($id=0){
        $db= new  Database;
        $db->query("SELECT id,feeder_33kv FROM ".FEEDER33KV." ORDER BY feeder_33kv ASC");
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php echo $row->id==$id ? 'selected': ''; ?>><?php echo $row->feeder_33kv ?></option><?php
          }
        }
    }
    if(isset($_POST['load11Feeder'])){
      $db= new  Database;
      $db->query("SELECT id,feeder FROM ".FEEDER11KV." WHERE feeder_33kv=? ORDER BY feeder ASC");
      $db->bind(1,escapeString($_POST['id']));
      $sql = $db->resultSet();
      $r='';
      if($db->rowCount()>0){
        $r.='<option disabled selected> SELECT Feeder</option>';
        foreach($sql as $row){
          $sel=($row->id==$_POST['val']) ? 'selected' : '';
            $r.='<option value = "'. $row->id .'" '.$sel.' >'. $row->feeder.'</option>';
        }
      }
      jsonEncode($r);
    }

    // load supervisor
    function loadSup($id=0){
        $db= new  Database;
        $db->query("SELECT u.id,u.uid FROM ".USER_TBL." u INNER JOIN ".ROLE_TBL." r ON r.id=u.level WHERE role='supervisor' AND pid=? ORDER BY uid ASC");
        $db->bind(1,getPID());
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php echo $row->id==$id ? 'selected': ''; ?>><?php echo ucfirst($row->uid) ?></option><?php
          }
        }
    }
    // load supervisor
    function loadInstaller($id=0){
        $db= new  Database;
        $db->query("SELECT u.id,u.uid FROM ".USER_TBL." u INNER JOIN ".ROLE_TBL." r ON r.id=u.level WHERE role='Installer' AND u.pid=? ORDER BY uid ASC");
        $db->bind(1,getPID());
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php echo $row->id==$id ? 'selected': ''; ?>><?php echo decodeHtmlEntity(ucfirst($row->uid)) ?></option><?php
          }
        }
    }
    function loadCoupler($id=0){
        $db= new  Database;
        $db->query("SELECT u.id,u.uid FROM ".USER_TBL." u INNER JOIN ".ROLE_TBL." r ON r.id=u.level WHERE role='coupler' AND u.pid=? ORDER BY uid ASC");
        $db->bind(1,getPID());
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php echo $row->id==$id ? 'selected': ''; ?>><?php echo decodeHtmlEntity(ucfirst($row->uid)) ?></option><?php
          }
        }
    }
    function loadWriter($id=0){
        $db= new  Database;
        $db->query("SELECT u.id,u.uid FROM ".USER_TBL." u INNER JOIN ".ROLE_TBL." r ON r.id=u.level WHERE role='writer' AND u.pid=? ORDER BY uid ASC");
        $db->bind(1,getPID());
        $sql = $db->resultSet();
        if($db->rowCount()>0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php echo $row->id==$id ? 'selected': ''; ?>><?php echo decodeHtmlEntity(ucfirst($row->uid)) ?></option><?php
          }
        }
    }
    function loadCheckbox(){
      $db= new  Database;
      $db->query("SELECT u.id,u.uid,t.team FROM ".USER_TBL." u INNER JOIN ".ROLE_TBL." r ON r.id=u.role_id LEFT JOIN ".TEAM_TBL." t ON t.id=u.team WHERE role='Installer' ORDER BY uid ASC");
      $sql = $db->resultSet();
      if($db->rowCount()>0){
        foreach($sql as $row){
            ?>
              <div class="form-check">
                <input type="checkbox" name="inst[]" value="<?php echo $row->id ?>" class="form-check-input mr-1">
                <label class="form-check-label mr-2" ><?php echo $row->uid ?></label><small class="text-info"><?php echo $row->team ?></small>
              </div>
          <?php
        }
      }
    }
    // function feeders(){
    //     $db= new  Database;
    //     $db->query("SELECT DISTINCT feeder FROM ".SCHEDULE_TBL." ORDER BY feeder ASC");
    //     $sql = $db->resultSet();
    //     $r='';
    //     foreach($sql as $row){
    //         $r .='<option value = "'.$row->feeder.'">'.$row->feeder.'</option>';
    //     }
    //     return $r;
    // }
    // function dtNames($dt=''){
    //     $db= new  Database;
    //     $db->query("SELECT DISTINCT dt FROM ".SCHEDULE_TBL." ORDER BY dt ASC");
    //     $sql = $db->resultSet();
    //     if($db->rowCount()>0){
    //       foreach($sql as $row){
    //           ><option <php echo $row->dt==$dt ? 'selected': ''; >><php echo $row->dt ></option><?php
    //       }
    //     }
    // }
    // function userRole($id=0){
    //     $db= new  Database;
    //     $db->query("SELECT id,role FROM ".ROLE_TBL." ORDER BY role ASC");
    //     $sql = $db->resultSet();
    //     if($db->rowCount() > 0){
    //       foreach($sql as $row){
    //           ><!--<option value = "<php echo $row->id >" <php if($row->id==$id){echo 'selected';} >><php echo $row->role ></option><php
    //       }
    //     }
    // }
    // f

    if(isset($_POST['loadAllStoreItems'])){
        $id=escapeString($_POST['id']);
        $db= new  Database;
        $db->query("SELECT id,dsc,name FROM ".INVENT_ITM_TBL." ORDER BY name ASC");
        $db->bind(1,$id);
        $sql = $db->resultSet();
        $r='<select type="text" style="width: 100%;" id="itemsName"  class = "form-control form-control-sm select2" >
          <option >Select Item</option>
        ';
        foreach($sql as $row){
            $r .='<option value = "'.$row->id.'">'.$row->dsc.' -> '.$row->name.'</option>';
        }
        $r.='</select>';
        jsonEncode(array('items'=>$r));
      }
      // if(isset($_POST['loaditems'])){
      //   $id=escapeString($_POST['id']);
      //   $db= new  Database;
      //   $db->query("SELECT q.id,dsc,name FROM ".INVENT_ITM_TBL." i INNER JOIN ".INVENT_TBL." q
      //               ON pid=i.id  WHERE sid =? ORDER BY name ASC");
      //   $db->bind(1,$id);
      //   $sql = $db->resultSet();
      //   $r='<select type="text" style="width: 100%;" id="displayedItems"  class = "form-control form-control-sm select2" >
      //     <option >Select Item</option>
      //   ';
      //   foreach($sql as $row){
      //       $r .='<option value = "'.$row->id.'">'.$row->dsc.' -> '.$row->name.'</option>';
      //   }
      //   $r.='</select>';
      //   jsonEncode(array('items'=>$r));
      // }

    function userRole($id=0){
        $db= new  Database;
        $db->query("SELECT id,role FROM ".ROLE_TBL." ORDER BY role ASC");
        $sql = $db->resultSet();
        if($db->rowCount() > 0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php if($row->id==$id){echo 'selected';} ?>><?php echo $row->role ?></option><?php
          }
        }
    }
    function teams($id=0){
        $db= new  Database;
        $db->query("SELECT id,team FROM ".TEAM_TBL." ORDER BY team ASC");
        $sql = $db->resultSet();
        if($db->rowCount() > 0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->id ?>" <?php if($row->id==$id){echo 'selected';} ?>><?php echo $row->team ?></option><?php
          }
        }
    }
    function store(){
        $db= new  Database;
        $db->query("SELECT id,name,location FROM ".STORE_TBL." ORDER BY name ASC");
        $sql = $db->resultSet();
        $r='';
        foreach($sql as $row){
            $r .='<option value = "'.$row->id.'">'.$row->name.' ->'.$row->location.' </option>';
        }
        return $r;
    }

      if(isset($_POST['loaditems'])){
        $id=escapeString($_POST['id']);
        $db= new  Database;
        $db->query("SELECT q.id,dsc,name FROM ".INVENT_TBL." i INNER JOIN ".INVENT_QNT." q
                    ON pid=i.id  WHERE sid =? ORDER BY name ASC");
        $db->bind(1,$id);
        $sql = $db->resultSet();
        $r='<select type="text" style="width: 100%;" id="displayedItems"  class = "form-control form-control-sm select2" >
          <option >Select Item</option>
        ';
        foreach($sql as $row){
            $r .='<option value = "'.$row->id.'">'.$row->dsc.' -> '.$row->name.'</option>';
        }
        $r.='</select>';
        jsonDecode(array('items'=>$r));
      }

    function company($id=0){
        $db= new  Database;
        $db->query("SELECT cmid,names FROM ".COMPANY_TBL." ORDER BY names ASC");
        $sql = $db->resultSet();
        if($db->rowCount() > 0){
          foreach($sql as $row){
              ?><option value = "<?php echo $row->cmid ?>" <?php if($row->cmid==$id){echo 'selected';} ?>><?php echo $row->names ?></option><?php
          }
        }
    }
    function project(){
        $db= new  Database;
        $db->query("SELECT pid,pname FROM project ORDER BY pname ASC");
        $sql = $db->resultSet();
        $r='';
        foreach($sql as $row){
            $r .='<option value = "'.$row->pid.'">'.$row->pname.'</option>';
        }
        return $r;
    }
    function loadStateRegion(){
      $db= new  Database;
      $db->query("SELECT state,region,cmid FROM ".PRJ_TBL." WHERE id=? LIMIT 1");
      $db->bind(1,getPID());
      $row=$db->single();
      return $db->rowCount() > 0 ? $row : false;
    }
    // list of item on inventory
    function itemId(){
        $db= new  Database;
        $db->query("SELECT id,batch FROM ".INVENT_TBL." ORDER BY batch ASC ");
        $sql = $db->resultSet();
        $r='';
        foreach($sql as $row){
            $r .='<option value = "'.$row->id.'">'.$row->batch.'</option>';
        }
        return $r;
    }
    // list of item on inventory stop here

    if(isset($_POST['fetchInstaller'])){
        $db= new  Database;
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $db->query("SELECT id,uid FROM ".USER_TBL." WHERE cm_id = :cm_id ORDER BY uid ASC");
        $db->bind(':cm_id',$_POST['id']);
        $sql = $db->resultSet();
        if($db->rowCount()>0){
            $r='<option disabled selected> Select Installer</option>';
            foreach($sql as $row){
                $r .='<option value = "'.$row->id.'">'.strtoupper($row->uid).'</option>';
            }
        }else{$r='Network is bad!';}
        $array = array('installer'=>$r);
		      jsonDecode($array);
    }
    // fetch region from database base on selected state
    if(isset($_POST['fetchRegion'])){
        $db= new  Database;
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $db->query("SELECT * FROM region WHERE state = :state ORDER BY region ASC");
        $db->bind(':state',$_POST['id']);
        $sql = $db->resultSet();
        if($db->rowCount()>0){
            $r='<option disabled selected> Select Region</option>';
            foreach($sql as $row){
                $r .='<option value = "'.$row->id.'">'.$row->region.'</option>';
            }
        }else{$r='Trading Zone Not Available!';}
        $array = array('region'=>$r);
		      jsonDecode($array);
    }
    // fetch region from database base on selected state
    function loadRegion($id=0){
      $r='Region Not Available!';
        $db= new  Database;
        $db->query("SELECT * FROM ".REGION_TBL." ORDER BY region ASC");
        $sql = $db->resultSet();
        if($db->rowCount()>0){
            echo '<option disabled selected> Select Region</option>';
            foreach($sql as $row){
                echo'<option>'.$row->region.'</option>';
            }
        }
		  // jsonDecode($r);
    }
    // fetch 33kv feeder from database based on region selected
    if(isset($_POST['fetchFeederT'])){
        $db= new  Database;
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $db->query("SELECT * FROM feeder33kv WHERE zid = :zid ORDER BY kv33 ASC");
        $db->bind(':zid',$_POST['id']);
        $sql = $db->resultSet();
        if($db->rowCount()>0){
            $r='<option disabled selected> Select 33kv feeder</option>';
            foreach($sql as $row){
                $r .='<option value = "'.$row->id.'">'.$row->kv33.'</option>';
            }
        }else{$r='33kv feeder Not Available!';}
        $array = array('feederT'=>$r);
		jsonDecode($array);
    }
    // fetch 11kv feeder from database based on 33kv selected
    if(isset($_POST['fetchFeederE'])){
        $db= new  Database;
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $db->query("SELECT id,feeder_name FROM feeder WHERE tid = :tid ORDER BY feeder_name ASC");
        $db->bind(':tid',escapeString($_POST['id']));
        $sql = $db->resultSet();
        if($db->rowCount()>0){
            $r='<option disabled selected> Select feeder</option>';
            foreach($sql as $row){
                $r .='<option value = "'.$row->id.'">'.$row->feeder_name.'</option>';
            }
        }else{$r='33kv feeder Not Available!';}
        $array = array('feeder'=>$r);
		      jsonDecode($array);
    }

    if(isset($_POST['loadEdat'])){
      $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
      $db= new  Database;
      $id=escapeString($_POST['id']);
      $r='Not Edat on the same RF or DT';
      $db->query("SELECT eid,edatnumber FROM ".MET_TBL." INNER JOIN ".EDAT_TBL." m ON rf=channel WHERE mid=? ");
      $db->bind(1,$id);
      $sql = $db->resultSet();
      if($db->rowCount()>0){
          $r='<option disabled selected>Same RF Channel</option>';
          foreach($sql as $row){
              $r .='<option value = "'.$row->eid.'">'.$row->edatnumber.'</option>';
          }
      }
      $db->query("SELECT eid,edatnumber FROM ".EDAT_TBL." INNER JOIN ".SCHEDULE_TBL." s ON dt=dt_name
                  INNER JOIN ".MET_TBL." m ON m.cid=s.id WHERE mid=? ");
      $db->bind(1,$id);
      $sql = $db->resultSet();
      if($db->rowCount()>0){
          $r.='<option disabled selected> Same DT Name</option>';
          foreach($sql as $row){
              $r .='<option value = "'.$row->eid.'">'.$row->edatnumber.'</option>';
          }
      }
      $r='
      <input type="hidden" name="mid" value="'.$id.'">
      <select class="select2" name="eid" id ="edatId" style="width:100%;">
        '.$r.'
      </select>
      ';
      jsonDecode($r);
    }

    function supervisorName($id){
      $conn = new Database;
      $conn->query("SELECT uid FROM ".USER_TBL." WHERE id=:id ");
      $conn->bind(':id',$id);
      $row = $conn->single();
      return $conn->rowCount() > 0  ? ucfirst($row->uid) : '';
    }
    function getUsername($id){
      $conn = new Database;
      $conn->query("SELECT uid FROM ".USER_TBL." WHERE id=:id ");
      $conn->bind(':id',$id);
      $row = $conn->single();
      return $conn->rowCount() > 0  ? ucfirst($row->uid) : '';
    }
