<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$contarow=0;
	$SQL="Select date(now()), time(now());";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
			$FechaActual=$row[0];
			$HoraActual=$row[1];
		}
	mysqli_free_result($result); 	
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" >
<fieldset>
<legend>Empleado:</legend>
<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />

<label for="txt_idempleado<?php echo $NumWindow; ?>">Id.</label><input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" /><a href="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/showhelp.png"  alt="Buscar Empleado" align="absmiddle" title="Buscar Empleado" /></a>
<span id="Empleado<?php echo $NumWindow; ?>" class="nombre"></span>
</fieldset>
<?php  ?>
<fieldset>
  <legend>Marcaciones Recientes:</legend>
  <label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fecha<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fecha<?php echo $NumWindow; ?>" size="10" maxlength="10" value="<?php echo FormatoFecha($FechaActual); ?>">
  <label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
  <input name="txt_hora<?php echo $NumWindow; ?>" type="text" id="txt_hora<?php echo $NumWindow; ?>" size="5" maxlength="5" title="Formato de 24 horas" value="<?php echo $HoraActual; ?>">
<label for="cmb_tipo<?php echo $NumWindow; ?>">Tipo</label>
<select name="cmb_tipo<?php echo $NumWindow; ?>" id="cmb_tipo<?php echo $NumWindow; ?>" >
<?php 
$SQL="Select Codigo_MRC, Nombre_MRC from idtipomarcacion where Estado_MRC='1' order by Codigo_MRC";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>
</select> <a href="javascript:AgregarFilaMarcacion<?php echo $NumWindow; ?>();"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/add.png" alt="Agregar Marcación Manual" align="absmiddle" title="Agregar Marcación Manual" /></a><br />
<hr align="center" width="95%" size="1"  class="anulado" />
 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord" >
<table  width="95%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
      <th id="th1<?php echo $NumWindow; ?>">Fecha</th>
      <th id="th2<?php echo $NumWindow; ?>">Hora</th> 
      <th id="th3<?php echo $NumWindow; ?>">Tipo</th> 
      <th id="th4<?php echo $NumWindow; ?>">Origen Marcación</th>
      <th id="th5<?php echo $NumWindow; ?>">[ - ]</th>
      </tr> 
<?php 
	$SQL="";
	if (isset($_GET["emp"])) {
	$SQL="Select date(Fecha_IDM), time(Fecha_IDM), Case Codigo_USR When '-' Then 'Automático' Else 'Manual' End, Tipo_MRC, Nombre_MRC, b.Codigo_MRC, Codigo_USR From idmarcaciones a, idtipomarcacion b where a.Codigo_MRC=b.Codigo_MRC and Codigo_TER='".$_GET["emp"]."' Order By Fecha_IDM desc Limit 15;";
	}
	if (isset($_GET["idemp"])) {
	$SQL="Select date(Fecha_IDM), time(Fecha_IDM), Case Codigo_USR When '-' Then 'Automático' Else 'Manual' End, Tipo_MRC, Nombre_MRC, b.Codigo_MRC, Codigo_USR From idmarcaciones a, idtipomarcacion b, czterceros c where a.Codigo_MRC=b.Codigo_MRC and c.Codigo_TER=a.Codigo_TER and ID_TER='".$_GET["idemp"]."' Order By Fecha_IDM desc Limit 15;";
	}
	if ($SQL!="") {
	$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		if ($row[3]=="1") {
			$SQL="color-in";
		}else{
			$SQL="color-out";
		}
		if ($row[6]!="-") {
			$Eliminar='<a href="javascript:EliminarFilaOrden(\''.$contarow.'\',\''.$NumWindow.'\');"><img src="'.$_SESSION["NEXUS_CDN"].'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar marcación manual" /></a>';
		} else {
			$Eliminar="";
		}
		echo '  <tr id="tr'.$contarow.$NumWindow.'" >
    <td class="'.$SQL.'"><input name="hdn_fecha'.$contarow.$NumWindow.'" type="hidden" id="hdn_fecha'.$contarow.$NumWindow.'" value="'.FormatoFecha($row[0]).'" />'.FormatoFecha($row[0]).'</td>
    <td class="'.$SQL.'"><input name="hdn_hora'.$contarow.$NumWindow.'" type="hidden" id="hdn_hora'.$contarow.$NumWindow.'" value="'.$row[1].'" />'.$row[1].'</td>
    <td class="'.$SQL.'"><input name="hdn_tipomarca'.$contarow.$NumWindow.'" type="hidden" id="hdn_tipomarca'.$contarow.$NumWindow.'" value="'.$row[5].'" />'.$row[4].'</td>
    <td class="'.$SQL.'"><input name="hdn_usuario'.$contarow.$NumWindow.'" type="hidden" id="hdn_usuario'.$contarow.$NumWindow.'" value="'.$row[6].'" />'.$row[2].'</td>
    <td class="'.$SQL.'">'.$Eliminar.'</td>
  </tr>
';
	}
	mysqli_free_result($result); 
}
?>     
</tbody>
</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
 </div>
 <hr align="center" width="95%" size="1"  class="anulado" />
 <table border="0" align="left" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tbldescr<?php echo $NumWindow; ?>" >
<tbody id="tbDescr<?php echo $NumWindow; ?>">
<tr id="t_h<?php echo $NumWindow; ?>"> 
      <th id="t_1<?php echo $NumWindow; ?>">Color
      <th id="t_2<?php echo $NumWindow; ?>">Orientación</td>      
</tr>
<tr>
  <td class="color-in">  
  <td >Entrada  
</tr>
<tr>
  <td class="color-out">  
  <td >Salida  
</tr> 
</tbody>
</table>
</fieldset>
</form>
<script >
<?php
if (isset($_GET["emp"])) {
$SQL="Select ID_TER, Nombre_TER from czterceros Where Codigo_TER='".$_GET["emp"]."';";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_array($result)) {
echo "
	document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$_GET["emp"]."';
	document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$row["ID_TER"]."';
	document.getElementById('Empleado".$NumWindow."').innerHTML='".$row["Nombre_TER"]."';
	";
}
mysqli_free_result($result); 
}
if (isset($_GET["idemp"])) {
$SQL="Select ID_TER, Nombre_TER, Codigo_TER from czterceros Where ID_TER='".$_GET["idemp"]."';";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_array($result)) {
echo "
	document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$row["Codigo_TER"]."';
	document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$row["ID_TER"]."';
	document.getElementById('Empleado".$NumWindow."').innerHTML='".$row["Nombre_TER"]."';
	";
}
mysqli_free_result($result); 
}
echo "document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".focus();";
?>

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/marcacionesid.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/marcacionesid.php', '<?php echo $NumWindow; ?>', '&idemp='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value);
	}  
  }
}

function AgregarFilaMarcacion<?php echo $NumWindow; ?>()  {

	xError="";
	if (document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value=="") {
		xError="Digite la fecha de marcación.";}
	if (document.frm_form<?php echo $NumWindow; ?>.txt_hora<?php echo $NumWindow; ?>.value=="") {
		xError="Digite la hora de marcacion.";}
	if (document.frm_form<?php echo $NumWindow; ?>.txt_idempleado<?php echo $NumWindow; ?>.value=="") {
		xError="Digite el documento del empleado en el campo 'Id'.";}
	
	if (xError=="") {
	
	<?php
		$SQL="Select Codigo_MRC, Nombre_MRC, Case Tipo_MRC When '1' Then 'color-in' Else 'color-out' End from idtipomarcacion where Estado_MRC='1' order by Codigo_MRC";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
			{
				echo '
	if (document.frm_form'.$NumWindow.'.cmb_tipo'.$NumWindow.'.value=="'.$row[0].'") {				
		CodTipo="'.$row[0].'";
		NomTipo="'.$row[1].'";
		Estilacho="'.$row[2].'";
	}
				';
			}
		mysqli_free_result($result); 
	?>

    var miTabla = document.getElementById("tbDetalle<?php echo $NumWindow; ?>"); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda3 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
    var celda5 = document.createElement("td"); 
	TotalFilas=document.frm_form<?php echo $NumWindow; ?>.hdn_controw<?php echo $NumWindow; ?>.value;
	TotalFilas++;
	fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
    celda1.innerHTML = '<input name="hdn_fecha'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_fecha'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value+''+'" />'+document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value; 
    celda2.innerHTML = '<input name="hdn_hora'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_hora'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+document.frm_form<?php echo $NumWindow; ?>.txt_hora<?php echo $NumWindow; ?>.value+''+'" />'+document.frm_form<?php echo $NumWindow; ?>.txt_hora<?php echo $NumWindow; ?>.value; 
    celda3.innerHTML = '<input name="hdn_tipomarca'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_tipomarca'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodTipo+''+'" />'+NomTipo; 
    celda4.innerHTML = '<input name="hdn_usuario'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_usuario'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+<?php echo $_SESSION["it_CodigoUSR"]; ?>+'" />Manual'; 
    celda5.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\'<?php echo $NumWindow; ?>\');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar marcación manual" /></a>'; 
	celda1.className=Estilacho;
	celda2.className=Estilacho;
	celda3.className=Estilacho;
	celda4.className=Estilacho;
	celda5.className=Estilacho;
    fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda3); 
    fila.appendChild(celda4); 
    fila.appendChild(celda5); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
	document.getElementById("txt_fecha<?php echo $NumWindow; ?>").value="";
	document.getElementById("txt_hora<?php echo $NumWindow; ?>").value="";
	document.getElementById("txt_fecha<?php echo $NumWindow; ?>").focus();
	
	} else {
		MsgBox1("Error", '<div class="message_alert"></div>'+xError);
	}
} 

</script>