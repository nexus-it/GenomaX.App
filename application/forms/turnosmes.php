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
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" onreset="Recargarfrm<?php echo $NumWindow; ?>()">
<fieldset>
<legend>Programación de Turnos:</legend>
<input type="hidden" name="hdn_paso<?php echo $NumWindow; ?>" id="hdn_paso<?php echo $NumWindow; ?>" value="1"/>
<label for="cmb_areas<?php echo $NumWindow; ?>">Area</label>
 <select name="cmb_areas<?php echo $NumWindow; ?>" id="cmb_areas<?php echo $NumWindow; ?>" onchange="cambioarea<?php echo $NumWindow; ?>()">
<?php 
$SQL="Select distinct a.Codigo_ARE, Nombre_ARE from czareas a, czareasterceros b Where a.Codigo_ARE=b.Codigo_ARE and Estado_ARE='1' order by Nombre_ARE";
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
 <label for="txt_responsable<?php echo $NumWindow; ?>">Responsable</label>
 <input name="txt_responsable<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_responsable<?php echo $NumWindow; ?>" size="40" readonly="readonly" /><br />
<label for="cmb_contrato<?php echo $NumWindow; ?>">Contrato</label>
  <select name="cmb_contrato<?php echo $NumWindow; ?>" id="cmb_contrato<?php echo $NumWindow; ?>" >
 </select> 
 <br>
  <label for="cmb_mes<?php echo $NumWindow; ?>">Mes </label>
<select name="cmb_mes<?php echo $NumWindow; ?>" id="cmb_mes<?php echo $NumWindow; ?>">
  <option value="01"<?php if (date("m")=='12') echo ' selected="selected"'; ?>>ENERO</option>
  <option value="02"<?php if (date("m")=='01') echo ' selected="selected"'; ?>>FEBRERO</option>
  <option value="03"<?php if (date("m")=='02') echo ' selected="selected"'; ?>>MARZO</option>
  <option value="04"<?php if (date("m")=='03') echo ' selected="selected"'; ?>>ABRIL</option>
  <option value="05"<?php if (date("m")=='04') echo ' selected="selected"'; ?>>MAYO</option>
  <option value="06"<?php if (date("m")=='05') echo ' selected="selected"'; ?>>JUNIO</option>
  <option value="07"<?php if (date("m")=='06') echo ' selected="selected"'; ?>>JULIO</option>
  <option value="08"<?php if (date("m")=='07') echo ' selected="selected"'; ?>>AGOSTO</option>
  <option value="09"<?php if (date("m")=='08') echo ' selected="selected"'; ?>>SEPTIEMBRE</option>
  <option value="10"<?php if (date("m")=='09') echo ' selected="selected"'; ?>>OCTUBRE</option>
  <option value="11"<?php if (date("m")=='10') echo ' selected="selected"'; ?>>NOVIEMBRE</option>
  <option value="12"<?php if (date("m")=='11') echo ' selected="selected"'; ?>>DICIEMBRE</option>
</select>
<?php
	if (date("m")=='12') {
		$Anyo= date("Y")+1;
	} else {
		$Anyo= date("Y");
	}
?>
<label for="txt_anyo<?php echo $NumWindow; ?>">Año </label>
<input name="txt_anyo<?php echo $NumWindow; ?>" type="text" id="txt_anyo<?php echo $NumWindow; ?>" value="<?php echo $Anyo; ?>" size="4" maxlength="4" /> 
<a href="javascript:CargarHorario<?php echo $NumWindow; ?>();"> <img id="img_tabla<?php echo $NumWindow; ?>" src="http://cdn.genomax.co/media/image/table_import.png"  alt="Cargar Horario" align="absmiddle" title="Cargar Horario" /></a>
</fieldset>
<fieldset>
<legend>Horario Mes:</legend>
<div id="destino<?php echo $NumWindow; ?>">
<input type="hidden" name="hdn_conta<?php echo $NumWindow; ?>" id="hdn_conta<?php echo $NumWindow; ?>" value="0"/>
<input type="hidden" name="hdn_printear<?php echo $NumWindow; ?>" id="hdn_printear<?php echo $NumWindow; ?>" value="0"/>
</div>
</fieldset>
</form>
<script >
cambioarea<?php echo $NumWindow; ?>();

function cambioarea<?php echo $NumWindow; ?>() {
switch (document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value) { 
<?php 
$SQL="Select a.Codigo_ARE, Nombre_TER from czareas a, czterceros b, czareasterceros c Where a.Codigo_ARE=c.Codigo_ARE and a.Codigo_TER=b.Codigo_TER and Estado_ARE='1' order by 1";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) {
 ?>
	case '<?php echo $row[0]; ?>': 
		document.frm_form<?php echo $NumWindow; ?>.txt_responsable<?php echo $NumWindow; ?>.value='<?php echo $row[1]; ?>'; 
	break; 
<?php
}
mysqli_free_result($result); 
 ?>  
   default : 
       document.frm_form<?php echo $NumWindow; ?>.txt_responsable<?php echo $NumWindow; ?>.value='';  
	}
	cambioempresa<?php echo $NumWindow; ?>();
}

function cambioempresa<?php echo $NumWindow; ?>() {
	var combito1=document.frm_form<?php echo $NumWindow; ?>.cmb_contrato<?php echo $NumWindow; ?>;
	combito1.options.length=0;
	switch (document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value) { 
<?php 
$SQL="Select distinct C.Codigo_ARE, A.Codigo_TCL, A.Nombre_TCL From cztipocontratos A, czempleados B, czareasterceros C Where A.Codigo_TCL=B.Codigo_TCL and C.Codigo_TER=B.Codigo_TER and A.Estado_TCL='1' Order By 1, 2";
$result = mysqli_query($conexion, $SQL);
$CodARE="";
echo '
	case "--":
';
while($row = mysqli_fetch_array($result)) {
	if ($CodARE!=$row[0]) {
		echo '
	break; 
	case "'.$row[0].'":
';
	}
	$CodARE=$row[0];
 ?>
	combito1.options[combito1.options.length]=new Option('<?php echo $row[2]; ?>', '<?php echo $row[1]; ?>', false, false); 
<?php
}
mysqli_free_result($result); 
 ?>break;
   default : 
       
	}
}

function CargarHorario<?php echo $NumWindow; ?>() {
	var val = document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value;
    if (!/^([0-9])*$/.test(val)) document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value = '';
    xError="";
	if ((document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value=="")||(document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value<="") ){
		xError="Verifique el año de la programación.";}
	
	if (xError=="") {
		<?php
		 $NoVent= substr($NumWindow, (strlen($NumWindow)-strpos($NumWindow, "_"))*(-1));
		 $NoVent1= substr($NumWindow, (strlen($NumWindow)-strpos($NumWindow, "_")-1)*(-1));
		?>
		$.get(Funciones,{'Func':'CargarHorario','ventana':'<?php echo $NumWindow; ?>', 'area':document.getElementById("cmb_areas<?php echo $NumWindow; ?>").value, 'contrato':document.getElementById("cmb_contrato<?php echo $NumWindow; ?>").value, 'mes':document.getElementById("cmb_mes<?php echo $NumWindow; ?>").value, 'anyo':document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value},function(data){ 
			document.getElementById('destino<?php echo $NumWindow; ?>').innerHTML=data;
			if (document.getElementById("hdn_printear<?php echo $NumWindow; ?>").value=='1') {
				document.getElementById('print<?php echo $NumWindow; ?>').innerHTML='<a href="javascript:Imprimir_turnosmes(\'<?php echo $NoVent1; ?>\');"><img id="img_print<?php echo $NumWindow; ?>" src="http://cdn.genomax.co/media/image/button_print.png"  alt="Vista Previa Impresión" align="absmiddle" title="Vista Previa Impresión" /></a>';
				document.getElementById("Imprimir<?php echo $NoVent1; ?>").style.display  = 'inline';
			}else{
				document.getElementById("Imprimir<?php echo $NoVent1; ?>").style.display  = 'none';
			}
		})
		WindAct = document.getElementById("Window<?php echo $NoVent; ?>").style;
		if (100*WindAct.width/screen.width<=60) {
			document.getElementById("Window<?php echo $NoVent; ?>").style.width="75%";
		}
		document.getElementById("cmb_areas<?php echo $NumWindow; ?>").disabled=true;
		document.getElementById("cmb_contrato<?php echo $NumWindow; ?>").disabled=true;
		document.getElementById("cmb_mes<?php echo $NumWindow; ?>").disabled=true;
		document.getElementById("txt_anyo<?php echo $NumWindow; ?>").disabled=true;
		document.getElementById("img_tabla<?php echo $NumWindow; ?>").hidden=true;
	} else {
		MsgBox1("Programación de turnos", '<div class="message_alert"></div>ERROR: '+xError);
	}
}

function Recargarfrm<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/turnosmes.php', '<?php echo $NumWindow; ?>', '');
}

function PrintHorario<?php echo $NumWindow; ?>() {
	Anyop=document.getElementById("txt_anyo<?php echo $NumWindow; ?>").value;	
	Mesp=document.getElementById("cmb_mes<?php echo $NumWindow; ?>").value;
	Contratop=document.getElementById("cmb_contrato<?php echo $NumWindow; ?>").value;
	Areap=document.getElementById("cmb_areas<?php echo $NumWindow; ?>").value;
	CargarReport("application/reports/turnosmes.php?CODIGO_AREA="+Areap+"&CODIGO_CONTRATO="+Contratop+"&CODIGO_MES="+Mesp+"&CODIGO_ANYO="+Anyop, "Turnos Mes");
}

</script>