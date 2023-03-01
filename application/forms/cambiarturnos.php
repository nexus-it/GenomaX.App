<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" onreset="resetea<?php echo $NumWindow; ?>()">
<fieldset>
<legend>Periodo:</legend>
<label for="cmb_mes<?php echo $NumWindow; ?>">Mes </label>
<select name="cmb_mes<?php echo $NumWindow; ?>" id="cmb_mes<?php echo $NumWindow; ?>">
  <option value="01"<?php if (date("m")=='01') echo ' selected="selected"'; ?>>ENERO</option>
  <option value="02"<?php if (date("m")=='02') echo ' selected="selected"'; ?>>FEBRERO</option>
  <option value="03"<?php if (date("m")=='03') echo ' selected="selected"'; ?>>MARZO</option>
  <option value="04"<?php if (date("m")=='04') echo ' selected="selected"'; ?>>ABRIL</option>
  <option value="05"<?php if (date("m")=='05') echo ' selected="selected"'; ?>>MAYO</option>
  <option value="06"<?php if (date("m")=='06') echo ' selected="selected"'; ?>>JUNIO</option>
  <option value="07"<?php if (date("m")=='07') echo ' selected="selected"'; ?>>JULIO</option>
  <option value="08"<?php if (date("m")=='08') echo ' selected="selected"'; ?>>AGOSTO</option>
  <option value="09"<?php if (date("m")=='09') echo ' selected="selected"'; ?>>SEPTIEMBRE</option>
  <option value="10"<?php if (date("m")=='10') echo ' selected="selected"'; ?>>OCTUBRE</option>
  <option value="11"<?php if (date("m")=='11') echo ' selected="selected"'; ?>>NOVIEMBRE</option>
  <option value="12"<?php if (date("m")=='12') echo ' selected="selected"'; ?>>DICIEMBRE</option>
</select>
<label for="cmb_quincena<?php echo $NumWindow; ?>">Quincena </label>
<select name="cmb_quincena<?php echo $NumWindow; ?>" id="cmb_quincena<?php echo $NumWindow; ?>">
<option value="1">1: PRIMERA</option>
<option value="2">2: SEGUNDA</option>
</select>
<label for="txt_anyo<?php echo $NumWindow; ?>">Año </label>
<input name="txt_anyo<?php echo $NumWindow; ?>" type="text" id="txt_anyo<?php echo $NumWindow; ?>" value="<?php echo date("Y"); ?>" size="4" maxlength="4" /> 
</fieldset>

<fieldset>
<legend>Datos Empleado:</legend>
<label for="txt_idempleado1<?php echo $NumWindow; ?>">Nombre</label>
<input name="txt_idempleado1<?php echo $NumWindow; ?>" id="txt_idempleado1<?php echo $NumWindow; ?>" type="text" size="35"  onkeypress="ActualizarEmple<?php echo $NumWindow; ?>('Null');"/>
<input type="hidden" id="hdn_idtercero1<?php echo $NumWindow; ?>" name="hdn_idtercero1<?php echo $NumWindow; ?>"/>

<div id="Dat_horas<?php echo $NumWindow; ?>" class="tblDetalle1">


</div>
</fieldset>
</form>
<script type="text/javascript" src="functions/js/jquery/a.jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="functions/js/jquery/b.jquery-ui-1.8.6.custom.min.js"></script>
<script >

$(function() 
{
	// configuramos el control para realizar la busqueda de los productos
	$("#txt_idempleado1<?php echo $NumWindow; ?>").autocomplete({
		source: "functions/php/nexus/autocomplete.php?type=emple", 				/* este es el formulario que realiza la busqueda */
		minLength: 2,									/* le decimos que espere hasta que haya 2 caracteres escritos */
		select: function( event, ui ) {
	        var producto = ui.item.value;
			ActualizarEmple<?php echo $NumWindow; ?>('Null');
			$("#hdn_idtercero1<?php echo $NumWindow; ?>").val(producto.valor);
			$("#txt_idempleado1<?php echo $NumWindow; ?>").val(producto.descripcion);
			ActualizarEmple<?php echo $NumWindow; ?>(producto.id);
	        return false;
	    },
		focus: function( event, ui ) {
			var producto = ui.item.value;
			$("#txt_idempleado1<?php echo $NumWindow; ?>").val(producto.descripcion);
			ActualizarEmple<?php echo $NumWindow; ?>('Null');
			return false;
		}
	});
});

function LoadMyTrn<?php echo $NumWindow; ?>(CdgTrn) {
	$.get(Funciones,{'Func':'MyTurnos', 'Cod':CdgTrn, 'Ventana':'<?php echo $NumWindow; ?>', 'Tema':'<?php echo $_SESSION["THEME_DEFAULT"]; ?>'},function(data){
		InsertarHTML('zero_detalle<?php echo $NumWindow; ?>',data);
	});
}

function ActualizarEmple<?php echo $NumWindow; ?>(cedula) {
	var Datos="";
	if (cedula=="Null") {
		InsertarHTML('Dat_horas<?php echo $NumWindow; ?>','Seleccione un empleado válido...');
	} else {
<?php 
$SQL="Select Codigo_ARE, Nombre_ARE from czareas Where Estado_ARE='1' order by Nombre_ARE";
$result = mysqli_query($conexion, $SQL);
$SQL="";
while($row = mysqli_fetch_array($result)) 
	{
	$SQL=$SQL.'<option value="'.$row[0].'">'.$row[1].'</option>';
	}
mysqli_free_result($result); 
?>  
 	Datos='<label for="txt_cedula<?php echo $NumWindow; ?>"> Cédula</label> <input name="txt_cedula<?php echo $NumWindow; ?>" type="text" id="txt_cedula<?php echo $NumWindow; ?>" value="'+cedula+'" size="15" readonly="readonly" /> <label for="cmb_area<?php echo $NumWindow; ?>">Area</label><select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>" ><?php echo $SQL; ?></select> <hr align="center" width="90%" noshade="noshade" class="anulado" /><table  width="60%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblProgramacion<?php echo $NumWindow; ?>" ><tbody id="tbDetalle<?php echo $NumWindow; ?>"><tr id="trh<?php echo $NumWindow; ?>"> <th id="th1<?php echo $NumWindow; ?>">DIA</th> <th id="th2<?php echo $NumWindow; ?>">PROGRAMADO</th> <th id="th3<?php echo $NumWindow; ?>">LABORADO</th> <th id="th3<?php echo $NumWindow; ?>">NUEVO HORARIO</th> </tr> ';
	
	iMes=document.getElementById("cmb_mes<?php echo $NumWindow; ?>").value;
	iQuin=document.getElementById("cmb_quincena<?php echo $NumWindow; ?>").value;
	iAnyo=document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value;
	iEmple=document.getElementById("hdn_idtercero1<?php echo $NumWindow; ?>").value;
	
	$.get(Funciones,{'Func':'UpdQuincena', 'Mes':iMes, 'Quincena':iQuin, 'Anyo':iAnyo, 'Emple':iEmple, 'Ventana':'<?php echo $NumWindow; ?>', 'Tema':'<?php echo $_SESSION["THEME_DEFAULT"]; ?>'},function(data){
		Datos=Datos+data+'</tbody></table><br>';
		InsertarHTML('Dat_horas<?php echo $NumWindow; ?>',Datos);
	});
	 
	
	}
}

</script>