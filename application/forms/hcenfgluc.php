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
				<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="0" />
			</div>
		</div>
		<div class="col-md-4">
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
		<div class="col-md-1">
			<div class="form-group">
				<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
				<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group" id="grp_txt_fecha<?php echo $NumWindow; ?>">
				<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
				<input name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required disabled="disabled" />
			</div>
		</div>
		<div class="col-md-1">
			<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
				<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
				<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="time" required />
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
					$SQL="Select a.Codigo_HCF, a.Fecha_HCF, b.Nombre_HCT, c.Nombre_ARE, d.Nombre_USR, Folio_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["idhistoria"]."' and b.Codigo_HCT='ENFAPLMEDI' Order By 2 desc";
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
	  	<div class="col-md-12 " id="xApMed<?php echo $NumWindow; ?>">
	  		<div class="well row">
	  			<div class="col-md-1">
					<div class="form-group">
						<label for="txt_horagluc<?php echo $NumWindow; ?>">Hora</label>
						<input name="txt_horagluc<?php echo $NumWindow; ?>" id="txt_horagluc<?php echo $NumWindow; ?>" type="time"  />
					</div>
				</div>
	  			<div class="col-md-2">
					<div class="form-group">
						<label for="txt_resul<?php echo $NumWindow; ?>">Resultado (mg/dl)</label>
						<input name="txt_resul<?php echo $NumWindow; ?>" id="txt_resul<?php echo $NumWindow; ?>" type="number" value="0" />
					</div>
				</div>
	  			<div class="col-md-1">
					<div class="form-group">
						<label for="txt_cant<?php echo $NumWindow; ?>">Cantidad</label>
						<input name="txt_cant<?php echo $NumWindow; ?>" id="txt_cant<?php echo $NumWindow; ?>" type="number" value="0" />
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<label for="cmb_insulina<?php echo $NumWindow; ?>">Insulina</label>
						<select name="cmb_insulina<?php echo $NumWindow; ?>" id="cmb_insulina<?php echo $NumWindow; ?>">
							<option value="No">NO</option>
							<option value="Si">SI</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="cmb_tipoins<?php echo $NumWindow; ?>">Tipo Insulina</label>
						<select name="cmb_tipoins<?php echo $NumWindow; ?>" id="cmb_tipoins<?php echo $NumWindow; ?>">
							<option value="Ninguna">Ninguna</option>
							<option value="Cristalina">Cristalina</option>
							<option value="NPH">NPH</option>
							<option value="70 30">70 30</option>
							<option value="Lantus-glargina">Lantus-glargina</option>
							<option value="Otros">Otros</option>
						</select>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<label for="txt_unidins<?php echo $NumWindow; ?>">Unidades</label>
						<input name="txt_unidins<?php echo $NumWindow; ?>" id="txt_unidins<?php echo $NumWindow; ?>" type="number" value="0" />
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="cmb_viains<?php echo $NumWindow; ?>">Vía Administración</label>
						<select name="cmb_viains<?php echo $NumWindow; ?>" id="cmb_viains<?php echo $NumWindow; ?>">
							<option value="Ninguna">Ninguna</option>
							<option value="Vaginal">Vaginal</option>
							<option value="Oftálmica">Oftálmica</option>
							<option value="Ótica">Ótica</option>
							<option value="Intradérmica">Intradérmica</option>
							<option value="Otras">Otras</option>
							<option value="Todas las vías">Todas las vías</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="txt_observ<?php echo $NumWindow; ?>">Observaciones</label>
						<input name="txt_observ<?php echo $NumWindow; ?>" id="txt_observ<?php echo $NumWindow; ?>" type="text"  />
					</div>
				</div>
				<div class="col-md-12">
					<button type="button" class="btn btn-success btn-xs btn-block" onclick="AddGlucom<?php echo $NumWindow; ?>();">Agregar</button>
				</div>
	  			<div class="col-md-12">
	  				<label class="label label-success">Control de Glucometrías</label>
	  				<div id="zero_liqing<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
	  					<table  width="100%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblliqadm<?php echo $NumWindow; ?>" >
							<tbody id="tbDetalle<?php echo $NumWindow; ?>">
								<tr id="trh<?php echo $NumWindow; ?>"> 
									<th id="th1<?php echo $NumWindow; ?>">Hora</th> 
									<th id="th2<?php echo $NumWindow; ?>">Resultado</th> 
								    <th id="th2<?php echo $NumWindow; ?>">Cantidad</th> 
								    <th id="th2<?php echo $NumWindow; ?>">Insulina</th> 
								    <th id="th2<?php echo $NumWindow; ?>">Observaciones</th> 
								</tr> 
							</tbody>
						</table>
						<input type="hidden" name="hdn_controwadm<?php echo $NumWindow; ?>" id="hdn_controwadm<?php echo $NumWindow; ?>" value="0">
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
HoraActual('txt_horagluc<?php echo $NumWindow; ?>');

function AddGlucom<?php echo $NumWindow; ?>() {
  valor=document.getElementById('txt_cant<?php echo $NumWindow; ?>').value;
  if (valor=="0"){
	  MsgBox1("Verifique Cantidad", "Cantidad Administrada debe ser mayor que cero");
  } else {
  	hora=document.getElementById("txt_horagluc<?php echo $NumWindow; ?>").value;
  	resul=document.getElementById("txt_resul<?php echo $NumWindow; ?>").value;
  	ins=document.getElementById("cmb_insulina<?php echo $NumWindow; ?>").value;
  	obs=document.getElementById("txt_observ<?php echo $NumWindow; ?>").value;
  	TotalFilas=document.getElementById("hdn_controwadm<?php echo $NumWindow; ?>").value;
    var miTabla = document.getElementById("tblliqadm<?php echo $NumWindow; ?>"); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda3 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
    var celda5 = document.createElement("td"); 
    TotalFilas++;
	fila.id="trladm"+TotalFilas+"<?php echo $NumWindow; ?>";
	celda1.innerHTML = '<input name="hdn_tantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_tantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+hora+'" /> '+hora; 
	celda2.innerHTML = '<input name="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+viaadm+''+'" /> '+resul; 
	celda3.innerHTML = '<input name="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+valor+''+'" /> '+valor; 
	celda4.innerHTML = '<input name="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+horaini+''+'" /> '+ins; 
	celda5.innerHTML = '<input name="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+horaini+''+'" /> '+obs; 
	fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda3); 
    fila.appendChild(celda4); 
    fila.appendChild(celda5); 
    miTabla.appendChild(fila); 
	document.getElementById("hdn_controwadm<?php echo $NumWindow; ?>").value=TotalFilas;
	document.getElementById('txt_horagluc<?php echo $NumWindow; ?>').focus();
  }
}


function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hcenfgluc.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/hcenfgluc.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hcenfgluc.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}
}


function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hcenfgluc.php', '<?php echo $NumWindow; ?>', '');	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");

</script>
<script src="functions/nexus/hcenfgluc.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>