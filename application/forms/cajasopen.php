<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">
		<div class="col-md-12">
			<span class="label label-success" id="spnmartes<?php echo $NumWindow; ?>">Cajas Autorizadas Para su Usuario</span>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive" style="height: 300px" >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr> 
					<th>Codigo</th>
					<th>Descripción</th>
					<th>Apertura</th>
				</tr>
				<?php 
				$SQL="Select a.Codigo_CJA, a.Nombre_CJA from czcajas a where a.Estado_CJA='1' and a.Abierta_CJA='0' ";
				$contafila=0;
				$result = mysqli_query($conexion, $SQL);
				while ($row = mysqli_fetch_array($result)) {
				 	echo '<tr>
					<td>'.$row[0].'</td><td><strong>'.$row[1].'</strong></td><td> <button class="btn btn-success btn-block" type="button"  onclick="javascript:OpenBox'.$NumWindow.'(\''.$row[0].'\');"> <span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span> </button> </td>
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

function OpenBox<?php echo $NumWindow; ?>(Caja) {
	AbrirCaja(Caja);
	AbrirForm('application/forms/cajasopen.php', '<?php echo $NumWindow; ?>', '');
}


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>
