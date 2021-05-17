 <?php
   // load config
   ob_start();
   require_once('config/config.php');
   require_once('helpers/url_helper.php');
   require_once('helpers/session_helper.php');
      //  include composer required libraries
   include_once('vendor/autoload.php');
   include_once('helpers/mail_tmp.php');
   include_once('helpers/mail.php');
   //load libraries
    spl_autoload_register(function($class){
       $class=ucfirst(strtolower($class));
       require_once("lib/{$class}.php");
    });
   //  require class that require database
    require_once('helpers/function_helper.php');
    require_once('helpers/dropdown.php');
    require_once('helpers/loadmodal.php');
    require_once('helpers/cronjobs.php');
