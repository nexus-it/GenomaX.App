<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
  
<div class="form-group">
    <label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
    <input name="txt_fecha<?php echo $NumWindow; ?>" type="text" id="txt_fecha<?php echo $NumWindow; ?>" disabled/>
</div>   

<div class="form-group">
    <label for="txt_valor<?php echo $NumWindow; ?>">Valor</label>
    <input name="txt_valor<?php echo $NumWindow; ?>" type="text" id="txt_valor<?php echo $NumWindow; ?>" />
</div> 


</form>

<script >
<?php
	$SQL="select date(now()), Valor_TRM, Fecha_TRM from cztrm order by 3 desc limit 1;";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$row[0]."';
			document.frm_form".$NumWindow.".txt_valor".$NumWindow.".value='".$row[1]."';
		";
	}
	mysqli_free_result($result); 
?>

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");

</script>
