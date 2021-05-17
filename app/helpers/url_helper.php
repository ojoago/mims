<?php
 function redirect($page){
     header('Location: '. URLROOT .'/'.$page);
     exit;
 }

 function mimsAccessRight($id){
   $db = new Database;
   $db->query('SELECT access_right FROM '.USER_TBL.' WHERE id= ? LIMIT 1');
   $db->bind(1,$id);
   $row=$db->single();
   return ($db->rowCount()>0) ? $row->access_right : 0;
 }
 function mimsGroupRight(){}
