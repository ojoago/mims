<?php

define('APP_NAME', 'Technovati');
define('NAIRA_UNIT', "&#8358;"); //NAIRA sign
define('APP_CARE_EMAIL', "support@technovati.com"); //NAIRA sign
define('STS_500', "Something Went Wrong ...Error logged"); // error 500
define('STS_422', "Fill the Form Correctly"); // error 500
define('ERR_EMT', "Empty Result Set"); // error 500
define('ERR_PRM', "Empty Value"); // error 500
define('AUTH_TOKEN', "TechnovatiAuthToken"); //
define('QNT_MSG', "The quantity you entered is more than what is available"); //

define('TASK_HEADING', ['PENDING', 'IN PROGRESS', 'COMPLETED', 'DAMAGED']); // TASK HEADING (DEFAULT)
define('ACCOUNT_STATUS', ['Disabled','Active']); //
define('REQUEST_STATUS', ['Pending','Processed','Confirm','Returned','Cancelled']); //
// define('LEVEL', ['Department','Designation','Employee','Grade','Structure']); //
define('USER_GROUP', [0,1,2,3,4,5]); //
define('MEMO_CATEGORY', ['','General','Selected Departments','Selected Staff']); //
define('MEMO_STATUS', ['Pending','Published']); //
define('TRAVEL_STATUS', ['Pending', 'Approved', 'Rejected', 'Successfull Trip', 'Cancelled']); //
define('ATTENDANCE', ['Absent', 'Present', 'Present, late','Excused', 'on leave', 'on assignment']); //
define('LEAVE_STATUS', [
    'Pending',
    'Apporved by your Line Manager',
    'Approved by HR ',
    'Approved by COO',
    'Approved by MD',
    'Declined by your Line Manager',
    'Declined by HR ',
    'Declined by COO',
    'Declined by MD',
    'Cancelled']); //
//'0:pending,1:line manager aproved, 2:line manager reject,3 hr approved, 4 hr reject, 5 staff cancel'
