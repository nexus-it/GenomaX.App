<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">
	<div class="row">

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
		<div class="input-group">	
			<input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</span>
		</div>
		<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
	</div>

		</div>
		<div class="col-md-6">

	<div class="form-group">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
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
		<div class="col-md-2">
	
	<div class="form-group">
		<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
		<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
		<div class="col-md-4">
			<div class="row">
			<div class="col-md-12">
				 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive style="height: 80%; "">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">#</th> 
					<th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Tipo</th> 
				</tr> 
					 <?php 
					 if (isset($_GET["Historia"])) {
					$SQL="Select a.Codigo_HCF, a.Fecha_HCF, b.Nombre_HCT, c.Nombre_ARE, d.Nombre_USR, e.ID_TER, a.Hora_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["Historia"]."' and d.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' Order By a.Fecha_HCF desc, a.Hora_HCF desc";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo '
					  <tr onclick="ReportPreview'.$NumWindow.'(\'application/reports/hc.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc[0].'&FOLIO_FINAL='.$rowhc[0].'\', \''.$rowhc[0].'\');"><td align="center">'.$rowhc[0].'</td><td align="center">'.formatofecha($rowhc[1]).'</td><td>'.$rowhc[2].'</td></tr>
					  ';
						}
					mysqli_free_result($resulthc); 
					 }
					 ?>  

				</tbody>
				</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
				 </div>

		  	</div>
		  	<div id="divnotahc<?php echo $NumWindow; ?>" class="col-md-12">
		  		<label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Nota Aclaratoria</label>
		  		<div class="row well well-sm">
		  			<div  class="col-md-12">
			  			<div class="form-group">
							<label for="txt_nota<?php echo $NumWindow; ?>">Redacte su nota</label>
							<textarea name="txt_nota<?php echo $NumWindow; ?>" rows="8" id="txt_nota<?php echo $NumWindow; ?>" required="required" disabled="disabled"></textarea>
						</div>
					</div>
		  		</div>
	 		</div>
	 		</div>
 		</div>
		<div class="col-md-8 alert alert-warning">
			<input name="hdn_folio<?php echo $NumWindow; ?>" type="hidden" id="hdn_folio<?php echo $NumWindow; ?>" value="0" />
	<div class="row">
		<iframe src="" frameborder="0" allowtransparency="true" style="margin:0; padding:0; width:100%; height: 80%; " name="iframecont<?php echo $NumWindow; ?>" id="iframecont<?php echo $NumWindow; ?>" class="pdf1 panel-body">      </iframe>

	</div>

		</div>  	
</div>

</form>

<script >

<?php
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM from gxpacientes a, czterceros b, gxadmision c where a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Estado_ADM='I' and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_ingreso".$NumWindow."').value = '".$row[2]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				";
			}
			else {
				echo "
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." o no posee ingresos activos.');
				";
			}
			mysqli_free_result($result); 
		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>


function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hcnotas.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/hcnotas.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hcnotas.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}
}

function ReportPreview<?php echo $NumWindow; ?>(reportehc, notahc) {
	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = reportehc;
	document.frm_form<?php echo $NumWindow; ?>.txt_nota<?php echo $NumWindow; ?>.disabled=false;
	document.frm_form<?php echo $NumWindow; ?>.txt_nota<?php echo $NumWindow; ?>.value="Nota del Folio "+notahc+": ";
	document.frm_form<?php echo $NumWindow; ?>.hdn_folio<?php echo $NumWindow; ?>.value=notahc;
	document.frm_form<?php echo $NumWindow; ?>.txt_nota<?php echo $NumWindow; ?>.focus();
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hcnotas.php', '<?php echo $NumWindow; ?>', '');	
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
