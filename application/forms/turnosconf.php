<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$contarow=0;
	$elanyo = date("Y");
	$elmes = date("m");	
	if (isset($_GET["elmes"])) { $elmes=$_GET["elmes"];	}
	if (isset($_GET["elanyo"])) { $elanyo=$_GET["elanyo"];	}
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" ><fieldset>
<legend>Configuración de Turnos:</legend>
	<?php
	if (isset($_GET["codigo"])) 
	{
		$SQL="Select Estado_TRN, Nombre_TRN, Inicia_TRN, Termina_TRN, TotalHoras_TRN, Descanso_TRN From cztipoturnos Where Codigo_TRN='".$_GET["codigo"]."'";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
			$Existe=1;
		}
	}
	?>  
    <label for="txt_codigo<?php echo $NumWindow; ?>">Código:</label>
    <input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" value="<?php
	  if (isset($_GET["codigo"])) {
	  	echo $_GET["codigo"];
	  }
	  ?>" size="3" onkeypress="BuscarCod<?php echo $NumWindow; ?>(event);"/>
    <label for="txt_nombre<?php echo $NumWindow; ?>">Nombre:</label>
      <input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" value="<?php
	  if ($Existe==1) {
	  	echo $row[1];
	  }
	  ?>" size="20" />
      <br />
      <label for="txt_horaini<?php echo $NumWindow; ?>">Hora Inicial:</label>
      <input name="txt_horaini<?php echo $NumWindow; ?>" type="text"  id="txt_horaini<?php echo $NumWindow; ?>" value="<?php
	  if ($Existe==1) {
	  	echo $row[2];
	  }
	  ?>" size="5" maxlength="5" title="Formato HH:MM"/>
      <label for="txt_horafin<?php echo $NumWindow; ?>">Hora Final:</label>
      <input name="txt_horafin<?php echo $NumWindow; ?>" type="text" id="txt_horafin<?php echo $NumWindow; ?>" value="<?php
	  if ($Existe==1) {
	  	echo $row[3];
	  }
	  ?>" size="5" maxlength="5" title="Formato HH:MM"/>
      <br />
      <label for="txt_horas<?php echo $NumWindow; ?>">Total Horas:</label>
      <input name="txt_horas<?php echo $NumWindow; ?>" type="text" id="txt_horas<?php echo $NumWindow; ?>" value="<?php
	  if ($Existe==1) {
	  	echo $row[4];
	  }
	  ?>" size="5" maxlength="5" />
      <label for="txt_descanso<?php echo $NumWindow; ?>">Descanso:</label>
      <input name="txt_descanso<?php echo $NumWindow; ?>" type="text" id="txt_descanso<?php echo $NumWindow; ?>" value="<?php if ($Existe==1) { echo $row[5]; } else { echo '0'; } ?>" size="5" maxlength="5" />
	<label for="cmb_estado<?php echo $NumWindow; ?>">Estado:</label>
    <select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
     <option value="1" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="1") echo 'selected="selected" ';
	  }
	  ?>>Activo</option>
      <option value="0" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="0") echo 'selected="selected" ';
	  }
	  ?>>Inactivo</option>
    </select>  
	<?php
	if (isset($_GET["codigo"])) 
	{
		mysqli_free_result($result); 
	}
	?>
</fieldset> 
<?php  ?>
 <fieldset>
<legend>Turnos Existentes:</legend>
<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
          <th id="th1<?php echo $NumWindow; ?>">Codigo</td> 
          <th id="th2<?php echo $NumWindow; ?>">Nombre</td> 
          <th id="th3<?php echo $NumWindow; ?>">Hora Inicial</td> 
          <th id="th4<?php echo $NumWindow; ?>">Hora Final</td> 
          <th id="th5<?php echo $NumWindow; ?>">Total Horas</td> 
          <th id="th6<?php echo $NumWindow; ?>">Descanso</td> 
          <th id="th7<?php echo $NumWindow; ?>">Estado</td> 
     </tr> 
<?php 
	$SQL="Select Codigo_TRN, Nombre_TRN, Inicia_TRN, Termina_TRN, TotalHoras_TRN, descanso_TRN, Case Estado_TRN When '1' Then 'Activo' Else 'Inactivo' End From cztipoturnos Where Estado_TRN<>'T' Order By Inicia_TRN, Termina_TRN";
	$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		echo '  <tr id="tr'.$contarow.$NumWindow.'" onclick="javascript:AbrirForm(\'application/forms/turnosconf.php\', \''.$NumWindow.'\', \'&codigo='.$row[0].'\');">
    <td>'.$row[0].'</td>
    <td>'.$row[1].'</td>
    <td align="center">'.$row[2].'</td>
    <td align="center">'.$row[3].'</td>
    <td align="center">'.$row[4].'</td>
    <td align="center">'.$row[5].'</td>
    <td >'.$row[6].'</td>
  </tr>
';
	}
	mysqli_free_result($result); 
?>     
</tbody>
</table>
</fieldset>
</form>
<script >
$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();

function Guardar_turnosconf(Ventana)
{
xError="";
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Digite el código del turno.";}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre del turno.";}
	if (document.getElementById('txt_horaini'+Ventana).value=="") {
		xError="Digite la hora inicial del turno.";}
	if (document.getElementById('txt_horafin'+Ventana).value=="") {
		xError="Digite la hora final del turno.";}
	if (document.getElementById('txt_horas'+Ventana).value=="") {
		xError="Digite el total de horas correspondientes al turno.";}
	if (document.getElementById('txt_descanso'+Ventana).value=="") {
		xError="Digite el tiempo de descanso del turno.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
	  $.ajax({ 
	  type: "POST", 
	  url: Transac, 
	  data: "Func=turnosconf&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Configuración de Turnos", respuesta); 
		AbrirForm('application/forms/turnosconf.php', '<?php echo $NumWindow; ?>', '');
	  }  
	});  
	  return false;  
	} else {
		MsgBox1("Error", '<div class="message_alert"></div>'+xError);
	}
}
function BuscarCod<?php echo $NumWindow; ?>(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==13){
		AbrirForm('application/forms/turnosconf.php', '<?php echo $NumWindow; ?>', '&codigo='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	  }
}
</script>