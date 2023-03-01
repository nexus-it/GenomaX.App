<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<fieldset>
<legend>Captura de Firma:</legend>
<div>
<canvas id="canvas" width="500" height="400">
Tu navegador no puede soportar HTML 5 Canvas.
</canvas>
</div>
<div>
<p>Color selected: <span id="color_chosen">Black</span></p>
<p>
<input type="button" id="Black" style="background-color: black; width: 25px;
height: 25px;"/>
</p>
<p><input type="button" id="reset_image" value="Borrar Trazos"/></p>
</div>
</fieldset>
<?php flush; ?>
</form>