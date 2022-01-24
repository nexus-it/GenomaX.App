<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
<div class="row well well-sm">
<div class="col-md-1">

	<div class="form-group">
      <label for="txt_radicacion<?php echo $NumWindow; ?>">Radicaci&oacute;n No.</label>
 	<div class="input-group">
 		<input name="txt_radicacion<?php echo $NumWindow; ?>" type="text" id="txt_radicacion<?php echo $NumWindow; ?>"  maxlength="10" onkeypress="BuscarRad<?php echo $NumWindow; ?>(event);" required="required" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="radicaciones" onclick="javascript:CargarSearch('radicaciones', 'txt_radicacion<?php echo $NumWindow; ?>', 'Estado_RAD=*1*');;"><i class="fas fa-search"></i></button>
		</span>
	</div>
	</div>	

</div>
<div class="col-md-2">

	<div class="form-group">	
	<label for="txt_fecrad<?php echo $NumWindow; ?>">Fecha Conf.</label>
	  <input name="txt_fecrad<?php echo $NumWindow; ?>" type="date"  id="txt_fecrad<?php echo $NumWindow; ?>" required="required">
	</div>

</div>
<div class="col-md-2">

	<div class="form-group">	
	<label for="txt_numrad<?php echo $NumWindow; ?>">Radicado Entidad</label>
	  <input name="txt_numrad<?php echo $NumWindow; ?>" type="text"  id="txt_numrad<?php echo $NumWindow; ?>" required="required">
	</div>

</div>
<div class="col-md-1">

	<div class="form-group">	
	<label for="txt_fecenv<?php echo $NumWindow; ?>">Fecha envío</label>
	  <input name="txt_fecenv<?php echo $NumWindow; ?>" type="text"  id="txt_fecenv<?php echo $NumWindow; ?>" disabled="disabled">
	</div>

</div>
<div class="col-md-2">
	 
	 <div class="form-group">
		<label for="txt_NombreEPS<?php echo $NumWindow; ?>">Contrato</label>
		<input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
	 </div>

</div>
<div class="col-md-2">

	<div class="form-group">
		<label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
		<select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>" disabled="disabled" style="font-size:15px; font-weight: bold; color:#0E5012; ">
		</select>
	</div>
	
</div>
<div class="col-md-1">

	<div class="form-group">
	<label for="txt_fecini<?php echo $NumWindow; ?>">Fecha Inicial</label>
	<input name="txt_fecini<?php echo $NumWindow; ?>" type="text" id="txt_fecini<?php echo $NumWindow; ?>" disabled="disabled"/>
	</div>

</div>
<div class="col-md-1">

	<div class="form-group">
	<label for="txt_fecfin<?php echo $NumWindow; ?>">Fecha Final </label>
	 <input name="txt_fecfin<?php echo $NumWindow; ?>" type="text" id="txt_fecfin<?php echo $NumWindow; ?>" disabled="disabled"/> 
	</div>
	 
</div>

</div>
<div class="row well well-sm">

<div class="col-md-12">

	 <div align="right">Selecci&oacute;n: <a href="javascript:radicarAll<?php echo $NumWindow; ?>('None');">
	<img src="http://cdn.genomax.co/media/image/checkedboxno.png" alt="Quitar Seleccion" align="absmiddle" title="Quitar Seleccion" longdesc="Quitar Seleccion" /></a> 
	 <a href="javascript:radicarAll<?php echo $NumWindow; ?>('All');">
	<img src="http://cdn.genomax.co/media/image/checkedbox.png" alt="Seleccionar Todas" align="absmiddle" title="Seleccionar Todas" longdesc="Seleccionar Todas" /></a> </div>

	 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord" ><span id="factrad<?php echo $NumWindow; ?>">
	<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
	<tbody id="tbDetalle<?php echo $NumWindow; ?>">
	<tr id="trh<?php echo $NumWindow; ?>"> 
	          <th id="th1<?php echo $NumWindow; ?>">Factura</th> 
	          <th id="th2<?php echo $NumWindow; ?>">Plan</th> 
	          <th id="th3<?php echo $NumWindow; ?>">Documento</th> 
	          <th id="th3<?php echo $NumWindow; ?>">Paciente</th>    
	          <th id="th3<?php echo $NumWindow; ?>">Valor</th>  
	        <th id="th4<?php echo $NumWindow; ?>">[::]</th>
	</tr>
	<?php 
	$elTotal=0;
		if (isset($_GET["Rad"])) {
		$SQL="Select a.Codigo_FAC, d.Nombre_PLA, concat(e.Sigla_TID,' ', c.ID_TER), c.Nombre_TER, a.ValTotal_FAC, '1' 
	From gxfacturas as a, gxadmision as b, czterceros as c, gxplanes as d, cztipoid as e, czradicacionescab as f, czradicacionesdet as g  
	Where a.Codigo_ADM=b.Codigo_ADM and b.Codigo_TER=c.Codigo_TER and a.Codigo_PLA=d.Codigo_PLA and c.Codigo_TID=e.Codigo_TID 
	and a.Estado_FAC='1' and a.Fecha_FAC >=f.FechaIni_RAD and a.Fecha_FAC<=f.FechaFin_RAD and f.Codigo_RAD=g.Codigo_RAD and trim(a.Codigo_FAC)=trim(g.Codigo_FAC) 
	and a.Codigo_EPS=f.Codigo_EPS and f.Estado_RAD='1' and LPAD(f.Codigo_RAD,10,'0')=LPAD(".$_GET["Rad"].",10,'0')
		UNION 
	Select g.Codigo_FAC, concat(e.FechaIni_FAC, ' - ', e.FechaFin_FAC), e.Servicio_FAC, DATE_FORMAT(g.Fecha_FAC, '%d/%m/%Y'), g.ValEntidad_FAC , '1'
From czradicacionesdet as w, gxfacturas as g, gxfacturascapita as e 
Where  trim(w.Codigo_FAC)=trim(g.Codigo_FAC) and trim(g.Codigo_FAC)=trim(e.Codigo_FAC) and 
LPAD(w.Codigo_RAD,10,'0')=LPAD(".$_GET["Rad"].",10,'0') 
	Order by 6 desc,1 asc";
		$result = mysqli_query($conexion, $SQL);
		$elTotal=0;
		$CantFact=0;
		//echo $SQL;
		while($row = mysqli_fetch_array($result)) {
			$contarow++;
			echo '  <tr >
	  <td align="center" ><input name="hdn_factura'.$contarow.$NumWindow.'" type="hidden" id="hdn_factura'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[0].'</td>
	  <td >'.$row["Nombre_PLA"].'</td>
	  <td >'.$row[2].'</td>
	  <td >'.$row[3].'</td>
	  <td align="right" ><input name="hdn_valor'.$contarow.$NumWindow.'" type="hidden" id="hdn_valor'.$contarow.$NumWindow.'" value="'.$row[4].'" />'.number_format($row[4], 2, ",", ".").'</td>
	  <td align="center" >
	  <div class="checkbox checkbox-success">
	  <input name="chk_radicarok'.$contarow.$NumWindow.'" id="chk_radicarok'.$contarow.$NumWindow.'" type="checkbox" value="" ';
	  if ($row[5]=='1') {
	  	echo ' checked="checked" ';
		$elTotal=$elTotal+$row[4];
		$CantFact=$CantFact+1;
	  }
	  echo ' onclick="javascript:totalrad'.$NumWindow.'();" class="styled" /><label for="chk_radicarok'.$contarow.$NumWindow.'"></label>
	  </div>
	  <input name="hdn_radicar'.$contarow.$NumWindow.'" type="hidden" id="hdn_radicar'.$contarow.$NumWindow.'" value="'.$row[5].'" />

	  </td>
	</tr> 
	';
		}
		mysqli_free_result($result); 
	}
	?>     
	</tbody>
	</table>
	<input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
	</span>
	 </div>

</div>
<div class="col-md-6 text-left">
			<label for="txt_cantidad<?php echo $NumWindow; ?>"> Cantidad Seleccionada </label>
			<input name="txt_cantidad<?php echo $NumWindow; ?>" id="txt_cantidad<?php echo $NumWindow; ?>" type="text" value="<?php echo $CantFact; ?>" class="izq" size="15" disabled="disabled" style="font-size:15px; font-weight: bold; color:#0E5012; " /><input name="hdn_total<?php echo $NumWindow; ?>" type="hidden" id="hdn_total<?php echo $NumWindow; ?>" value="<?php echo $elTotal; ?>" />
</div>
<div class="col-md-6 text-right">
			<label for="txt_total<?php echo $NumWindow; ?>"> Total Radicaci&oacute;n </label>
			<input name="txt_total<?php echo $NumWindow; ?>" id="txt_total<?php echo $NumWindow; ?>" type="text" value="<?php echo number_format($elTotal, 2, ",", "."); ?>" class="izq" size="15" disabled="disabled" style="font-size:15px; font-weight: bold; color:#0E5012; " /><input name="hdn_total<?php echo $NumWindow; ?>" type="hidden" id="hdn_total<?php echo $NumWindow; ?>" value="<?php echo $elTotal; ?>" />
</div>
	</div>
	<div id="recalcular<?php echo $NumWindow; ?>" style="font-style:italic">Recalculando valores...</div>

</form>
<script >
<?php
	echo "FechaActual('txt_fecrad".$NumWindow."');
	";
?>

var el = document.getElementById('recalcular<?php echo $NumWindow; ?>'); 
el.style.display = 'none';

function BuscarRad<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  	if ((document.getElementById('txt_radicacion<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_radicacion<?php echo $NumWindow; ?>').value=="0000000000")) {
			MsgBox1('Radicaci&oacute;n de Cuentas','Digite el número del envío radicado.');
	} else {
		AbrirForm('application/forms/radicacionesconf.php', '<?php echo $NumWindow; ?>', '&Rad='+document.getElementById('txt_radicacion<?php echo $NumWindow; ?>').value);
	}
  }
}

function BuscarContrato<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  CargarPlanR('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  document.frm_form<?php echo $NumWindow; ?>.txt_fecini<?php echo $NumWindow; ?>.focus();
  }
}

function totalrad<?php echo $NumWindow; ?>() {
	var el = document.getElementById('recalcular<?php echo $NumWindow; ?>'); 
	el.style.display = 'block';
	total =0;
	cantirad=0;
	for (i=1;i<=hdn_controw<?php echo $NumWindow; ?>.value;i++) {
	 	cuadro=document.getElementById('chk_radicarok'+i+'<?php echo $NumWindow; ?>');
		cuadro2=document.getElementById('hdn_radicar'+i+'<?php echo $NumWindow; ?>');
		valor=document.getElementById('hdn_valor'+i+'<?php echo $NumWindow; ?>').value;
		valor=parseFloat(valor.toString().replace(/\$|\,/g,''));
		if (cuadro.checked) {
			cuadro2.value='1';
			total= total+valor;
			cantirad=cantirad+1;
		}
		else {
			cuadro2.value='0';
		}
	}
	el.style.display = 'none';
	document.getElementById('txt_cantidad<?php echo $NumWindow; ?>').value=cantirad;
	document.getElementById('hdn_total<?php echo $NumWindow; ?>').value=total;
	document.getElementById('txt_total<?php echo $NumWindow; ?>').value=formatCurrency(total);
}

function radicarAll<?php echo $NumWindow; ?>(Mode) {
	var el = document.getElementById('recalcular<?php echo $NumWindow; ?>'); 
	el.style.display = 'block';
	if (Mode=='All') {
		for (i=1;i<=hdn_controw<?php echo $NumWindow; ?>.value;i++) {
			document.getElementById('chk_radicarok'+i+'<?php echo $NumWindow; ?>').checked=1; 
		}
	} else {
		for (i=1;i<=hdn_controw<?php echo $NumWindow; ?>.value;i++) {
			document.getElementById('chk_radicarok'+i+'<?php echo $NumWindow; ?>').checked=0; 
		}
	}
	totalrad<?php echo $NumWindow; ?>();
}

<?php
	if (isset($_GET["Rad"])) {	
	$SQL="SELECT LPAD(Codigo_RAD,10,'0'), Codigo_EPS, Codigo_PLA, date(FechaIni_RAD), date(FechaFin_RAD), date(Fecha_RAD), Estado_RAD, date(FechaConf_RAD), Radicado_RAD FROM czradicacionescab WHERE LPAD(Codigo_RAD,10,'0') =LPAD(".$_GET["Rad"].",10,'0');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		CargarxPlan".$NumWindow."('".$row[1]."');
		NombreContrato('".$NumWindow."', '".$row[1]."');
		document.frm_form".$NumWindow.".txt_radicacion".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_fecini".$NumWindow.".value='".($row[3])."';
		document.frm_form".$NumWindow.".txt_fecfin".$NumWindow.".value='".($row[4])."';
		document.frm_form".$NumWindow.".txt_fecenv".$NumWindow.".value='".($row[5])."';
		document.frm_form".$NumWindow.".txt_fecrad".$NumWindow.".value='".($row[7])."';
		document.frm_form".$NumWindow.".txt_numrad".$NumWindow.".value='".$row[8]."';
		
		function CargarxPlan".$NumWindow."(Codigo) {
			$.get(Funciones,{'Func':'CargarPlanR','value':Codigo},function(data){ 
				document.getElementById('txt_Plan".$NumWindow."').innerHTML=data;
				document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
			}); 

		}
		totalrad".$NumWindow."();
	";
		if ($row[6]=="1") {
			echo "
			document.frm_form".$NumWindow.".txt_fecrad".$NumWindow.".value='".FormatoFecha($row[5])."';
			";
		}
		else {
			echo "
			MsgBox1('Radicacion de Cuentas','El envio de radicaci&oacute;n ".$_GET["Rad"]." ya ha sido confirmado.');
			";
		}
	}
	else {
		echo "
		MsgBox1('Radicacion de Cuentas','No se encuentra la radicacion ".$_GET["Rad"]."');
		";
	}
	mysqli_free_result($result); 		
	} 
?>

 	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");

</script> 