<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
?>
<fieldset width="100%" height="95%">
<iframe id="sqlbuddy<?php echo $NumWindow; ?>" name="sqlbuddy<?php echo $NumWindow; ?>" width="100%" height="97%" src="settings/dbmanager/"></iframe>
</fieldset>