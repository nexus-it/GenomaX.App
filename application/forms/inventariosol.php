<?php
	
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form0<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_form0<?php echo $NumWindow; ?>">
<div id="divlistasolmed<?php echo $NumWindow; ?>" class="col-md-12">
	<div class="row">

<div class="col-md-12">
	<label class="label label-primary"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar Solicitudes </label>
  <div class="row well well-sm">

		<div class="col-md-3">
		
	<div class="form-group">
	  <label for="txt_fitrofecini<?php echo $NumWindow; ?>">Fecha Inicial</label>
	  <input  name="txt_fitrofecini<?php echo $NumWindow; ?>" id="txt_fitrofecini<?php echo $NumWindow; ?>" type="date" required value="<?php FechaNow(); ?>">
	</div>

		</div>
		<div class="col-md-3">
		
	<div class="form-group">
	  <label for="txt_fitrofecfin<?php echo $NumWindow; ?>">Fecha Final</label>
	  <input  name="txt_fitrofecfin<?php echo $NumWindow; ?>" id="txt_fitrofecfin<?php echo $NumWindow; ?>" type="date" required value="<?php FechaNow(); ?>">
	</div>

		</div>
		<div class="col-md-3">
		
	<div class="form-group">
	  <label for="cmb_filtrosede<?php echo $NumWindow; ?>">Sede</label>
	  <select name="cmb_filtrosede<?php echo $NumWindow; ?>" id="cmb_filtrosede<?php echo $NumWindow; ?>">
	  	<option value="X">Todas</option>
	<?php 
	$SQL="Select Codigo_SDE, Nombre_SDE from czsedes where Estado_SDE='1' order by Nombre_SDE";
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
	</div>

		</div>
		<div class="col-md-3">
		
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

<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" >
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
	    <tr><td colspan="7" align="center"> Cargando...</td></tr>
</tbody>
</table>
 </div>
 
		</div>
	</div>
</div>
</form>
<script >

$(":input:text:visible:first", "#frm_form0<?php echo $NumWindow; ?>").focus();

<?php
	if (isset($_GET["CodigoARE"])) {
		echo "
			document.frm_form0".$NumWindow.".cmb_filtroarea".$NumWindow.".value='".$_GET["CodigoARE"]."';
			document.frm_form0".$NumWindow.".cmb_filtrosede".$NumWindow.".value='".$_GET["CodigoSDE"]."';
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
	DespMedSol('<?php echo $NumWindow; ?>',document.getElementById('cmb_filtroarea<?php echo $NumWindow; ?>').value, document.getElementById('cmb_filtrosede<?php echo $NumWindow; ?>').value, document.getElementById('txt_fitrofecini<?php echo $NumWindow; ?>').value, document.getElementById('txt_fitrofecfin<?php echo $NumWindow; ?>').value );
}

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

DespMedSol<?php echo $NumWindow; ?>();

    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

</script>