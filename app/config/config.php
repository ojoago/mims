<?php
    // log errors and display none
    ini_set('display_errors',0);
    error_reporting(0);
    ini_set('log_errors',1);
    ini_set('error_log', dirname(dirname(dirname(__FILE__))) . '/error_log.txt');
    error_reporting(E_ALL);
    date_default_timezone_set('Africa/lagos');
    define('DB_HOST','localhost');
    define('DB_USER','tripples_ojoago');
    define('DB_PASS','rHk_mS6Ek$Yy');
    define('DB_NAME','tripples_mims');
    define('APPROOT',dirname(dirname(__FILE__)));
    //define('URLROOT','http://localhost/mims');
	define('URLROOT','http://mims.trippleseventh.com');
    define('SITENAME','MIMS | Triple Seventh NIG LTD');
    define('APPVERSION','1.0');
	define('EMAIL','info@trippleseventh.com');//sending mail username
    define('PWD','Gn}=3;b[iPVD');//sending mail password
    // table names
    define('JED_CUST','jed_customers');
    // define('JED_CUST ','jed_customers');
    // define('INVENT_TBL','inventory');//inventory table
    // define('INVENT_QNT','inventory_qnt');//inventory table
    // define('INVENT_LOG','inventory_log');//inventory log
    // define('STORE_TBL','inventory_store');//store
    // define('WAYBILL','inventory_waybill');
    define('EDAT_TBL','edat_tbl');
    define('MET_TBL','metertbl');
    define('USER_TBL','user_tbl');
    define('STATE','state');
    define('LOG_TBL','log');
    define('ROLE_TBL','role');
    define('COMPANY_TBL','company');
    define('STAFF_TBL','staff');
    define('TEAM_TBL','teams');
    define('GROUP_TBL','user_group');
    define('FAULTY_TBL','fault');//faulty meter and edat table
    define('RVD_MET_TBL','resolved_meter');//resoveld faulty meter  table
    define('RVD_EDT_TBL','resolved_edat');//resoveld faulty  edat table
    define('SCHEDULE_TBL','schedule');//resoveld faulty  edat table
    // define('REGION_TBL','region');//resoveld faulty  edat table
    define('MET_NUM_TBL','meter_numbers');//resoveld faulty  edat table
    define('INSTALL_MET_TBL','installed_meters');//resoveld faulty  edat table
    define('REGION_TBL','t7_region');//resoveld faulty  edat table
    define('FEEDER33KV','t7_feeder_33kv');//resoveld faulty  edat table
    define('FEEDER11KV','t7_feeders_11kv');//resoveld faulty  edat table
	  define('TEAM_REC_TBL','team_schedule');//resoveld faulty  edat table
    define('DL_MT_TBL','deleted_meters');//resoveld faulty  edat table
    define('DL_MT_INFO_TBL','delete_meters_info');//resoveld faulty  edat table
    define('PRJ_TBL','projects');//project table
    define('COU_TBL','coupling');//project table
    // other constants
    define('METER_LENGTH',11);

    define('STORE_INVENT_ITEM','t7_store_items');//inventory table
    define('INVENT_TBL','t7_store_inventory');//inventory table
    // define('INVENT_QNT','inventory_qnt');//inventory table
    define('INVENT_LOG','t7_store_inventory_log');//inventory log
    define('STORE_TBL','t7_stores');//store
    define('WAYBILL','t7_store_inventory_waybill');
    define('LEND_DTLS','t7_store_lend_details');
    define('LEND_INFO','t7_store_lend_info');
    define('REQUEST_TBL','t7_store_request'); //staff request table
    define('REQUEST_DETAILS_TBL','t7_store_request_item_details'); //staff request details table 
