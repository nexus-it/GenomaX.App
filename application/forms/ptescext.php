<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" onreset="HCResetea<?php echo $NumWindow; ?>();">
	<div class="row">

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="cmb_consultorio<?php echo $NumWindow; ?>">Consultorio</label>
		<select name="cmb_consultorio<?php echo $NumWindow; ?>" id="cmb_consultorio<?php echo $NumWindow; ?>" onchange="UpdtListPtes<?php echo $NumWindow; ?>();">
		<?php 
		$SQL="Select a.Codigo_CNS, a.Nombre_CNS from gxconsultorios a where a.Estado_CNS='1' order by 2";
		echo $SQL;
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
			{
				$selected="";
				if (isset($_GET["cons"])) {
					if ($_GET["cons"]==$row[0]) {
						$selected="selected";
					}
				}
		 ?>
		  <option value="<?php echo $row[0]; ?>" <?php echo $selected; ?>><?php echo ($row[1]); ?></option>
		<?php
			}
		mysqli_free_result($result);
		?>  
		</select>
	</div>

		</div>
		<div class="col-md-2">
	
		<?php 
	$SQL="Select now();";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
			$fECHAnOW=$row[0];
		}
	mysqli_free_result($result); 
	 ?>  
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="txt_fechahora<?php echo $NumWindow; ?>">Fecha y Hora Actual</label>
		<input name="txt_fechahora<?php echo $NumWindow; ?>" id="txt_fechahora<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="<?php echo $fECHAnOW; ?>"/>
	</div>

		</div>
		<div class="col-md-2 col-md-offset-6">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="btnagenda<?php echo $NumWindow; ?>">::::::</label><br>
		<button type="button" class="btn btn-success btn-block" id="btnagenda<?php echo $NumWindow; ?>" onclick="UpdtListPtes<?php echo $NumWindow; ?>();">Actualizar Listado <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
	</div>

		</div>
		<div class="col-md-12">
				 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height: 73%; ">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">#</th> 
					<th id="th2<?php echo $NumWindow; ?>">Fecha Ingreso</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Identificacion</th>
				    <th id="th2<?php echo $NumWindow; ?>">Paciente</th>
				    <th id="th2<?php echo $NumWindow; ?>">Diagnóstico</th>
				    <th id="th2<?php echo $NumWindow; ?>">Edad</th> 
				</tr> 
					 <?php 
					$SQL="Select a.Fecha_ADM, concat(c.Sigla_TID,' ', b.ID_TER), b.Nombre_TER, concat(d.Codigo_DGN, ' ', SUBSTRING(d.Descripcion_DGN,1,15)), TIMESTAMPDIFF(YEAR,e.FechaNac_PAC,CURDATE()), b.ID_TER From gxadmision a, czterceros b, cztipoid c, gxdiagnostico d, gxpacientes e Where a.Codigo_TER=b.Codigo_TER and c.Codigo_TID=b.Codigo_TID and d.Codigo_DGN=a.Codigo_DGN and e.Codigo_TER=b.Codigo_TER and a.Estado_ADM='I' and TIMESTAMPDIFF(HOUR,a.Fecha_ADM,CURDATE()) <=24 AND a.Codigo_ADM not in ( Select x.Codigo_ADM From hcfolios x Where TIMESTAMPDIFF(HOUR,x.Fecha_HCF,CURDATE()) <=24 ) Order by 1";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo '
							<tr id="trh<?php echo $NumWindow; ?>"> 
								<td id="td1'.$contarow.$NumWindow.'">'.$contarow.'</th> 
								<td id="td2'.$contarow.$NumWindow.'">'.$rowhc[0].'</th> 
							    <td id="td3'.$contarow.$NumWindow.'" onclick="CargarForm(\'application\/forms\/hc.php?Historia='.$rowhc[5].'\', \'Historias Clínicas\', \'1.PatientFile.png\'); UpdtListPtes'.$NumWindow.'();">'.$rowhc[1].'</th>
							    <td id="td4'.$contarow.$NumWindow.'">'.$rowhc[2].'</th>
							    <td id="td5'.$contarow.$NumWindow.'">'.$rowhc[3].'</th>
							    <td id="td6'.$contarow.$NumWindow.'">'.$rowhc[4].'</th> 
							</tr>
							';
						}
					mysqli_free_result($resulthc); 
					 ?>  

				</tbody>
				</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
				 </div>

	  	</div>
	</div>

</form>

<script >


function UpdtListPtes<?php echo $NumWindow; ?>() {
  	AbrirForm('application/forms/ptescext.php', '<?php echo $NumWindow; ?>', '&cons='+document.getElementById('cmb_consultorio<?php echo $NumWindow; ?>').value);
}


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
