<?php
	
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form0<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_form0<?php echo $NumWindow; ?>">
<div id="divlistasolmed<?php echo $NumWindow; ?>" class="col-md-12">
	<div class="row">

<div class="col-md-12">
	<label class="label label-primary"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar Solicitudes </label>
  <div class="row well well-sm">

		<div class="col-md-2">
		
	<div class="form-group">
	  <label for="txt_fitrofecini<?php echo $NumWindow; ?>">Fecha Inicial</label>
	  <input  name="txt_fitrofecini<?php echo $NumWindow; ?>" id="txt_fitrofecini<?php echo $NumWindow; ?>" type="date" required value="<?php FechaNow(); ?>">
	</div>

		</div>
		<div class="col-md-2">
		
	<div class="form-group">
	  <label for="txt_fitrofecfin<?php echo $NumWindow; ?>">Fecha Final</label>
	  <input  name="txt_fitrofecfin<?php echo $NumWindow; ?>" id="txt_fitrofecfin<?php echo $NumWindow; ?>" type="date" required value="<?php FechaNow(); ?>">
	</div>

		</div>
		<div class="col-md-6">
		
	<div class="form-group">
	  <label for="txt_filtropcte<?php echo $NumWindow; ?>">Paciente</label>
	  <input  name="txt_filtropcte<?php echo $NumWindow; ?>" id="txt_filtropcte<?php echo $NumWindow; ?>" type="text" required >
	</div>

		</div>
		<div class="col-md-2">
		
	<div class="form-group">
	  <label for="cmb_filtroarea<?php echo $NumWindow; ?>">Area</label>
	  
	  <div class="input-group">
	  
	  <select name="cmb_filtroarea<?php echo $NumWindow; ?>" id="cmb_filtroarea<?php echo $NumWindow; ?>">
	  	<option value="X">Todas</option>
	<?php 
	$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' order by Nombre_ARE";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
	 ?>
	  <option value="<?php echo $row[0]; ?>" ><?php echo ($row[1]); ?></option>
	<?php
		}
	mysqli_free_result($result);
	 ?>  
	  </select>

	  	<span class="input-group-btn">
	  		<button class="btn btn-primary" type="button" onclick="javascript:DespMedSol<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
	  	</span>
	  </div>

	</div>

		</div>

	</div>
	</div>
	  <div class="col-md-12">
	  	<button class="btn btn-success btn-block btn-md" onclick="javascript:NewSolFarm('0', '<?php echo $NumWindow; ?>');" data-toggle="modal" data-target="#GnmX_WinModal" style="display: none;">Crear Nueva Solicitud</button>
	  </div>
		<div class="col-md-12">

<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" style="height:70%">
<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
	<tbody id="tbDetalle<?php echo $NumWindow; ?>">
		<tr id="trh<?php echo $NumWindow; ?>"> 
			<td id="th1<?php echo $NumWindow; ?>">Solicitud</td> 
			<td id="th2<?php echo $NumWindow; ?>">Fecha</td> 
			<td id="th2<?php echo $NumWindow; ?>">Hora</td> 
			<td id="th2<?php echo $NumWindow; ?>">Paciente</td> 
			<td id="th2<?php echo $NumWindow; ?>">Cama</td> 
			<td id="th2<?php echo $NumWindow; ?>">Servicio</td> 
	        <td id="th2<?php echo $NumWindow; ?>">Usuario</td> 
	    </tr> 
	    <tr><td colspan="7" align="center"><div class="progress" style="display: none; margin-top: 0px;" name="prgSaving<?php echo $contarow.$NumWindow; ?>" id="prgSaving<?php echo $contarow.$NumWindow; ?>">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;">    <span class="sr-only">Consultando...</span>  </div></div></td></tr>
</tbody>
</table>
 </div>
 
		</div>
	</div>
</div>
</form>
<script src="functions/nexus/inventariosolfarm.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
<script >

$(":input:text:visible:first", "#frm_form0<?php echo $NumWindow; ?>").focus();
<?php
	if (isset($_GET["CodigoARE"])) {
		echo "
			document.frm_form0".$NumWindow.".cmb_filtroarea".$NumWindow.".value='".$_GET["CodigoARE"]."';
			document.frm_form0".$NumWindow.".txt_filtropcte".$NumWindow.".value='".$_GET["filtropcte"]."';
			document.frm_form0".$NumWindow.".txt_fitrofecini".$NumWindow.".value='".$_GET["FiltroFecINI"]."';
			document.frm_form0".$NumWindow.".txt_fitrofecfin".$NumWindow.".value='".$_GET["FiltroFecFIN"]."';
		";
	} else {
		echo "
			FechaActual('txt_fitrofecini".$NumWindow."');
			FechaActual('txt_fitrofecfin".$NumWindow."');
		";
	}
?>

function DespMedSol<?php echo $NumWindow; ?>() {
	DespMedSol('<?php echo $NumWindow; ?>',document.getElementById('cmb_filtroarea<?php echo $NumWindow; ?>').value, document.getElementById('txt_filtropcte<?php echo $NumWindow; ?>').value, document.getElementById('txt_fitrofecini<?php echo $NumWindow; ?>').value, document.getElementById('txt_fitrofecfin<?php echo $NumWindow; ?>').value );
}

DespMedSol<?php echo $NumWindow; ?>();

    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
