<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">

			
	<div class="row well well-sm">
		<label class="" for="txt_origendatos<?php echo $NumWindow; ?>">Origenes de Ordenes</label>
		<div id="zero_tblorigendatos" class="detalleord"><span id="origendatos">
		    <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblexamenes" id="tblexamenes">
				<tbody id="tborigendatos">
					<tr id="trhorigendatos"></tr>
				</tbody>
			</table>
        </div>              
	</div>
</form>

<script>

$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

	$("input[type=text]").addClass("nxs_<?php echo $NumWindow; ?>");
    $("textarea").addClass("nxs_<?php echo $NumWindow; ?>");
	$("select").addClass("nxs_<?php echo $NumWindow; ?>");

</script>