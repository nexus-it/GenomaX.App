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
						<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
					</span>
				</div>
				<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="0" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
				<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
			</div>
		</div>
		<div class="col-md-2">
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
		<div class="col-md-2">
			<div class="form-group">
				<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
				<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
			</div>
		</div>
		<div class="col-md-9 alert alert-info">
			<div class="row">
				<div class="col-md-12 label label-danger hidden" id="div_alertas">
					...
				</div>
				<div class="col-md-5">
					<label>Contrato: </label> <span id="spn_contrato<?php echo $NumWindow; ?>">Sin datos</span>
					<input name="hdn_contrato<?php echo $NumWindow; ?>" type="hidden" id="hdn_contrato<?php echo $NumWindow; ?>" value="" />
				</div>
				<div class="col-md-5">
					<label>Plan: </label> <span id="spn_plan<?php echo $NumWindow; ?>">Sin datos</span>
					<input name="hdn_plan<?php echo $NumWindow; ?>" type="hidden" id="hdn_plan<?php echo $NumWindow; ?>" value="" />
				</div>
				<div class="col-md-2">
					<label>Rango: </label> <span id="spn_rango<?php echo $NumWindow; ?>">Sin datos</span>
					<input name="hdn_tarifa<?php echo $NumWindow; ?>" type="hidden" id="hdn_tarifa<?php echo $NumWindow; ?>" value="" />
				</div>
				<div class="col-md-3">
					<label>Fec Nacimiento: </label> <small><span id="spn_fechanac<?php echo $NumWindow; ?>">00/00/0000</span></small>
				</div>
				<div class="col-md-4">
					<label>Edad: </label> <small><span id="spn_edad<?php echo $NumWindow; ?>">00 Años</span></small>
				</div>
				<div class="col-md-2">
					<label>Sexo: </label> <small><span id="spn_sexo<?php echo $NumWindow; ?>">-</span></small>
				</div>
				<div class="col-md-3">
					<label>Est. Civil: </label> <small><span id="spn_estcivil<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-5">
					<label>Dirección: </label> <small><span id="spn_direccion<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-3">
					<label>Teléfono: </label> <small><span id="spn_telefono<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-4">
					<label>Ocupación: </label> <small><span id="spn_ocupacion<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-5">
					<label>Acompañante: </label> <small><span id="spn_acomp<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-3">
					<label>Teléfono: </label> <small><span id="spn_telacomp<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-4">
					<label>Parentesco: </label> <small><span id="spn_parentesco<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-4">
					<label>Ingreso Por: </label> <small><span id="spn_ingpor<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-4">
					<label>Observaciones: </label> <small><span id="spn_obs<?php echo $NumWindow; ?>">Sin datos</span></small>
				</div>
				<div class="col-md-4">
					<label>Fecha Ingreso: </label> <span id="spn_fechaing<?php echo $NumWindow; ?>" class="badge">00/00/0000</span>
				</div>
			</div>
		</div>
		<div class="col-md-3 ">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">#</th> 
					<th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Usuario</th> 
				</tr> 
					 <?php 
					 if (isset($_GET["idhistoria"])) {
					$SQL="Select a.Codigo_HCF, a.Fecha_HCF, b.Nombre_HCT, c.Nombre_ARE, d.Nombre_USR, Folio_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["idhistoria"]."' and b.Codigo_HCT='ENFERMERIA' Order By 2 desc";
					$result = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($row = mysqli_fetch_array($result)) 
						{
							$contarow=$contarow+1;
							echo '
					  <tr onclick="CargarReport(\'application/reports/hc.php?HISTORIA='.$_GET["idhistoria"].'&FOLIO_INICIAL='.$row["Folio_HCF"].'&FOLIO_FINAL='.$row["Folio_HCF"].', \'hc\');"><td align="center">'.$row["Folio_HCF"].'</td><td align="center">'.formatofecha($row[1]).'</td><td>'.$row[4].'</td></tr>
					  ';
						}
					mysqli_free_result($result); 
					 }
					 ?>
				</tbody>
				</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			</div>
	  	</div>
	  	<div id="divformatohc<?php echo $NumWindow; ?>" class="col-md-12">
	  		<label class="label label-info"> <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> REGISTRO DE NOTAS</label>
	  		<div class="row well well-sm">
	  			<div class="col-md-2">
	  					<div class="form-group" id="grp_txt_fecha<?php echo $NumWindow; ?>">
							<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
							<input name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="text" required disabled="disabled" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
							<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
							<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="text" required />
						</div>
  					</div>
	  			<?php
				//SIGNOS VITALES
				echo '
				<div class="col-md-12">
					<label class="label label-success"> Signos Vitales</label>
				<div class="row alert alert-success">
			';
			$SQL="Select a.* from hcsv2 a, hcsv3 b where a.Codigo_HSV=b.Codigo_HSV and Codigo_SV1='0' order by Orden_HSV";
			$resultz = mysqli_query($conexion, $SQL);
			$contasv=0;
			while($rowz = mysqli_fetch_array($resultz)) 
				{
				$contasv=$contasv+1;
				$tamsv="3";
				echo '
			 	<div class="col-md-'.$tamsv.'">
			 		<input name="hdn_codsv'.$contasv.$NumWindow.'" type="hidden" id="hdn_codsv'.$contasv.$NumWindow.'" value="'.$rowz["Codigo_HSV"].'" />
			 		<div class="form-group" id="grp_txt_valorsv'.$contasv.$NumWindow.'">
				 		<label for="txt_valorsv'.$contasv.$NumWindow.'">'.$rowz["Sigla_HSV"].'</label>
				';
				if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
					echo '<div class="input-group">';
				}
				if ($rowz["Prefijo_HSV"]!="") {
					echo '<div class="input-group-addon">'.$rowz["Prefijo_HSV"].'</div>';
				}
				echo '
							<input name="txt_valorsv'.$contasv.$NumWindow.'" id="txt_valorsv'.$contasv.$NumWindow.'" type="text"  required/>
				';
				if ($rowz["Sufijo_HSV"]!="") {
					echo '<div class="input-group-addon">'.$rowz["Sufijo_HSV"].'</div>';
				}
				if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
					echo '</div>';
				}
				echo '
					</div>
				</div>
				';
				}
			mysqli_free_result($resultz); 

			echo '
				</div>
			</div>
			';// SIGNOS VITALES
	  		?>

	  			<div id="divnotaenf<?php echo $NumWindow; ?>" class="col-md-12">
					<div class="form-group" id="grp_txt_notaenf<?php echo $NumWindow; ?>">
						<label for="txt_notaenf<?php echo $NumWindow; ?>">Nota de Enfermería</label>
						<textarea class="form-control" rows="5" id="txt_notaenf<?php echo $NumWindow; ?>" name="txt_notaenf<?php echo $NumWindow; ?>" maxlength="5000" required></textarea>
					</div>
				</div>

	  		</div>

 		</div>
</div>

</form>

<script >

<?php
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, a.fechanac_pac, a.Codigo_SEX, a.EstCivil_PAC, b.direccion_ter, b.telefono_ter, a.Actividad_PAC, c.Acudiente_ADM, c.Parentesco_ADM, c.Telefono_ADM, h.Descripcion_ADM, c.Observaciones_ADM, left(Fecha_ADM,10), c.Autorizacion_ADM, c.Codigo_EPS, c.Codigo_PLA, i.Codigo_TAR from gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h, gxcontratos i where i.Codigo_PLA=f.Codigo_PLA and i.Codigo_EPS=d.Codigo_EPS and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Estado_ADM='I' and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('spn_contrato".$NumWindow."').innerHTML = '".$row[3]."';
				document.getElementById('spn_plan".$NumWindow."').innerHTML = '".$row[4]."';
				document.getElementById('spn_rango".$NumWindow."').innerHTML = '".$row[5]."';
				document.getElementById('spn_fechanac".$NumWindow."').innerHTML = '".formatofecha($row[6])."';
				document.getElementById('spn_edad".$NumWindow."').innerHTML = '".edad($row[6])."';
				document.getElementById('spn_sexo".$NumWindow."').innerHTML = '".$row[7]."';
				document.getElementById('spn_estcivil".$NumWindow."').innerHTML = '".$row[8]."';
				document.getElementById('spn_direccion".$NumWindow."').innerHTML = '".$row[9]."';
				document.getElementById('spn_telefono".$NumWindow."').innerHTML = '".$row[10]."';
				document.getElementById('spn_ocupacion".$NumWindow."').innerHTML = '".$row[11]."';
				document.getElementById('spn_acomp".$NumWindow."').innerHTML = '".$row[12]."';
				document.getElementById('spn_parentesco".$NumWindow."').innerHTML = '".$row[13]."';
				document.getElementById('spn_telacomp".$NumWindow."').innerHTML = '".$row[14]."';
				document.getElementById('spn_ingpor".$NumWindow."').innerHTML = '".$row[15]."';
				document.getElementById('spn_obs".$NumWindow."').innerHTML = '".preg_replace("/\r\n|\n|\r/", "<br/>",$row[16])."';
				document.getElementById('spn_fechaing".$NumWindow."').innerHTML = '".formatofecha($row[17])."';
				document.getElementById('hdn_contrato".$NumWindow."').value = '".$row[19]."';
				document.getElementById('hdn_plan".$NumWindow."').value = '".$row[20]."';
				document.getElementById('hdn_tarifa".$NumWindow."').value = '".$row[21]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_ingreso".$NumWindow."').value = '".$row[2]."';
				";
			}
			else {
				echo "
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." o no posee ingresos activos.');
			document.frm_form".$NumWindow.".cmb_area".$NumWindow.".focus();
				";
			}
			mysqli_free_result($result); 
		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

FechaActual('txt_fecha<?php echo $NumWindow; ?>');
HoraActual('txt_hora<?php echo $NumWindow; ?>');

function correctos10<?php echo $NumWindow; ?>(diez) {
	if (document.getElementById('hdn_correctos'+diez+'<?php echo $NumWindow; ?>').value=="0") {
		document.getElementById('hdn_correctos'+diez+'<?php echo $NumWindow; ?>').value='1';
	} else {
		document.getElementById('hdn_correctos'+diez+'<?php echo $NumWindow; ?>').value='0';
	}
	total=true;
	var conta=0;
	for (i = 1; i <= 10; i++) {
		if (document.getElementById('hdn_correctos'+i+'<?php echo $NumWindow; ?>').value=='0') {
			total=false;
			conta++;
		}
	}
	if (total==true) {
		document.getElementById('spn_diezc<?php echo $NumWindow; ?>').innerHTML='<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
		document.getElementById('hdn_diezc<?php echo $NumWindow; ?>').value=0;
		document.getElementById('nxs_sound_done').play();
	} else {
		document.getElementById('spn_diezc<?php echo $NumWindow; ?>').innerHTML='<i class="fas fa-eraser"></i>';
		document.getElementById('hdn_diezc<?php echo $NumWindow; ?>').value=conta;
	}
	
	
}

function cambiacantmed<?php echo $NumWindow; ?>(NumFila) {
	CantidadX=document.getElementById('txt_cantaplcadam'+NumFila+'<?php echo $NumWindow; ?>').value;
	AplicadoX=document.getElementById('hdn_cantdisponiblemx'+NumFila+'<?php echo $NumWindow; ?>').value;
	PendienteX=AplicadoX - CantidadX;
	if (PendienteX>=0) {
		document.getElementById('txt_cantdisponiblem'+NumFila+'<?php echo $NumWindow; ?>').value=PendienteX;
	} else {
		swal('Aplicación de medicamentos', 'La cantidad a aplicar no puede ser mayor a la asignada al paciente','error');
		document.getElementById('txt_cantdisponiblem'+NumFila+'<?php echo $NumWindow; ?>').value=AplicadoX;
		document.getElementById('txt_cantaplcadam'+NumFila+'<?php echo $NumWindow; ?>').value="0";
		document.getElementById('txt_cantaplcadam'+NumFila+'<?php echo $NumWindow; ?>').focus();
	}

}

function cambiacantins<?php echo $NumWindow; ?>(NumFila) {
	CantidadX=document.getElementById('txt_cantins'+NumFila+'<?php echo $NumWindow; ?>').value;
	AplicadoX=document.getElementById('hdn_cantdespinsx'+NumFila+'<?php echo $NumWindow; ?>').value;
	PendienteX=AplicadoX -CantidadX;
	if (PendienteX>=0) {
		document.getElementById('txt_cantdespins'+NumFila+'<?php echo $NumWindow; ?>').value=PendienteX;
	} else {
		swal('Insumos usados', 'La cantidad a utilizar no puede ser mayor a la asignada al paciente','error');
		document.getElementById('txt_cantdespins'+NumFila+'<?php echo $NumWindow; ?>').value=AplicadoX;
		document.getElementById('txt_cantins'+NumFila+'<?php echo $NumWindow; ?>').value="0";
		document.getElementById('txt_cantins'+NumFila+'<?php echo $NumWindow; ?>').focus();
	}
}

function NombreDispositivo<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreDispositivo(document.getElementById('txt_dispositivo<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>' );
  }
}

function NombreDispOnBlur<?php echo $NumWindow; ?>() {
    if (document.getElementById('txt_dispositivo<?php echo $NumWindow; ?>').value!="") {
		NombreDispositivo(document.getElementById('txt_dispositivo<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_nombreserv<?php echo $NumWindow; ?>').value = '';
	}
}


function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hcenfermeria.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/hcenfermeria.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hcenfermeria.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}
}


function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hcenfermeria.php', '<?php echo $NumWindow; ?>', '');	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
<script src="functions/nexus/hcenfermeria.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>