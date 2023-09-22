<?php
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
  
	<label class="label label-success"> Editar Grupo Cama	</label>
	<div class="row well well-sm">
		<div class="col-md-1 col-sm-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
		<input name="txt_codigo<?php echo $NumWindow; ?>" id="txt_codigo<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		<div class="col-md-11 col-sm-10">

	<div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
		<label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
		<input name="txt_descripcion<?php echo $NumWindow; ?>" id="txt_descripcion<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		
		<div class="col-md-12">
			<button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Save<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> GUARDAR</button>
		</div>
	</div>

	<label class="label label-success">
		<i class="fas fa-plus"></i> GRUPOS CAMAS
	</label>
	<div class="row well well-sm">
		<div class="col-md-12">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive "  >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr> 
					<th>Codigo</th>
					<th>Descripcion</th>
				</tr>
				<?php 
				$SQL="Select Codigo_GRC, Descripcion_GRC from gxgrupocamas Order By 1 ";
				$contafila=0;
				$result = mysqli_query($conexion, $SQL);
				while ($row = mysqli_fetch_array($result)) {
				 	echo '<tr onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">
					<td>'.$row[0].'</td>
					<td>'.$row[1].'</td>
					</tr>';
					$contafila++;
				}
				mysqli_free_result($result);
				?>
				<input name="hdn_controwcitas<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwcitas<?php echo $NumWindow; ?>" value="<?php echo $contafila; ?>">
				</tbody>
				</table>
			</div>
		</div>
	</div>

</form>

<script >
<?php
	if (isset($_GET["CodigoCAM"])) {
		echo "
			document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoCAM"]."';
		";
	$SQL="Select Codigo_GRC, Descripcion_GRC from gxgrupocamas where Codigo_GRC='".$_GET["CodigoCAM"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".value='".$row[1]."';		
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>
function ReLoad<?php echo $NumWindow; ?>(Consult) {
	AbrirForm('application/forms/gruposcamas.php', '<?php echo $NumWindow; ?>', '&CodigoCAM='+Consult);
}

function Save<?php echo $NumWindow; ?>() {
	Guardar_gruposcamas('<?php echo $NumWindow; ?>');
}

	$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");


</script>
<script src="functions/nexus/gruposcamas.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
