<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$elanyo = date("Y");
	$elmes = date("m");	
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" onreset="resetea<?php echo $NumWindow; ?>()"><fieldset>
<legend>Programación de Turnos:</legend>
  <label for="txt_codtrn<?php echo $NumWindow; ?>">Código</label>
  <input name="txt_codtrn<?php echo $NumWindow; ?>" type="text" id="txt_codtrn<?php echo $NumWindow; ?>" size="3" value="0" onkeypress="BuscarMyTrn<?php echo $NumWindow; ?>(event);"/>
  <a href="javascript:CargarSearch('MyTurnos', 'txt_codtrn<?php echo $NumWindow; ?>', 'NULL');"><img src="http://cdn.genomax.co/media/image/showhelp.png"  alt="Buscar Programación" align="absmiddle" title="Buscar Programación" /></a>
  <label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
  <input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" size="40" />
<br />
<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicio</label>
<input name="txt_fechaini<?php echo $NumWindow; ?>" type="text" id="txt_fechaini<?php echo $NumWindow; ?>" size="10"  class="datepicker" onChange="cambiafecha<?php echo $NumWindow; ?>();"/>
<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Fin</label>
<input name="txt_fechafin<?php echo $NumWindow; ?>" type="text" id="txt_fechafin<?php echo $NumWindow; ?>" size="10"  class="datepicker" onChange="cambiafecha<?php echo $NumWindow; ?>();"/>

</fieldset>
<fieldset>
<legend>Detalle Programación:</legend>
<div id="copyfrom<?php echo $NumWindow; ?>" class="izq">
  <label for="cmb_plantilla">Copiar desde </label>
  <select name="cmb_plantilla<?php echo $NumWindow; ?>" id="cmb_plantilla<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_TUR, Nombre_TUR from czmyturnosenc order by Fecha_TUR desc Limit 12";
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
  <a href="javascript:LoadMyTrn<?php echo $NumWindow; ?>(document.getElementById('cmb_plantilla<?php echo $NumWindow; ?>').value);"><img src="http://cdn.genomax.co/media/image/table_import.png"  alt="Cargar Plantilla" align="absmiddle" title="Cargar Plantilla" /></a></div>
<hr class="anulado" />
<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleordx2" >  
<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblProgramacion<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
          <th id="th1<?php echo $NumWindow; ?>">Area</th> 
          <th id="th2<?php echo $NumWindow; ?>">Turno 1</th> 
          <th id="th3<?php echo $NumWindow; ?>">Empleado</th> 
          <th id="th4<?php echo $NumWindow; ?>">Turno 2</th> 
          <th id="th5<?php echo $NumWindow; ?>">Empleado</th> 
          <th id="th6<?php echo $NumWindow; ?>">X</th> 
     </tr> 
     
</tbody>
</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
</div>
<div id="Cont_progturnos<?php echo $NumWindow; ?>" class="tblDetalle1">
<label for="cmb_area<?php echo $NumWindow; ?>">Area</label>
<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>" onchange="UpdSource<?php echo $NumWindow; ?>();">
<?php 
$SQL="Select Codigo_ARE, Nombre_ARE from czareas Where Estado_ARE='1' order by Nombre_ARE";
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
<label for="cmb_turno1<?php echo $NumWindow; ?>">Turno 1</label>
<select name="cmb_turno1<?php echo $NumWindow; ?>" id="cmb_turno1<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_TRN, Nombre_TRN from cztipoturnos where Estado_TRN='1' order by Nombre_TRN";
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
<label for="txt_idempleado1<?php echo $NumWindow; ?>">Empleado</label>
<input name="txt_idempleado1<?php echo $NumWindow; ?>" id="txt_idempleado1<?php echo $NumWindow; ?>" type="text" size="12" />
<input type="hidden" id="hdn_idtercero1<?php echo $NumWindow; ?>" name="hdn_idtercero1<?php echo $NumWindow; ?>"/>

<label for="cmb_turno2<?php echo $NumWindow; ?>">Turno 2</label>
<select name="cmb_turno2<?php echo $NumWindow; ?>" id="cmb_turno2<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_TRN, Nombre_TRN from cztipoturnos where Estado_TRN='1' order by Nombre_TRN";
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
<label for="txt_idempleado2<?php echo $NumWindow; ?>">Empleado</label>
<input name="txt_idempleado2<?php echo $NumWindow; ?>" id="txt_idempleado2<?php echo $NumWindow; ?>" type="text" size="12" />
<input type="hidden" id="hdn_idtercero2<?php echo $NumWindow; ?>" name="hdn_idtercero2<?php echo $NumWindow; ?>"/>
 | 
<a href="javascript:AddRowMyTrns<?php echo $NumWindow; ?>();"><img src="http://cdn.genomax.co/media/image/add.png" alt="Agregar a la programación" align="absmiddle" title="Agregar a la programación" /></a>
</div>
<hr class="anulado" />
<label for="txt_observaciones<?php echo $NumWindow; ?>">Observaciones</label>
<textarea name="txt_observaciones<?php echo $NumWindow; ?>" cols="60" rows="3" id="txt_observaciones<?php echo $NumWindow; ?>" ></textarea>

</fieldset>
</form>
<script type="text/javascript" src="functions/js/jquery/a.jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="functions/js/jquery/b.jquery-ui-1.8.6.custom.min.js"></script>
<script >

$(function() 
{
	// configuramos el control para realizar la busqueda de los productos
	$("#txt_idempleado2<?php echo $NumWindow; ?>").autocomplete({
		source: "functions/php/nexus/autocomplete.php?type=emple", 				/* este es el formulario que realiza la busqueda */
		minLength: 2,									/* le decimos que espere hasta que haya 2 caracteres escritos */
		select: function( event, ui ) {
	        var producto = ui.item.value;
			$("#hdn_idtercero2<?php echo $NumWindow; ?>").val(producto.valor);
			$("#txt_idempleado2<?php echo $NumWindow; ?>").val(producto.descripcion);
	        return false;
	    },
		focus: function( event, ui ) {
			var producto = ui.item.value;
			$("#txt_idempleado2<?php echo $NumWindow; ?>").val(producto.descripcion);
			return false;
		}
	});
	$("#txt_idempleado1<?php echo $NumWindow; ?>").autocomplete({
		source: "functions/php/nexus/autocomplete.php?type=emple", 				/* este es el formulario que realiza la busqueda */
		minLength: 2,									/* le decimos que espere hasta que haya 2 caracteres escritos */
		select: function( event, ui ) {
	        var producto = ui.item.value;
			$("#hdn_idtercero1<?php echo $NumWindow; ?>").val(producto.valor);
			$("#txt_idempleado1<?php echo $NumWindow; ?>").val(producto.descripcion);
	        return false;
	    },
		focus: function( event, ui ) {
			var producto = ui.item.value;
			$("#txt_idempleado1<?php echo $NumWindow; ?>").val(producto.descripcion);
			return false;
		}
	});
});

document.getElementById('txt_codtrn<?php echo $NumWindow; ?>').focus();
<?php 
if (isset($_GET["CodTrn"])) {
	$SQL="Select Codigo_TUR, Nombre_TUR, FechaIni_TUR, FechaFin_TUR, Observaciones_TUR From czmyturnosenc Where Codigo_TUR='".$_GET["CodTrn"]."'";
	$result = mysqli_query($conexion, $SQL);
	echo "document.frm_form".$NumWindow.".txt_codtrn".$NumWindow.".value='".$_GET["CodTrn"]."';";
	if($row = mysqli_fetch_array($result)) {
	$NoVent1= substr($NumWindow, (strlen($NumWindow)-strpos($NumWindow, "_")-1)*(-1));
	echo "
		document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row["Nombre_TUR"]."';
		document.frm_form".$NumWindow.".txt_fechaini".$NumWindow.".value='".FormatoFecha($row["FechaIni_TUR"])."';
		document.frm_form".$NumWindow.".txt_fechafin".$NumWindow.".value='".FormatoFecha($row["FechaFin_TUR"])."';
		document.frm_form".$NumWindow.".txt_observaciones".$NumWindow.".value=\"".preg_replace("/\r\n|\n|\r/", "<br/>",$row["Observaciones_TUR"])."\";
		LoadMyTrn".$NumWindow."('".$_GET["CodTrn"]."');
		document.getElementById(\"Imprimir".$NoVent1."\").style.display = 'inline';
		";
	}else {
		echo "	MsgBox1('Programación de Horarios','<div class=\"message_alert\"></div>No se encuentra el código de programación [".$_GET["CodTrn"]."] digitado.');
		document.frm_form".$NumWindow.".txt_codtrn".$NumWindow.".value='0';";

	}
	mysqli_free_result($result); 
}
?>

function LoadMyTrn<?php echo $NumWindow; ?>(CdgTrn) {
	$.get(Funciones,{'Func':'MyTurnos', 'Cod':CdgTrn, 'Ventana':'<?php echo $NumWindow; ?>', 'Tema':'<?php echo $_SESSION["THEME_DEFAULT"]; ?>'},function(data){
		InsertarHTML('zero_detalle<?php echo $NumWindow; ?>',data);
	});
}

function AddRowMyTrns<?php echo $NumWindow; ?>() {
	var texto1 = document.getElementById("txt_idempleado1<?php echo $NumWindow; ?>").value;
	var texto2 = document.getElementById("txt_idempleado2<?php echo $NumWindow; ?>").value;
	var CodTer1 = document.getElementById("hdn_idtercero1<?php echo $NumWindow; ?>").value;
	var CodTer2 = document.getElementById("hdn_idtercero2<?php echo $NumWindow; ?>").value;
	var cmbArea = document.getElementById("cmb_area<?php echo $NumWindow; ?>").value;
	var cmbTurno1 = document.getElementById("cmb_turno1<?php echo $NumWindow; ?>").value;
	var cmbTurno2 = document.getElementById("cmb_turno2<?php echo $NumWindow; ?>").value;
	var xArea = document.getElementById("cmb_area<?php echo $NumWindow; ?>").options[document.getElementById("cmb_area<?php echo $NumWindow; ?>").selectedIndex].text;
	var xTurno1 = document.getElementById("cmb_turno1<?php echo $NumWindow; ?>").options[document.getElementById("cmb_turno1<?php echo $NumWindow; ?>").selectedIndex].text;
	var xTurno2 = document.getElementById("cmb_turno2<?php echo $NumWindow; ?>").options[document.getElementById("cmb_turno2<?php echo $NumWindow; ?>").selectedIndex].text;
	if ((texto1=="") && (texto2=="")) {
		MsgBox1("Programación de turnos", "Debe seleccionar por lo menos un empleado");
		document.getElementById("txt_idempleado1<?php echo $NumWindow; ?>").focus();
	} else {
		if ((cmbTurno1==cmbTurno2) && ((texto1!="")&&(texto2!=""))) {
			MsgBox1("Programación de turnos", "Ambos turnos no pueden coincidir en el horario.");
			document.getElementById("cmb_turno1<?php echo $NumWindow; ?>").focus();
		} else {
			if (texto1=="") CodTer1="";
			if (texto2=="") CodTer2="";
			if (CodTer1=="") {
				cmbTurno1="";
				xTurno1="";
			}
			if (CodTer2=="") {
				cmbTurno2="";
				xTurno2="";
			}
			TotalFilas=document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value;
			var miTabla = document.getElementById("tblProgramacion<?php echo $NumWindow; ?>"); 
		    var fila = document.createElement("tr"); 
		    var celda1 = document.createElement("td"); 
		    var celda2 = document.createElement("td"); 
		    var celda3 = document.createElement("td"); 
		    var celda4 = document.createElement("td"); 
		    var celda5 = document.createElement("td"); 
		    var celda6 = document.createElement("td"); 
			TotalFilas++;
			fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
		    celda1.innerHTML = '<input name="hdn_codarea'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codarea'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+cmbArea+''+'" />'+xArea; 
			celda2.innerHTML = '<input name="hdn_turno1'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_turno1'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+cmbTurno1+''+'" />'+xTurno1; 
			celda3.innerHTML = '<input name="hdn_empleado1'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_empleado1'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodTer1+''+'" />'+texto1; 
			celda4.innerHTML = '<input name="hdn_turno2'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_turno2'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+cmbTurno2+''+'" />'+xTurno2; 
			celda5.innerHTML = '<input name="hdn_empleado2'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_empleado2'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodTer2+''+'" />'+texto2; 
			celda6.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\'<?php echo $NumWindow; ?>\');"><img src="http://cdn.genomax.co/media/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar fila de la programación" /></a>'; 
		    fila.appendChild(celda1); 
		    fila.appendChild(celda2); 
		    fila.appendChild(celda3); 
		    fila.appendChild(celda4); 
		    fila.appendChild(celda5); 
		    fila.appendChild(celda6); 
		    miTabla.appendChild(fila); 
			document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
			document.getElementById("txt_idempleado1<?php echo $NumWindow; ?>").value="";
			document.getElementById("txt_idempleado2<?php echo $NumWindow; ?>").value="";
			document.getElementById("hdn_idtercero1<?php echo $NumWindow; ?>").value="";
			document.getElementById("hdn_idtercero2<?php echo $NumWindow; ?>").value="";
		}
	}
}

function cambiafecha<?php echo $NumWindow; ?>() {
	var fecha1 = document.getElementById("txt_fechaini<?php echo $NumWindow; ?>").value;
	var fecha2 = document.getElementById("txt_fechafin<?php echo $NumWindow; ?>").value;
	var nombreprog="";
	var array_fecha1 = fecha1.split("/") ;
	var array_fecha2 = fecha2.split("/") ;
	if ((fecha1!="")&&(fecha2!="")) {
		if (fecha1==fecha2) {
			nombreprog=DiaSemana(fecha1)+' '+array_fecha1[0]+' de '+NombreMes(fecha1)+' de '+array_fecha1[2];
		} else {
			if (NombreMes(fecha1)==NombreMes(fecha2)) {
				if (((DiaSemana(fecha1)=="Lunes")||(DiaSemana(fecha1)=="Martes"))&&((DiaSemana(fecha2)=="Viernes")||(DiaSemana(fecha2)=="Sábado"))) {
					nombreprog='Semana del '+array_fecha1[0]+' al '+array_fecha2[0]+' de '+NombreMes(fecha1)+' de '+array_fecha1[2];
				} else {
					nombreprog='Del '+array_fecha1[0]+' al '+array_fecha2[0]+' de '+NombreMes(fecha1)+' de '+array_fecha1[2];
				}
			} else {
				if (array_fecha1[2]==array_fecha2[2]) {
					if (((DiaSemana(fecha1)=="Lunes")||(DiaSemana(fecha1)=="Martes"))&&((DiaSemana(fecha2)=="Viernes")||(DiaSemana(fecha2)=="Sábado"))) {
						nombreprog='Semana del '+array_fecha1[0]+' de '+NombreMes(fecha1)+' al '+array_fecha2[0]+' de '+NombreMes(fecha2)+' de '+array_fecha1[2];
					} else {
						nombreprog='Del '+array_fecha1[0]+' de '+NombreMes(fecha1)+' al '+array_fecha2[0]+' de '+NombreMes(fecha2)+' de '+array_fecha1[2];
					}
				} else {
					if (((DiaSemana(fecha1)=="Lunes")||(DiaSemana(fecha1)=="Martes"))&&((DiaSemana(fecha2)=="Viernes")||(DiaSemana(fecha2)=="Sábado"))) {
						nombreprog='Semana del '+array_fecha1[0]+' de '+NombreMes(fecha1)+' / '+array_fecha1[2]+' al '+array_fecha2[0]+' de '+NombreMes(fecha2)+' / '+array_fecha2[2];
					} else {
						nombreprog='Del '+array_fecha1[0]+' de '+NombreMes(fecha1)+' / '+array_fecha1[2]+' al '+array_fecha2[0]+' de '+NombreMes(fecha2)+' / '+array_fecha2[2];
					}
				}
			}
		}
	}
	var f1 =  new Date(array_fecha1[2], array_fecha1[1], array_fecha1[0]);
	var f2 =  new Date(array_fecha2[2], array_fecha2[1], array_fecha2[0]);
	var diffec = f2.getTime() -f1.getTime();
	if (diffec<0) {
		nombreprog="Error: La fecha final no puede ser menor que la inicial.";
	}
	document.getElementById("txt_nombre<?php echo $NumWindow; ?>").value=nombreprog;
	document.getElementById("txt_nombre<?php echo $NumWindow; ?>").title=nombreprog;
}

function BuscarMyTrn<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if ((document.getElementById('txt_codtrn<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_codtrn<?php echo $NumWindow; ?>').value=="0")) {
		AbrirForm('application/forms/myturnos.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/myturnos.php', '<?php echo $NumWindow; ?>', '&CodTrn='+document.getElementById('txt_codtrn<?php echo $NumWindow; ?>').value);
	}  
  }
}

function resetea<?php echo $NumWindow; ?>() {
	var data0='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblProgramacion<?php echo $NumWindow; ?>" ><tbody id="tbDetalle<?php echo $NumWindow; ?>">	<tr id="trh<?php echo $NumWindow; ?>">           <th id="th1<?php echo $NumWindow; ?>">Area</td>           <th id="th2<?php echo $NumWindow; ?>">Turno 1</td>           <th id="th3<?php echo $NumWindow; ?>">Empleado</td>           <th id="th4<?php echo $NumWindow; ?>">Turno 2</td>           <th id="th5<?php echo $NumWindow; ?>">Empleado</td>           <th id="th6<?php echo $NumWindow; ?>">X</td>     </tr> </tbody></table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />';	
	InsertarHTML('zero_detalle<?php echo $NumWindow; ?>',data0);
}

</script>