<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<iframe src='' frameborder='0' allowtransparency='true' style='margin:0; padding:0; width:100%; height: 100%; ' name='iframecont<?php echo $NumWindow; ?>' id="iframecont<?php echo $NumWindow; ?>" class="pdf1 panel-body">   
</iframe>
 
<script >

	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = "http://intranet.clinicasandiego.co/blog/"
	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = "http://intranet.clinicasandiego.co/blog/"
</script>
