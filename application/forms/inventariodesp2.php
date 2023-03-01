<?php
	
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	//VERIFICAMOS QUE EL USUARIO TENGA ASIGNADA UNA BODEGA ACTIVA
	$GxBodega="";
	if ($_SESSION["it_CodigoPRF"]!="0") {
		$SQL="Select Codigo_BDG From czbodegas Where Codigo_BDG in (Select Codigo_BDG From itusuariosbodegas Where Codigo_USR='".$_SESSION["it_CodigoUSR"]."') and Estado_BDG='1' ";
	} else {
		$SQL="Select Codigo_BDG From czbodegas Where Estado_BDG='1' ";	
	}
	$resultb = mysqli_query($conexion, $SQL);
	while($rowb = mysqli_fetch_array($resultb)) {
		$GxBodega=$rowb[0];
	}
	mysqli_free_result($resultb);
	if ($GxBodega!="") {
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>">
<div id="divsolicitudmed<?php echo $NumWindow; ?>" class="col-md-12">
  		<label class="label label-success"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Solicitud <?php echo add_ceros($_GET["numsol"],6); ?></label>
	<div class="row well well-sm">

	  		<div class="col-md-12 alert alert-warning">
	<div class="row">
	<?php 
	$SQL="Select distinct b.ID_TER, b.Nombre_TER, concat(c.Fecha_HCF,' ', c.Hora_HCF), e.Codigo_ADM, f.Nombre_ARE, d.Nombre_CAM, k.Nombre_SDE, g.Nombre_USR, m.Nombre_TER, n.Nombre_PLA, c.Codigo_TER, c.Codigo_HCF From czinvsolfarmacia a, czterceros b, hcfolios c, gxcamas d, gxadmision e, gxareas f, itusuarios g, czsedes k, gxeps l, czterceros m, gxplanes n Where n.Codigo_PLA=e.Codigo_PLA and c.Codigo_ADM=e.Codigo_ADM and d.Codigo_CAM=e.Codigo_CAM and k.Codigo_SDE=e.Codigo_SDE and l.Codigo_EPS=e.Codigo_EPS and l.Codigo_TER=m.Codigo_TER and b.Codigo_TER=a.Codigo_TER and c.Codigo_TER=b.Codigo_TER and c.Codigo_HCF=a.Codigo_HCF and c.Codigo_USR=g.Codigo_USR and f.Codigo_ARE=c.Codigo_ARE and a.Estado_ISF in ('S', 'P') and a.Codigo_ISF='".$_GET["numsol"]."'  and a.Pendiente_ISF > 0";
	
	$resultx = mysqli_query($conexion, $SQL);
	while($rowx = mysqli_fetch_array($resultx)) 
		{
	?>
		<div class="col-md-6">
			<label>Paciente: </label> <span id="spn_cedulax<?php echo $NumWindow; ?>" class="badge"><?php echo $rowx[0]; ?></span> - <span id="spn_pacientex<?php echo $NumWindow; ?>" class="badge"><?php echo $rowx[1]; ?></span>
			<input name="hdn_solicitud<?php echo $NumWindow; ?>" type="hidden" id="hdn_solicitud<?php echo $NumWindow; ?>" value="<?php echo $_GET["numsol"]; ?>" />
			<input name="hdn_codter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codter<?php echo $NumWindow; ?>" value="<?php echo $rowx[10]; ?>" />
			<input name="hdn_foliohc<?php echo $NumWindow; ?>" type="hidden" id="hdn_foliohc<?php echo $NumWindow; ?>" value="<?php echo $rowx[11]; ?>" />
		</div>
		<div class="col-md-3">
			<label>Fecha Solicitud: </label> <small><span id="spn_fecsolx<?php echo $NumWindow; ?>"><?php echo $rowx[2]; ?></span></small>
		</div>
		<div class="col-md-3">
			<label>Ingreso: </label> <span id="spn_ingresox<?php echo $NumWindow; ?>"><?php echo '<input name="hdn_admision'.$NumWindow.'" type="hidden" id="hdn_admision'.$NumWindow.'" value="'.$rowx[3].'">'.$rowx[3]; ?></span>
		</div>
		<div class="col-md-3">
			<label>Area: </label> <span id="spn_areax<?php echo $NumWindow; ?>"><?php echo $rowx[4]; ?></span>
		</div>
		<div class="col-md-2">
			<label>Cama: </label> <span id="spn_camax<?php echo $NumWindow; ?>"><?php echo $rowx[5]; ?></span>
		</div>
		<div class="col-md-3">
			<label>Sede: </label> <span id="spn_sedex<?php echo $NumWindow; ?>"><?php echo $rowx[6]; ?></span>
		</div>
		<div class="col-md-4">
			<label>Solicita: </label> <span id="spn_solicx<?php echo $NumWindow; ?>"><?php echo $rowx[7]; ?></span>
		</div>
		<div class="col-md-4">
			<label>Contrato: </label> <span id="spn_contratox<?php echo $NumWindow; ?>"><?php echo $rowx[8]; ?></span>
		</div>
		<div class="col-md-3">
			<label>Plan: </label> <span id="spn_planx<?php echo $NumWindow; ?>"><?php echo $rowx[9]; ?></span>
		</div>
	<?php
		}
	mysqli_free_result($result);
	
	?>  
	</div>
		</div>
		<div class="col-md-2">
	    <div class="form-group">
			<label for="txt_codmas<?php echo $NumWindow; ?>">Código</label>
			<div class="input-group">	
				<input name="txt_codmas<?php echo $NumWindow; ?>" id="txt_codmas<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodMas<?php echo $NumWindow; ?>(event);" onblur="CodMasOnBlur<?php echo $NumWindow; ?>()" />
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codmas<?php echo $NumWindow; ?>', 'Codigo_CFC=*09*');"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="form-group">
			<label for="txt_medicamento<?php echo $NumWindow; ?>">Insumo</label>
			<input  name="txt_medicamento<?php echo $NumWindow; ?>" id="txt_medicamento<?php echo $NumWindow; ?>" type="text" placeholder="Ingrese el nombre del Producto" list="producto<?php echo $NumWindow; ?>" onchange="CodProdSF('<?php echo $NumWindow; ?>', this.value);" />
		</div>			
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<label for="txt_cantmas<?php echo $NumWindow; ?>">Cantidad</label>
			<div class="input-group">	
				<input name="txt_cantmas<?php echo $NumWindow; ?>" id="txt_cantmas<?php echo $NumWindow; ?>" type="text" value="1" onkeypress="AddMasX<?php echo $NumWindow; ?>(event);" />
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddMas<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
				</span>
			</div>
		</div>			
	</div>
	<div class="col-md-12">
	  	<div id="zero_detalleMed<?php echo $NumWindow; ?>" class="detalleord table-responsive "  style="height:30%">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleMed<?php echo $NumWindow; ?>" >
			<tbody id="tbMedX<?php echo $NumWindow; ?>">
			<tr id="trhmX'.$NumWindow.'"> 
				<th id="th2mX'.$NumWindow.'">Codigo</th> 
				<th id="th3mX'.$NumWindow.'">Nombre</th> 
				<th id="th4mX'.$NumWindow.'">Formula</th> 
				<th id="th5mX'.$NumWindow.'">Cantidad</th> 
				<th id="th6mX'.$NumWindow.'">Entregado</th>
				<th id="th6mX'.$NumWindow.'">Pendiente</th> 
				<th id="th6mX'.$NumWindow.'">Bodega</th>
			</tr> 
			<?php 
			$filasMed=0;
			$SQL="Select a.Codigo_SER, b.Nombre_MED, concat(a.Dosis_HCM, ' ', c.Descripcion_VIA, ' - Frecuencia:', d.Descripcion_FRC, ', Duración: ', a.Duracion_HCM, '. ', a.Observaciones_HCM), a.Pendiente_HCM From hcordenesmedica a, gxmedicamentos b, gxviasmed c, gxfrecuenciamed d, czinvsolfarmacia e Where a.Codigo_SER=b.Codigo_SER and c.Codigo_VIA=a.Via_HCM and a.Frecuencia_HCM=d.Codigo_FRC and a.Codigo_HCF=e.Codigo_HCF and e.Codigo_TER=a.Codigo_TER and  e.Codigo_SER=a.Codigo_SER and e.Codigo_ISF='".$_GET["numsol"]."' and e.Pendiente_ISF > 0";
			$resultm = mysqli_query($conexion, $SQL);
			while($rowm = mysqli_fetch_array($resultm)) {
				$filasMed=$filasMed+1;
				echo '<tr id="trmedx'.$filasMed.$NumWindow.'">
				<td><input name="hdn_codmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_codmed'.$filasMed.$NumWindow.'" value="'.$rowm[0].'"> '.$rowm[0].'</td>
				<td>'.$rowm[1].'</td>
				<td><input name="hdn_obsmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_obsmed'.$filasMed.$NumWindow.'" value="'.$rowm[2].'"> '.$rowm[2].'</td>
				<td><input name="hdn_cantidadmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_cantidadmed'.$filasMed.$NumWindow.'" value="'.$rowm[3].'"> '.$rowm[3].'</td>
				<td><input name="txt_cantdespmed'.$filasMed.$NumWindow.'" id="txt_cantdespmed'.$filasMed.$NumWindow.'" type="number" value="'.$rowm[3].'" max="'.$rowm[3].'" min="0" class="form-control input-sm" onchange="cambiacantmed'.$NumWindow.'(\''.$filasMed.'\');"></td>
				<td><input name="txt_cantpendmed'.$filasMed.$NumWindow.'" id="txt_cantpendmed'.$filasMed.$NumWindow.'" type="text" value="0" class="form-control input-sm" disabled></td>
				<td><select name="cmb_bodega'.$filasMed.$NumWindow.'" id="cmb_bodega'.$filasMed.$NumWindow.'">';
				$SQL="Select Codigo_BDG, Nombre_BDG From czbodegas Where Codigo_BDG in (Select Codigo_BDG From itusuariosbodegas Where Codigo_USR='".$_SESSION["it_CodigoUSR"]."') and Estado_BDG='1' Order By 2 ";
				$resultb = mysqli_query($conexion, $SQL);
				while($rowb = mysqli_fetch_array($resultb)) {
					echo '<option value="'.$rowb[0].'">'.$rowb[1].'</option>';
				}
				mysqli_free_result($resultb);
				echo '</select></td>
				</tr>';
			}
			mysqli_free_result($resultm); 
			?>
			</tbody> 
			</table><input name="hdn_controwMed<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwMed<?php echo $NumWindow; ?>" value="<?php echo $filasMed; ?>" />
		</div>
	</div>	

	<div class="col-md-12">
		<div class="form-group">
			<label for="txt_nota<?php echo $NumWindow; ?>">Observaciones</label>
			<textarea  name="txt_nota<?php echo $NumWindow; ?>" id="txt_nota<?php echo $NumWindow; ?>" rows="2" />
		</div>			
	</div>

	</div>

	<div class="col-md-12">
		<button class="btn btn-success btn-block btn-md" onclick="javascript:Guardar_inventariosolfarm('<?php echo $NumWindow; ?>', '<?php echo $_GET["genesis"]; ?>');" data-dismiss="modal" id="guardar<?php echo $NumWindow; ?>" name="guardar<?php echo $NumWindow; ?>" >Crear Solicitud</button>
	</div>
</div>
<datalist id="producto<?php echo $NumWindow; ?>">
<?php
$SQL="SELECT trim(a.Nombre_SER) FROM gxservicios a WHERE Estado_SER='1' and Codigo_CFC='09' ORDER BY 1;";
$rstpuc = mysqli_query($conexion, $SQL);
while($rowPUC = mysqli_fetch_array($rstpuc)) {
	echo '<option value="'.$rowPUC[0].'">';
}
mysqli_free_result($rstpuc);
?>
</datalist>	
<?php
} else {
?>
<input name="hdn_controwMed<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwMed<?php echo $NumWindow; ?>" value="0" />


</form>
<?php
	}
?>
<script >

$(":input:text:visible:first", "#frm_form0<?php echo $NumWindow; ?>").focus();

<?php
	if ($GxBodega=="") {
		echo "
			swal('DESPACHO A PACIENTES', 'Usted no posee permisos para trabajar con una bodega válida','error');
		";
	}
?>

function cambiacantmed<?php echo $NumWindow; ?>(NumFila) {
	CantidadX=document.getElementById('hdn_cantidadmed'+NumFila+'<?php echo $NumWindow; ?>').value;
	EntregadoX=document.getElementById('txt_cantdespmed'+NumFila+'<?php echo $NumWindow; ?>').value;
	PendienteX=CantidadX - EntregadoX;
	if (PendienteX>=0) {
		document.getElementById('txt_cantpendmed'+NumFila+'<?php echo $NumWindow; ?>').value=PendienteX;
	} else {
		document.getElementById('txt_cantpendmed'+NumFila+'<?php echo $NumWindow; ?>').value="0";
	}
	DespMedSol<?php echo $NumWindow; ?>();
}

function cambiacantmas<?php echo $NumWindow; ?>(NumFila) {
	EntregadoX=document.getElementById('txt_cantdespmed'+NumFila+'<?php echo $NumWindow; ?>').value;
	document.getElementById('txt_cantidadmed'+NumFila+'<?php echo $NumWindow; ?>').value=EntregadoX;
	DespMedSol<?php echo $NumWindow; ?>();
}

function BuscarCodMas<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	document.getElementById('txt_cantmas<?php echo $NumWindow; ?>').focus();
  }
}

function CodMasOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codmas<?php echo $NumWindow; ?>').value!="") {
		NombreMedicamento(document.getElementById('txt_codmas<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value = '';
	}
	DespMedSol<?php echo $NumWindow; ?>();
}

function AddMasX<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	AddMas();
  }
}

function AddMas<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_codmas<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el insumo a despachar";
	}
	if (document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Despacho a Pacientes', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbMedX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trmas"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodMas=document.getElementById('txt_codmas<?php echo $NumWindow; ?>').value;
		Insumo=document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value;
	    CantMas=document.getElementById('txt_cantmas<?php echo $NumWindow; ?>').value;
		ObsMas="** Insumo **";
		elselect='<select name="cmb_bodega'+TotalFilas+'<?php echo $NumWindow; ?>" id="cmb_bodega'+TotalFilas+'<?php echo $NumWindow; ?>" class="form-control">';
		<?php
			$SQL="Select Codigo_BDG, Nombre_BDG From czbodegas Where Estado_BDG='1' Order By 2 ";
			$resultb = mysqli_query($conexion, $SQL);
			while($rowb = mysqli_fetch_array($resultb)) {
		?>
		elselect=elselect + '<option value="<?php echo $rowb[0]; ?>"><?php echo $rowb[1]; ?></option>';
		<?php
			}
			mysqli_free_result($resultb);
		?>
		elselect=elselect + '</select>';
		celda1.innerHTML = '<input name="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodMas+''+'" /> '+CodMas; 
		celda2.innerHTML = Insumo; 
		celda3.innerHTML = '<input name="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsMas+''+'" /> '+ObsMas; 
		celda4.innerHTML = '<input name="txt_cantidadmed'+TotalFilas+'<?php echo $NumWindow; ?>" id="txt_cantidadmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="text" value="'+CantMas+'" class="form-control input-sm" disabled>';
		celda5.innerHTML = '<input name="txt_cantdespmed'+TotalFilas+'<?php echo $NumWindow; ?>" id="txt_cantdespmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="text" value="'+CantMas+'" class="form-control input-sm" onchange="cambiacantmas<?php echo $NumWindow; ?>(\''+TotalFilas+'\');">';
		celda6.innerHTML = '<input name="txt_cantpendmed'+TotalFilas+'<?php echo $NumWindow; ?>" id="txt_cantpendmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="text" value="0" class="form-control input-sm" disabled>';
		celda7.innerHTML = elselect;
		fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda7); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codmas<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codmas<?php echo $NumWindow; ?>').focus();
	}
	DespMedSol<?php echo $NumWindow; ?>();
}

    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>