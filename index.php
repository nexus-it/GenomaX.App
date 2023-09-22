<?php 
ini_set('allow_url_include',0);
ini_set('safe_mode',0);
ini_set('session.use_trans_sid', 0);
ini_set('session.use_only_cookies',1);
ini_set("session.cookie_lifetime","0");
session_set_cookie_params(86400); 
ini_set('session.gc_maxlifetime', 86400);
// session_save_path(APP_PARENT_DIR . '/sessions');
session_start();
if (!(isset($_GET["nxsdb"]))) {
	if (isset($_POST["nxsdb"])) {
		$_GET["prefix"]=$_POST["nxsdb"]; 
	}
	else {
		header('Location: enterprise.php');
		$_GET["prefix"]="demo"; 
	}
} else {
	$_GET["prefix"]=$_GET["nxsdb"]; 
}
error_reporting(E_ERROR | E_PARSE);
include_once 'init.php';
?>