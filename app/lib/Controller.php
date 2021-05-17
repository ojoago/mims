<?php

// base controller
// loads model and views
class Controller{
    // load model
    public function model($model){
        //Require model file
        require_once('../app/models/'.$model .'.php');
        //instatiate model
        return new $model();
    }
    //load view
    public function view($view,$data=[]){
        // check for the view file
        if(file_exists('../app/views/'.$view.'.php')){
            require_once('../app/views/'.$view.'.php');
        }else{
            die('View does not exist');
        }
    }

    // some public methods goes down here

    // confirm rf channel
    public function is_rf($r){
      return (is_numeric($r) and ($r > 0) and ($r < 10) ) ? true : false;
    }
    // confirm edat number
    public function isEdat($e){
      return (is_numeric($e)) ? true : false;
    }
    // confirm meter Number
    public function isMeter($m){
      return (is_numeric($m)) ? true : false;
    }
    // check if it is number
    public function isNum($n){
      return (is_numeric($n) and ($n > 0)) ? true : false;
    }
    public function jsonDecode($data){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json: charset-UTF-8");
        http_response_code(200);
        echo json_encode($data);
        exit;
    }
    public function extractImg($name,$tmp,$dir='images'){
      $Ext = explode('.', $name);
      $Ext = strtolower(end ($Ext));
      $size=filesize($tmp);
      $allowed = array('jpg','jpeg','png','JPG','JPEG','PNG');
      if(in_array($Ext,$allowed)){
        //$name=rand(10,1000).$name;
        $file = $dir."/".$name;
        move_uploaded_file($tmp,$file);
        if(is_file($file)){
          $percent=0.26;
          if($size< 1024*1024)
            $percent=1;
          list($width,$height)=getimagesize($file);
          $newW=$width*$percent;
          $newH=$height*$percent;
          $thumb=imagecreatetruecolor($newW,$newH);
          if($Ext=='jpg' or $Ext=='jpeg')
          $sourceImg=imagecreatefromjpeg($file);
          elseif($Ext=='gif' or $Ext=='GIF')
          $sourceImg=imagecreatefromgif($file);
          elseif($Ext=='png' or $Ext=='PNG')
          $sourceImg=imagecreatefrompng($file);
          imagecopyresized($thumb,$sourceImg,0,0,0,0,$newW,$newH,$width,$height);
          imagejpeg($thumb,$file);
        }else{ return false;}
      }else{return false;}
      return $name;
    }
}
