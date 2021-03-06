<?php

//define core paths
// define them as absolute paths to make sure that require_once works as expected

defined('DS') ? null : define('DS' , DIRECTORY_SEPARATOR) ;
defined('SITE_ROOT') ? null : define('SITE_ROOT', dirname(dirname(__FILE__)));
defined('LIB_PATH') ? null : define('LIB_PATH',SITE_ROOT.DS."includes");

require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."function.php");

require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");
require_once(LIB_PATH.DS."pagination.php");

require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."photograph.php");

?>
