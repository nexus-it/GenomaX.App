<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
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
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
		<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
	</div>

		</div>
		<div class="col-md-5">

	<div class="form-group">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>
		<div class="col-md-3">
	
		<?php 
	$SQL="Select now();";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
			$fECHAnOW=$row[0];
		}
	mysqli_free_result($result); 
	 ?>  
	<div class="form-group" id="grp_cmb_tipohc<?php echo $NumWindow; ?>">
		<label for="cmb_tipohc<?php echo $NumWindow; ?>">Formato HC</label>
		<select name="cmb_tipohc<?php echo $NumWindow; ?>" id="cmb_areas<?php echo $NumWindow; ?>" onchange="javascript:HCPteOnBlur<?php echo $NumWindow; ?>();">
			<option value="all">-- Todos --</option>
		<?php 
		if (isset($_GET["Historia"])) {
			$SQL="Select distinct a.Codigo_HCT, b.Nombre_HCT From hcfolios a, hctipos b, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["Historia"]."'  Order By a.Codigo_HCT asc";
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) {
					$Selected="";
					if (isset($_GET["TipoHC"])) {
						if ($_GET["TipoHC"]==$row[0]) {
							$Selected=" selected='selected' ";
							$TipoHC=$row[0];
						}
					} else {
						$Selected=" selected='selected' ";
						$TipoHC=$row[0];
					}
			 ?>
			  <option <?php echo $Selected; ?> value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
		<?php
			}
			mysqli_free_result($result);
		}
	 	?>  
	 	</select>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
		<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_controwhcf<?php echo $NumWindow; ?>">Folios</label>
		<input name="txt_controwhcf<?php echo $NumWindow; ?>" id="txt_controwhcf<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
		<div class="col-md-6">
			<div class="row">
			<div class="col-md-12">
				 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height: 73%; ">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">#</th> 
					<th id="th2<?php echo $NumWindow; ?>">Tipo</th> 
					<th id="th3<?php echo $NumWindow; ?>">Profesional</th> 
					<th id="th4<?php echo $NumWindow; ?>">Fecha</th> 
					<th id="th5<?php echo $NumWindow; ?>">Hora</th> 
					<th id="th6<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Eliminar</th> 
				</tr> 
					 <?php 
					 if (isset($_GET["Historia"])) {
					$SQL="Select a.Codigo_HCF, a.Codigo_HCT, b.Nombre_HCT, a.Fecha_HCF, a.Hora_HCF, concat(f.Nombre1_MED, ' ', f.Apellido1_MED), c.Nombre_ARE, e.ID_TER, Folio_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e, gxmedicos f, czterceros g Where g.Codigo_TER=f.Codigo_TER and f.Codigo_USR=d.Codigo_USR and a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["Historia"]."'  Order By Folio_HCF desc, a.Fecha_HCF desc, a.Hora_HCF desc";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo  '
					  <tr  >
					  	<td onclick="ReportPreview'.$NumWindow.'(\'application/reports/hc.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc["Folio_HCF"].'&FOLIO_FINAL='.$rowhc["Folio_HCF"].'\', \''.$rowhc[0].'\');" align="left"><input name="hdn_folio'.$contarow.$NumWindow.'" type="hidden" id="hdn_folio'.$contarow.$NumWindow.'" value="'.$rowhc[0].'" />'.$rowhc["Folio_HCF"].'</td>
					  	<td onclick="ReportPreview'.$NumWindow.'(\'application/reports/hc.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc["Folio_HCF"].'&FOLIO_FINAL='.$rowhc["Folio_HCF"].'\', \''.$rowhc[0].'\');" align="left"><input name="hdn_tipohc'.$contarow.$NumWindow.'" type="hidden" id="hdn_tipohc'.$contarow.$NumWindow.'" value="'.$rowhc[1].'" />'.$rowhc[2].'</td>
					  	<td onclick="ReportPreview'.$NumWindow.'(\'application/reports/hc.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc["Folio_HCF"].'&FOLIO_FINAL='.$rowhc["Folio_HCF"].'\', \''.$rowhc[0].'\');" align="left">'.$rowhc[5].'</td>
					  	<td align="right"><input name="hdn_chngdt'.$contarow.$NumWindow.'" type="hidden" id="hdn_chngdt'.$contarow.$NumWindow.'" value="0" /><input  name="txt_fechahc'.$contarow.$NumWindow.'" id="txt_fechahc'.$contarow.$NumWindow.'" type="date"  class="form-control" required value="'.$rowhc[3].'" style="height:24px" onchange="javascript:chng'.$NumWindow.'(\''.$contarow.'\');"/></td>
					  	<td align="right"><input  name="txt_timehc'.$contarow.$NumWindow.'" id="txt_timehc'.$contarow.$NumWindow.'" type="time"  class="form-control" required  value="'.$rowhc[4].'" style="height:24px"  onchange="javascript:chng'.$NumWindow.'(\''.$contarow.'\');"/></td>
					  	<td align="center"><input name="hdn_chknohc'.$contarow.$NumWindow.'" id="hdn_chknohc'.$contarow.$NumWindow.'" type="hidden"  value="0" /><div class="checkbox checkbox-success"><input name="chk_hcok'.$contarow.$NumWindow.'" id="chk_hcok'.$contarow.$NumWindow.'" type="checkbox" value=""  onclick="javascript:eliminarfoliohc'.$NumWindow.'(\''.$contarow.'\');" class="styled"><label for="chk_hcok'.$contarow.$NumWindow.'"></label></div></td>
					  </tr>
					  ';
						}
					mysqli_free_result($resulthc); 
					 }
					 ?>  

				</tbody>
				</table>
				 </div>

		  	</div>
		  	<div id="divnotahc<?php echo $NumWindow; ?>" class="col-md-12">
		  		<div class="row  well-sm alert alert-warning">
		  			<div  class="col-md-12">
			  			<span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span> Seleccione el folio que desea previsualizar. <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
					</div>
		  		</div>
	 		</div>
	 		</div>
 		</div>
		<div class="col-md-6 alert alert-warning">
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
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM from gxpacientes a, czterceros b, gxadmision c where a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_ingreso".$NumWindow."').value = '".$row[2]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				document.getElementById('txt_controwhcf".$NumWindow."').value = '".$contarow."';
				";
			}
			else {
				echo "
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." ');
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
		AbrirForm('application/forms/hcordenarfecha.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/hcordenarfecha.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hcordenarfecha.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}
}

function ReportPreview<?php echo $NumWindow; ?>(reportehc, notahc) {
	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = reportehc;
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hcordenarfecha.php', '<?php echo $NumWindow; ?>', '');	
}

function eliminarfoliohc<?php echo $NumWindow; ?>(indice) {

	if (document.getElementById('hdn_chknohc'+indice+'<?php echo $NumWindow; ?>').value=="1") {
		document.getElementById('hdn_chknohc'+indice+'<?php echo $NumWindow; ?>').value='0';
	} else {
		document.getElementById('hdn_chknohc'+indice+'<?php echo $NumWindow; ?>').value='1';
	}
}

function chng<?php echo $NumWindow; ?>(indice) {
	document.getElementById('hdn_chngdt'+indice+'<?php echo $NumWindow; ?>').value='1';
}

function guardar_hcordenarfecha<?php echo $NumWindow; ?>(Ventana) {
xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	if (document.getElementById('txt_controwhcf<?php echo $NumWindow; ?>').value=="0") {
		xError="No existen folios a actualizar";
	}
	TotalFolios=document.getElementById('txt_controwhcf<?php echo $NumWindow; ?>').value;
	var FormPostx="";
	CodTer=document.getElementById('hdn_codigoter<?php echo $NumWindow; ?>').value;
	FormPostx=FormPostx+'controwhcf='+TotalFolios+"&"+'codigoter='+CodTer+"&";
	for (i = 1; i <= TotalFolios; i++) { 
		BorrarFolio=document.getElementById('hdn_chknohc'+i+'<?php echo $NumWindow; ?>').value;
		CambioDT=document.getElementById('hdn_chngdt'+i+'<?php echo $NumWindow; ?>').value;
		ElFolio=document.getElementById('hdn_folio'+i+'<?php echo $NumWindow; ?>').value;
		ElTipoHC=document.getElementById('hdn_tipohc'+i+'<?php echo $NumWindow; ?>').value;
		LaFechaHC=document.getElementById('txt_fechahc'+i+'<?php echo $NumWindow; ?>').value;
		LaHoraHC=document.getElementById('txt_timehc'+i+'<?php echo $NumWindow; ?>').value;
		if ((BorrarFolio=="1") || (CambioDT=="1")){
			FormPostx=FormPostx+'chknohc'+i+"="+BorrarFolio+"&"+'chngdt'+i+"="+CambioDT+"&"+'folio'+i+"="+ElFolio+"&"+'tipohc'+i+"="+ElTipoHC+"&";
			FormPostx=FormPostx+'fechahc'+i+"="+LaFechaHC+"&"+'timehc'+i+"="+LaHoraHC+"&";
		}
	}
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"hcordenarfecha.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	MsgBox1("Ordenar Folios", respuesta); 
		  	AbrirForm('application/forms/hcordenarfecha.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
		  	document.getElementById(NomGuardar).style.display  = 'block';
	
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}

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
