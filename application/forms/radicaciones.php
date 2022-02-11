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
 		<input name="txt_radicacion<?php echo $NumWindow; ?>" type="text" id="txt_radicacion<?php echo $NumWindow; ?>"  value="0000000000"  maxlength="10" onkeypress="BuscarRad<?php echo $NumWindow; ?>(event);" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="radicaciones" onclick="javascript:CargarSearch('radicaciones', 'txt_radicacion<?php echo $NumWindow; ?>', 'Estado_RAD=*1*');"><i class="fas fa-search"></i></button>
		</span>
	</div>
	</div>	

</div>
<div class="col-md-2">

	<div class="form-group">	
	<label for="txt_fecrad<?php echo $NumWindow; ?>">Fecha</label>
	  <input name="txt_fecrad<?php echo $NumWindow; ?>" type="date"  id="txt_fecrad<?php echo $NumWindow; ?>" >
	</div>

</div>
<div class="col-md-3">

	 <div class="form-group">
		<label for="txt_Contrato<?php echo $NumWindow; ?>">Contrato</label>
		<select name="txt_Contrato<?php echo $NumWindow; ?>" id="txt_Contrato<?php echo $NumWindow; ?>" onchange="CargarPlanR('<?php echo $NumWindow; ?>', this.value);">
		<?php 
			if (isset($_GET["Rad"])) {	
				$Kontra="AND codigo_fac IN (SELECT codigo_fac FROM czradicacionesdet where LPAD(Codigo_RAD,10,'0')=LPAD(".$_GET["Rad"].",10,'0'))";
			} else {
				$Kontra="AND codigo_fac NOT IN (SELECT codigo_fac FROM czradicacionesdet)";
			}
			$SQL="SELECT a.Codigo_EPS, a.Nombre_EPS, a.Contrato_EPS FROM gxeps a WHERE a.Codigo_EPS IN (SELECT DISTINCT codigo_eps FROM gxfacturas WHERE estado_fac<>'0' ".$Kontra.") and estado_eps='1' ORDER BY a.Nombre_EPS";
			error_log($SQL);
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) {
		?>
			<option value="<?php echo $row[0]; ?>"><?php echo $row[1].' - ['.$row[2].']'; ?></option>
		<?php
			}
			mysqli_free_result($result); 
		?>
		</select>
	 </div>

</div>
<div class="col-md-1">

	<div class="form-group">
	<label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
	<select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>">
	</select>
	</div>

</div>
<div class="col-md-3">

	 <div class="form-group">
		<label for="txt_Sede<?php echo $NumWindow; ?>">Sede</label>
		<select name="txt_Sede<?php echo $NumWindow; ?>" id="txt_Sede<?php echo $NumWindow; ?>" >
		<?php
			$SwSede=0;
			$SQL="Select distinct b.Codigo_SDE, Nombre_SDE From czsedes a, itusuariossedes b Where b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and a.Codigo_SDE=b.Codigo_SDE and Estado_SDE='1'";
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) 
			{
				$SwSede=1;
			 ?>
				<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
			<?php
			}
			mysqli_free_result($result);
			if ($SwSede==0) {
				$SQL="Select Codigo_SDE, Nombre_SDE From czsedes Where Estado_SDE='1' Order By Codigo_SDE;";
				$result = mysqli_query($conexion, $SQL);
				while($row = mysqli_fetch_array($result)) 
				{
				 ?>
					<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
				<?php
				}
				mysqli_free_result($result); 
			}
		?>
		</select>
	 </div>

</div>
<div class="col-md-2">

	<div class="form-group">
	<label for="txt_fecini<?php echo $NumWindow; ?>">Fecha Inicial </label>
	<input name="txt_fecini<?php echo $NumWindow; ?>" type="date" id="txt_fecini<?php echo $NumWindow; ?>" value="0000-00-00"   />
	</div>

</div>
<div class="col-md-2">

	<div class="form-group">
	<label for="txt_fecfin<?php echo $NumWindow; ?>">Fecha Final </label>
	 <input name="txt_fecfin<?php echo $NumWindow; ?>" type="date" id="txt_fecfin<?php echo $NumWindow; ?>" value="0000-00-00"  /> 
	</div>

</div>
<div class="col-md-12">
	<button id="btn_load<?php echo $NumWindow; ?>" name="btn_load<?php echo $NumWindow; ?>" type="button" class="btn btn-success btn-sm btn-block" aria-label="Cargar Facturas" onclick="javascript:CargarFacturasRad('<?php echo $NumWindow; ?>');">
		  CARGAR <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> 
	</button>
</div>
</div>
<div class="row well well-sm">
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
Where  trim(w.Codigo_FAC)=trim(g.Codigo_FAC) and g.Codigo_FAC=e.Codigo_FAC and 
LPAD(w.Codigo_RAD,10,'0')=LPAD(".$_GET["Rad"].",10,'0') 
	Union 
	Select a.Codigo_FAC, d.Nombre_PLA, concat(e.Sigla_TID,' ', c.ID_TER), c.Nombre_TER, a.ValTotal_FAC, '0' 
	From gxfacturas as a, gxadmision as b, czterceros as c, gxplanes as d, cztipoid as e, czradicacionescab as f
	Where a.Codigo_ADM=b.Codigo_ADM and b.Codigo_TER=c.Codigo_TER and a.Codigo_PLA=d.Codigo_PLA and c.Codigo_TID=e.Codigo_TID 
	and a.Estado_FAC='1' and a.Fecha_FAC >=f.FechaIni_RAD and a.Fecha_FAC<=f.FechaFin_RAD 
	and a.Codigo_EPS=f.Codigo_EPS and a.Codigo_PLA=f.Codigo_PLA and f.Estado_RAD='1' and LPAD(f.Codigo_RAD,10,'0')=LPAD(".$_GET["Rad"].",10,'0') 
	and trim(a.Codigo_FAC) not in (
	Select trim(g.Codigo_FAC)
	From czradicacionesdet as g, czradicacionescab as h, czradicacionescab as i 
	Where g.Codigo_RAD=h.Codigo_RAD and h.Codigo_EPS=i.Codigo_EPS and h.FechaIni_RAD<=i.FechaFin_RAD and h.FechaFin_RAD>=i.FechaIni_RAD 
	and h.Codigo_PLA=i.Codigo_PLA and LPAD(i.Codigo_RAD,10,'0')=LPAD(".$_GET["Rad"].",10,'0')
	)
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
	 <div class="row">
	 	<div class="col-md-6 text-left">
			<label for="txt_cantidad<?php echo $NumWindow; ?>"> Cantidad Seleccionada </label>
			<input name="txt_cantidad<?php echo $NumWindow; ?>" id="txt_cantidad<?php echo $NumWindow; ?>" type="text" value="<?php echo $CantFact; ?>" class="izq" disabled="disabled"  style="font-size:15px; font-weight: bold; color:#0E5012; "/><input name="hdn_total<?php echo $NumWindow; ?>" type="hidden" id="hdn_total<?php echo $NumWindow; ?>" value="<?php echo $elTotal; ?>" />
		</div>
		<div class="col-md-6 text-right">
			<label for="txt_total<?php echo $NumWindow; ?>"> Total Radicaci&oacute;n </label>
			<input name="txt_total<?php echo $NumWindow; ?>" id="txt_total<?php echo $NumWindow; ?>" type="text" value="<?php echo number_format($elTotal, 2, ",", "."); ?>" class="izq" disabled="disabled"  style="font-size:15px; font-weight: bold; color:#0E5012; "/><input name="hdn_total<?php echo $NumWindow; ?>" type="hidden" id="hdn_total<?php echo $NumWindow; ?>" value="<?php echo $elTotal; ?>" />
		</div>
	</div>
	<div id="recalcular<?php echo $NumWindow; ?>" style="font-style:italic">Recalculando valores...</div>

</div>
</form>
<script >
<?php
	if (!isset($_GET["Rad"])) {	
		echo "FechaActual('txt_fecrad".$NumWindow."');
		FechaActual('txt_fecini".$NumWindow."');
		FechaActual('txt_fecfin".$NumWindow."');";
	}
?>
CargarPlanR('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
var el = document.getElementById('recalcular<?php echo $NumWindow; ?>'); 
el.style.display = 'none';

function BuscarRad<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  	if ((document.getElementById('txt_radicacion<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_radicacion<?php echo $NumWindow; ?>').value=="0000000000")) {
		document.frm_form<?php echo $NumWindow; ?>.txt_radicacion<?php echo $NumWindow; ?>.value='0000000000';
		FechaActual('txt_fecrad<?php echo $NumWindow; ?>');
		FechaActual('txt_fecini<?php echo $NumWindow; ?>');
		FechaActual('txt_fecfin<?php echo $NumWindow; ?>');
		document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.focus();
	} else {
		AbrirForm('application/forms/radicaciones.php', '<?php echo $NumWindow; ?>', '&Rad='+document.getElementById('txt_radicacion<?php echo $NumWindow; ?>').value);
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
	$SQL="SELECT LPAD(Codigo_RAD,10,'0'), Codigo_EPS, Codigo_PLA, date(FechaIni_RAD), date(FechaFin_RAD), date(Fecha_RAD) FROM czradicacionescab WHERE LPAD(Codigo_RAD,10,'0') =LPAD(".$_GET["Rad"].",10,'0');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		CargarxPlan".$NumWindow."('".$row[1]."');
		document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value='".$row[1]."';
		NombreContrato('".$NumWindow."', '".$row[1]."');
		document.frm_form".$NumWindow.".txt_radicacion".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_fecini".$NumWindow.".value='".($row[3])."';
		document.frm_form".$NumWindow.".txt_fecfin".$NumWindow.".value='".($row[4])."';
		document.frm_form".$NumWindow.".txt_fecrad".$NumWindow.".value='".($row[5])."';
		
		function CargarxPlan".$NumWindow."(Codigo) {
			$.get(Funciones,{'Func':'CargarPlan','value':Codigo},function(data){ 
				document.getElementById('txt_Plan".$NumWindow."').innerHTML=data;
				document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
			}); 

		}
	";
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
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script> 