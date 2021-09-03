<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
  
	<label class="label label-success"> Editar Consultorio	</label>
	<div class="row well well-sm">
		<div class="col-md-1 col-sm-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
		<input name="txt_codigo<?php echo $NumWindow; ?>" id="txt_codigo<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		<div class="col-md-2 col-sm-4">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
		<input name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		<div class="col-md-3 col-sm-6">

	<div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
		<label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
		<input name="txt_descripcion<?php echo $NumWindow; ?>" id="txt_descripcion<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		<div class="col-md-3 col-sm-3">

	<div class="form-group">
		<label for="cmb_area<?php echo $NumWindow; ?>">Area de Servicio</label>
		<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' order by 2";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
	 ?>
	  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	<?php
		}
	mysqli_free_result($result); 
	 ?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-1 col-sm-3">

<div class="form-group">
	<label for="cmb_triage<?php echo $NumWindow; ?>">Triage</label>
	<select name="cmb_triage<?php echo $NumWindow; ?>" id="cmb_triage<?php echo $NumWindow; ?>">
	  <option value="0">NO</option>
	  <option value="1">SI</option>
	</select>
</div>
		</div>
		<div class="col-md-1 col-sm-3">

<div class="form-group">
	<label for="cmb_urgencia<?php echo $NumWindow; ?>">Urgencias</label>
	<select name="cmb_urgencia<?php echo $NumWindow; ?>" id="cmb_urgencia<?php echo $NumWindow; ?>">
	  <option value="0">NO</option>
	  <option value="1">SI</option>
	</select>
</div>
		</div>
		<div class="col-md-1 col-sm-3">

<div class="form-group">
	<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
	<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
	  <option value="1">ACTIVO</option>
	  <option value="0">INACTIVO</option>
	</select>
</div>
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Save<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> GUARDAR</button>
		</div>
	</div>

	<label class="label label-success">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> CONSULTORIOS
	</label>
	<div class="row well well-sm">
		<div class="col-md-12">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive "  >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr> 
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Area</th>
					<th title="Pertenece a triage?">Triage</th>
					<th title="Pertenece a usrgencias?">Urgencias</th>
					<th >Activo</th>
				</tr>
				<?php 
				$SQL="Select Codigo_CNS, Nombre_CNS, Descripcion_CNS, Nombre_ARE, Triage_CNS, Urgencias_CNS, Estado_CNS from gxconsultorios a, gxareas b where a.Codigo_ARE=b.Codigo_ARE Order By 1 ";
				$contafila=0;
				$result = mysqli_query($conexion, $SQL);
				while ($row = mysqli_fetch_array($result)) {
					if ($row[4]=="0") {
						$triage="unchecked";
					} else {
						$triage="check";
					}
				 	if ($row[5]=="0") {
						$urgencias="unchecked";
					} else {
						$urgencias="check";
					}
				 	if ($row[6]=="0") {
						$estado="unchecked";
					} else {
						$estado="check";
					}
				 	echo '<tr onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">
					<td>'.$row[0].'</td>
					<td>'.$row[1].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[3].'</td>
					<td align="center"> <span class="glyphicon glyphicon-'.$triage.'" aria-hidden="true"></span> </td>
					<td align="center"> <span class="glyphicon glyphicon-'.$urgencias.'" aria-hidden="true"></span> </td>
					<td align="center"> <span class="glyphicon glyphicon-'.$estado.'" aria-hidden="true"></span> </td>
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
	if (isset($_GET["CodigoCNS"])) {
		echo "
			document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoCNS"]."';
		";
	$SQL="Select Codigo_CNS, Nombre_CNS, Descripcion_CNS, Codigo_ARE, Triage_CNS, Urgencias_CNS, Estado_CNS from gxconsultorios a where Codigo_CNS='".$_GET["CodigoCNS"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".value='".$row[2]."';		
			document.frm_form".$NumWindow.".cmb_area".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".cmb_triage".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".cmb_urgencia".$NumWindow.".value='".$row[5]."';
			document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row[6]."';
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>
function ReLoad<?php echo $NumWindow; ?>(Consult) {
	AbrirForm('application/forms/consultorios.php', '<?php echo $NumWindow; ?>', '&CodigoCNS='+Consult);
}

function Save<?php echo $NumWindow; ?>() {
	Guardar_consultorios('<?php echo $NumWindow; ?>');
}

	$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");


</script>
<script src="functions/nexus/consultorios.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
