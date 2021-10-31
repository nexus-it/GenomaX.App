<?php
	session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	$tipopte="";
	$totalpaciente=0;
	$totalentidad=0;
	$valorCuota=0;
	$valorCopago=0;
	$copagoadm=0;
	$cuotaadm=0;
	$porcentaje=0;
	$TotalFactura=0;
	$TotalServicios=0;
	$Partic="";
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">


<div class="col-md-12">

	<label class="label label-default">Factura</label>
	  <div class="row well well-sm">

	<div class="col-md-2">

<div class="form-group">
<label for="txt_Ingreso<?php echo $NumWindow; ?>">Ingreso</label>
	<div class="input-group">
 		 <input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>"  onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*')};" />
		 <span class="input-group-btn"> 		
 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		 </span>
	</div>
</div>
	
	</div>
	<div class="col-md-2">

<div class="form-group">
<label for="txt_fechaadm<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechaadm<?php echo $NumWindow; ?>" type="date" disable="disabled" id="txt_fechaadm<?php echo $NumWindow; ?>" >
</div>

	</div>
	<div class="col-md-1">

<div class="form-group">
  <label for="txt_horaadm<?php echo $NumWindow; ?>">Hora</label>
  <input name="txt_horaadm<?php echo $NumWindow; ?>" type="time" disabled="disabled" id="txt_horaadm<?php echo $NumWindow; ?>" >
</div> 

	</div>
	<div class="col-md-1">

<div class="form-group">
  <label for="cmb_sede<?php echo $NumWindow; ?>">Sede</label>
  <select name="cmb_sede<?php echo $NumWindow; ?>" id="cmb_sede<?php echo $NumWindow; ?>">
    <?php 
	$SQL="Select Codigo_AFC, Nombre_SDE From czsedes Where Estado_SDE='1' Order By Codigo_SDE";
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

  <input name="hdn_cuotamod<?php echo $NumWindow; ?>" type="hidden" id="hdn_cuotamod<?php echo $NumWindow; ?>" value="0" />
  <input name="hdn_porccop<?php echo $NumWindow; ?>" type="hidden" id="hdn_porccop<?php echo $NumWindow; ?>" value="0" />
  <input name="hdn_maximocop<?php echo $NumWindow; ?>" type="hidden" id="hdn_maximocop<?php echo $NumWindow; ?>" value="0" />
  <input name="hdn_maxanual<?php echo $NumWindow; ?>" type="hidden" id="hdn_maxanual<?php echo $NumWindow; ?>" value="0" />
  <input name="hdn_copagoadm<?php echo $NumWindow; ?>" type="hidden" id="hdn_copagoadm<?php echo $NumWindow; ?>" value="0" />
  <input name="hdn_cuotaadm<?php echo $NumWindow; ?>" type="hidden" id="hdn_cuotaadm<?php echo $NumWindow; ?>" value="0" />

  	</div>
	<div class="col-md-4">

<div class="form-group">
    <label for="txt_paciente2<?php echo $NumWindow; ?>">Paciente</label>
	<input id="txt_paciente2<?php echo $NumWindow; ?>" type="text" disabled="disabled" name="txt_paciente2<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; ">
</div>
	</div>
	<div class="col-md-1">

<div class="form-group">  
  <label for="cmb_mes<?php echo $NumWindow; ?>">Mes</label>
  <select name="cmb_mes<?php echo $NumWindow; ?>" id="cmb_mes<?php echo $NumWindow; ?>" >
    <option value="ENERO">ENERO</option>
    <option value="FEBRERO">FEBRERO</option>
    <option value="MARZO">MARZO</option>
    <option value="ABRIL">ABRIL</option>
    <option value="MAYO">MAYO</option>
    <option value="JUNIO">JUNIO</option>
    <option value="JULIO">JULIO</option>
    <option value="AGOSTO">AGOSTO</option>
    <option value="SEPTIEMBRE">SEPTIEMBRE</option>
    <option value="OCTUBRE">OCTUBRE</option>
    <option value="NOVIEMBRE">NOVIEMBRE</option>
    <option value="DICIEMBRE">DICIEMBRE</option>
  </select>
</div> 

	</div>
	<div class="col-md-1">

<div class="form-group">  
  <label for="txt_anyo<?php echo $NumWindow; ?>">Año</label>
  <input name="txt_anyo<?php echo $NumWindow; ?>" type="number" id="txt_anyo<?php echo $NumWindow; ?>" min="2020" />
</div> 

	</div>
	<div class="col-md-3">

<div class="form-group">
  <label for="txt_NombreEPS<?php echo $NumWindow; ?>">Contrato</label>
  <input type="hidden" name="hdn_contrato<?php echo $NumWindow; ?>" id="hdn_contrato<?php echo $NumWindow; ?>" />
  <input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>"/>
</div> 

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_NombrePlan<?php echo $NumWindow; ?>">Plan</label>
  <input type="hidden" name="hdn_plan<?php echo $NumWindow; ?>" id="hdn_plan<?php echo $NumWindow; ?>" />
  <input name="txt_NombrePlan<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombrePlan<?php echo $NumWindow; ?>" />
  <input type="hidden" name="hdn_tarifa<?php echo $NumWindow; ?>" id="hdn_tarifa<?php echo $NumWindow; ?>" />
</div> 

	</div>
	<div class="col-md-1">

<div class="form-group">
  <label for="txt_cama<?php echo $NumWindow; ?>">Cama</label>
  <input name="txt_cama<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_cama<?php echo $NumWindow; ?>" /><span id="lbl_cama<?php echo $NumWindow; ?>" class="nombre"></span>
</div>  

  	</div>
  	<div class="col-md-2">

<div class="form-group">
  <label for="txt_consultorio<?php echo $NumWindow; ?>">Consultorio</label>
  <input name="txt_consultorio<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_consultorio<?php echo $NumWindow; ?>" /><span id="lbl_consultorio<?php echo $NumWindow; ?>" class="nombre"></span>
</div>  

  	</div>
  	<div class="col-md-2">

<div class="form-group">
  <label for="txt_fechafac<?php echo $NumWindow; ?>">Fecha Factura</label>
  <?php
  $Dizabled="";
  if ($_SESSION["it_CodigoPRF"]!='0') {
  	$Dizabled='disabled="disabled"';
  }
  ?>
  <input name="txt_fechafac<?php echo $NumWindow; ?>" type="date" <?php echo $Dizabled; ?> id="txt_fechafac<?php echo $NumWindow; ?>" />
</div>  

  	</div>
	  <div class="col-md-2">

<div class="form-group">
  <label for="txt_fechafac<?php echo $NumWindow; ?>">Hora Factura</label>
	<input name="txt_horafac<?php echo $NumWindow; ?>" id="txt_horafac<?php echo $NumWindow; ?>" type="time" <?php echo $Dizabled; ?> value="00:00:00"/>
</div>  

	</div>
	<div class="col-md-2">

<div class="form-group">  
  <label for="cmb_porcentaje<?php echo $NumWindow; ?>">Asignar</label>
  <select name="cmb_porcentaje<?php echo $NumWindow; ?>" id="cmb_porcentaje<?php echo $NumWindow; ?>"  onchange="chngvalpte<?php echo $NumWindow; ?>();" >
    <option value="1" selected="selected">Porcentaje</option>
    <option value="2">Valor</option>
  </select>
</div> 

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_valpaciente<?php echo $NumWindow; ?>">Paciente</label>
  <input name="txt_valpaciente<?php echo $NumWindow; ?>" type="text" id="txt_valpaciente<?php echo $NumWindow; ?>" value="0" class="izq" onchange="chngvalpte<?php echo $NumWindow; ?>();" />
</div> 

	</div>
	<div class="col-md-2">
  
<div class="form-group">
  <label for="txt_valorentidad<?php echo $NumWindow; ?>">Entidad</label>
  <input name="txt_valorentidad<?php echo $NumWindow; ?>" type="text" id="txt_valorentidad<?php echo $NumWindow; ?>" value="0"  class="izq"  onchange="chngvalpte<?php echo $NumWindow; ?>();" />
</div> 

	</div>
	<div class="col-md-6">
		<input name="hdn_reingreso<?php echo $NumWindow; ?>" type="hidden" id="hdn_reingreso<?php echo $NumWindow; ?>" value="0" />
		<div class="row " id="div_reingreso<?php echo $NumWindow; ?>" name="div_reingreso<?php echo $NumWindow; ?>">
			<h4><span class="text-warning bg-success center-block" id="lbl_reingreso<?php echo $NumWindow; ?>" name="lbl_reingreso<?php echo $NumWindow; ?>">REINGRESOS</span></h4>
		</div>
	</div>

	</div>

	<label class="label label-default">Detalle</label>
	  <div class="row well well-sm">

	  	<div class="col-md-12">

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" >
<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
      <th id="th1<?php echo $NumWindow; ?>">Codigo</th> 
      <th id="th2<?php echo $NumWindow; ?>">Servicio</th> 
      <th id="th3<?php echo $NumWindow; ?>">Cant.</th> 
      <th id="th4<?php echo $NumWindow; ?>">Paciente</th>
      <th id="th4<?php echo $NumWindow; ?>">Entidad</th>
      <th id="th4<?php echo $NumWindow; ?>">Total</th>
</tr>
<?php 
	if (isset($_GET["Ingreso"])) {
	$SQL="Select Codigo_TAF, Copago_ADM, Cuota_ADM, Cuota_MOD, Porcentaje_COP, Maximo_COP, MaxAnual, Ingreso_ADM, sum(Valor_TAR*Cantidad_ORD), Tipo_EPS From gxadmision a, gxrangoactual b, gxpacientes c, gxordenescab d, gxordenesdet e, gxmanualestarifarios f, gxcontratos g, gxeps h Where b.Codigo_ANY=DATE_FORMAT(d.Fecha_ORD, '%Y') and b.Codigo_RNG=c.Codigo_RNG and a.Codigo_TER=c.Codigo_TER and LPAD(a.Codigo_ADM,10,'0')=LPAD(".$_GET["Ingreso"].",10,'0')  AND g.Codigo_EPS=h.Codigo_EPS and d.Codigo_ADM=a.Codigo_ADM and e.Codigo_SER=f.Codigo_SER and d.Codigo_ORD=e.Codigo_ORD and  FechaIni_TAR <=d.Fecha_ORD and FechaFin_TAR>=d.Fecha_ORD and Estado_ORD='1' and f.Codigo_TAR = g.Codigo_TAR and trim(g.Codigo_EPS) = trim(a.Codigo_EPS) and g.Codigo_PLA = a.Codigo_PLA and trim(e.Codigo_EPS) = trim(g.Codigo_EPS) and e.Codigo_PLA = g.Codigo_PLA Group By Codigo_TAF, Copago_ADM, Cuota_ADM, Cuota_MOD, Porcentaje_COP, Maximo_COP, MaxAnual, Ingreso_ADM";
	//echo $SQL;
	$resultX = mysqli_query($conexion, $SQL);
	//$resultX = mysqli_query($conexion, $SQL);
	if($rowX = mysqli_fetch_array($resultX)) {
	$tipopte=0;
	$copagoadm=0;
	$cuotaadm=0;
	$porcentaje=0;
	$valorCuota=0;
	$valorCopago=0;
	$TipoADM=0;
	$TotalFactura=0;
	$Partic="";

	$tipopte=$rowX[0];
	$copagoadm=$rowX[1];
	$cuotaadm=$rowX[2];
	$porcentaje=$rowX[4];
	$valorCuota=$rowX[3];
	$valorCopago=$rowX[5];
	$TipoADM=$rowX[7];
	$TotalFactura=$rowX[8];
	$Partic=$rowX[9];
	}
	mysqli_free_result($resultX);
	
	$SQL="Select LPAD(Codigo_ORD,10,'0'), date(Fecha_ORD), Nombre_ARE, Autorizacion_ORD  
from gxordenescab a, gxareas b 
Where a.Codigo_ARE=b.Codigo_ARE  
AND a.Estado_ORD='1' 
and LPAD(Codigo_ADM,10,'0')=LPAD(".$_GET["Ingreso"].",10,'0') Order By 1";
	$resultZ = mysqli_query($conexion, $SQL);
	//$resultX = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while ($rowZ = mysqli_fetch_array($resultZ)) {
		echo '
<tr class="success">
  <td colspan="6" id="td1t'.$NumWindow.'">
    <div class="row">
      <div class="col-md-1" align="right" >Orden:</div>
      <div class="col-md-2" align="left"><strong>'.$rowZ[0].'</strong></div>
      <div class="col-md-1" align="right" >Fecha:</div>
      <div class="col-md-1" align="left">'.FormatoFecha($rowZ[1]).'</div>
      <div class="col-md-1" align="right" >Area:</div>
      <div class="col-md-2" align="left">'.$rowZ[2].'</div>
      <div class="col-md-1" align="right" >Autorizacion:</div>
      <div class="col-md-3" align="left">'.$rowZ[3].'</div>
    </div>
  </td>
</tr>
';
//
	$SQL="Select a.Codigo_SER, CUPS_PRC, Nombre_SER, Cantidad_ORD, SUM(Valor_SER), b.Codigo_ORD 
from gxservicios a, gxordenesdet b, gxprocedimientos c, gxprocedimientosdet d
Where d.Codigo_SER=b.Codigo_SER and c.Codigo_SER=b.Codigo_SER AND b.Codigo_ORD=d.Codigo_ORD AND
 a.Codigo_SER=b.Codigo_SER AND  c.Procedimiento_PRC='1' AND LPAD(b.Codigo_ORD,10,'0')='".$rowZ[0]."' 
Group By a.Codigo_SER, CUPS_PRC, Nombre_SER, Cantidad_ORD, b.Codigo_ORD 
";
 	$result = mysqli_query($conexion, $SQL);
	//$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		$Pte=0;
		$Ent=$row[4];
		if ($TipoADM=="A2") {
			if ($cuotaadm=='1') {
				$Pte=(($row[4]*$row[3])/$TotalFactura)*$valorCuota/$row[3];
				$Ent=$row[4]-$Pte;
			}
		}
		if ($copagoadm=='1') {
			if ($totalpaciente < $valorCopago) {
				$Pte=$row[4]*$porcentaje/100;
				$Ent=$row[4]-$Pte;
			}
		}
		$totalpaciente=$totalpaciente+($Pte*$row[3]);
		if ($copagoadm=='1') {
			if ($totalpaciente > $valorCopago) {
				//$Ent=($totalpaciente - $valorCopago)/$row[3];
				//$Pte=($row[4]*$porcentaje/100);
				$Pte=$Pte*$row[3]- ($totalpaciente - $valorCopago)/$row[3];
				$Ent=$row[4]-$Pte;
				$totalpaciente=$totalpaciente+($Pte*$row[3]);

			}
			if ($totalpaciente == $valorCopago) {
				$Pte=0;
				$Ent=$row[4];
				$totalpaciente=$totalpaciente+($Pte*$row[3]);
			}
		}
		$totalentidad=$totalentidad+($Ent*$row[3]);
		$TotalServicios++;
		echo '    
<tr id="tr'.$contarow.$NumWindow.'"  class="warning">
  <td><input name="hdn_ordenser'.$contarow.$NumWindow.'" type="hidden" id="hdn_ordenser'.$contarow.$NumWindow.'" value="'.$row[5].'" /><input name="hdn_codigoser'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoser'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td align="center"><input name="hdn_cantidadser'.$contarow.$NumWindow.'" type="hidden" id="hdn_cantidadser'.$contarow.$NumWindow.'" value="'.$row[3].'" />'.$row[3].'</td>
    <td align="right"><input name="hdn_pteser'.$contarow.$NumWindow.'" type="hidden" id="hdn_pteser'.$contarow.$NumWindow.'" value="'.$Pte.'" />'.number_format($Pte, 2, ",", ".").'</td>
    <td align="right"><input name="hdn_entser'.$contarow.$NumWindow.'" type="hidden" id="hdn_entser'.$contarow.$NumWindow.'" value="'.$Ent.'" />'.number_format($Ent, 2, ",", ".").'</td>
    <td align="right"><input name="hdn_totser'.$contarow.$NumWindow.'" type="hidden" id="hdn_totser'.$contarow.$NumWindow.'" value="'.$row[4].'" />'.number_format($row[3]*$row[4], 2, ",", ".").'</td>
</tr> 
';
	}
	mysqli_free_result($result); 
	//
	$SQL="Select a.Codigo_SER, CUPS_PRC, Nombre_SER, Cantidad_ORD, Valor_TAR, Codigo_ORD 
from gxservicios a, gxordenesdet b, gxprocedimientos c, gxmanualestarifarios d, gxcontratos e 
Where d.Codigo_SER=b.Codigo_SER and d.Codigo_TAR=e.Codigo_TAR and c.Codigo_SER=b.Codigo_SER AND
 a.Codigo_SER=b.Codigo_SER AND trim(e.Codigo_EPS)=trim(b.Codigo_EPS) and trim(e.Codigo_PLA)=trim(b.Codigo_PLA) and
 FechaIni_TAR <='".$rowZ[1]."' and FechaFin_TAR>='".$rowZ[1]." 23:59:59' AND  c.Procedimiento_PRC='0'  and LPAD(Codigo_ORD,10,'0')='".$rowZ[0]."' 
";
 	$result = mysqli_query($conexion, $SQL);
	//$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		$Pte=0;
		$Ent=$row[4];
		if ($TipoADM=="A2") {
			if ($cuotaadm=='1') {
				$Pte=(($row[4]*$row[3])/$TotalFactura)*$valorCuota/$row[3];
				$Ent=$row[4]-$Pte;
			}
		}
		if ($copagoadm=='1') {
			if ($totalpaciente < $valorCopago) {
				$Pte=$row[4]*$porcentaje/100;
				$Ent=$row[4]-$Pte;
			}
		}
		$totalpaciente=$totalpaciente+($Pte*$row[3]);
		if ($copagoadm=='1') {
			if ($totalpaciente > $valorCopago) {
				//$Ent=($totalpaciente - $valorCopago)/$row[3];
				//$Pte=($row[4]*$porcentaje/100);
				$Pte=$Pte*$row[3]- ($totalpaciente - $valorCopago)/$row[3];
				$Ent=$row[4]-$Pte;
				$totalpaciente=$totalpaciente+($Pte*$row[3]);

			}
			if ($totalpaciente == $valorCopago) {
				$Pte=0;
				$Ent=$row[4];
				$totalpaciente=$totalpaciente+($Pte*$row[3]);
			}
		}
		$totalentidad=$totalentidad+($Ent*$row[3]);
		$TotalServicios++;
		echo '    
<tr id="tr'.$contarow.$NumWindow.'"  class="warning">
  <td><input name="hdn_ordenser'.$contarow.$NumWindow.'" type="hidden" id="hdn_ordenser'.$contarow.$NumWindow.'" value="'.$row[5].'" /><input name="hdn_codigoser'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoser'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td align="center"><input name="hdn_cantidadser'.$contarow.$NumWindow.'" type="hidden" id="hdn_cantidadser'.$contarow.$NumWindow.'" value="'.$row[3].'" />'.$row[3].'</td>
    <td align="right"><input name="hdn_pteser'.$contarow.$NumWindow.'" type="hidden" id="hdn_pteser'.$contarow.$NumWindow.'" value="'.$Pte.'" />'.number_format($Pte, 2, ",", ".").'</td>
    <td align="right"><input name="hdn_entser'.$contarow.$NumWindow.'" type="hidden" id="hdn_entser'.$contarow.$NumWindow.'" value="'.$Ent.'" />'.number_format($Ent, 2, ",", ".").'</td>
    <td align="right"><input name="hdn_totser'.$contarow.$NumWindow.'" type="hidden" id="hdn_totser'.$contarow.$NumWindow.'" value="'.$row[4].'" />'.number_format($row[3]*$row[4], 2, ",", ".").'</td>
</tr> 
';
	}
	mysqli_free_result($result); 
	//
	$SQL="Select a.Codigo_SER, CUM_MED, Nombre_SER, Cantidad_ORD, Valor_TAR, Codigo_ORD  
from gxservicios a, gxordenesdet b, gxmedicamentos c, gxmanualestarifarios d, gxcontratos e  
Where d.Codigo_SER=b.Codigo_SER and d.Codigo_TAR=e.Codigo_TAR and c.Codigo_SER=b.Codigo_SER AND
 a.Codigo_SER=b.Codigo_SER AND trim(e.Codigo_EPS)=trim(b.Codigo_EPS) and trim(e.Codigo_PLA)=trim(b.Codigo_PLA) and
 FechaIni_TAR <='".$rowZ[1]."' and FechaFin_TAR>='".$rowZ[1]." 23:59:59' and LPAD(Codigo_ORD,10,'0')='".$rowZ[0]."'";
 	$result = mysqli_query($conexion, $SQL);
	//$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		$Pte=0;
		$Ent=$row[4];
		if ($TipoADM=="A2") {
			if ($cuotaadm=='1') {
				$Pte=(($row[4]*$row[3])/$TotalFactura)*$valorCuota/$row[3];
				$Ent=$row[4]-$Pte;
			}
		}
		if ($copagoadm=='1') {
			if ($totalpaciente < $valorCopago) {
				$Pte=$row[4]*$porcentaje/100;
				$Ent=$row[4]-$Pte;
			}
		}
		$totalpaciente=$totalpaciente+($Pte*$row[3]);
		if ($copagoadm=='1') {
			if ($totalpaciente > $valorCopago) {
				//$Ent=($totalpaciente - $valorCopago)/$row[3];
				//$Pte=($row[4]*$porcentaje/100);
				$Pte=$Pte*$row[3]- ($totalpaciente - $valorCopago)/$row[3];
				$Ent=$row[4]-$Pte;
				$totalpaciente=$totalpaciente+($Pte*$row[3]);

			}
			if ($totalpaciente == $valorCopago) {
				$Pte=0;
				$Ent=$row[4];
				$totalpaciente=$totalpaciente+($Pte*$row[3]);
			}
		}
		$totalentidad=$totalentidad+($Ent*$row[3]);
		$TotalServicios++;
		echo '    
<tr id="tr'.$contarow.$NumWindow.'"  class="warning">
  <td><input name="hdn_ordenser'.$contarow.$NumWindow.'" type="hidden" id="hdn_ordenser'.$contarow.$NumWindow.'" value="'.$row[5].'" /><input name="hdn_codigoser'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoser'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td align="center"><input name="hdn_cantidadser'.$contarow.$NumWindow.'" type="hidden" id="hdn_cantidadser'.$contarow.$NumWindow.'" value="'.$row[3].'" />'.$row[3].'</td>
    <td align="right"><input name="hdn_pteser'.$contarow.$NumWindow.'" type="hidden" id="hdn_pteser'.$contarow.$NumWindow.'" value="'.$Pte.'" />'.number_format($Pte, 2, ",", ".").'</td>
    <td align="right"><input name="hdn_entser'.$contarow.$NumWindow.'" type="hidden" id="hdn_entser'.$contarow.$NumWindow.'" value="'.$Ent.'" />'.number_format($Ent, 2, ",", ".").'</td>
    <td align="right"><input name="hdn_totser'.$contarow.$NumWindow.'" type="hidden" id="hdn_totser'.$contarow.$NumWindow.'" value="'.$row[4].'" />'.number_format($row[3]*$row[4], 2, ",", ".").'</td>
</tr> 
';
	}
	mysqli_free_result($result); 
	//
	}
	mysqli_free_result($resultZ); 
}
?>     
</tbody>
</table>
 </div><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />

 		</div>
 		<div class="col-md-9">
 			<div class="form-group">
			  <label for="txt_nota<?php echo $NumWindow; ?>">Nota:</label>
			  <textarea name="txt_nota<?php echo $NumWindow; ?>" rows="3" id="txt_nota<?php echo $NumWindow; ?>" ></textarea>
			</div> 
 		</div>
		<div class="col-md-3 ">

  <label for="txt_totalpaciente<?php echo $NumWindow; ?>">Total Paciente</label>
  <input name="hdn_totalpte<?php echo $NumWindow; ?>" type="hidden" id="hdn_totalpte<?php echo $NumWindow; ?>" value="<?php echo $totalpaciente; ?>" />
  <input name="txt_totalpaciente<?php echo $NumWindow; ?>" type="text" id="txt_totalpaciente<?php echo $NumWindow; ?>" value="<?php echo number_format($totalpaciente, 2, ",", "."); ?>" size="15" class="izq" disabled="disabled" /><br />
  <input name="hdn_totalptetmp<?php echo $NumWindow; ?>" type="hidden" id="hdn_totalptetmp<?php echo $NumWindow; ?>" value="<?php echo $totalpaciente; ?>" />
  <label for="txt_totalentidad<?php echo $NumWindow; ?>">Total Entidad</label>
  <input name="hdn_totalent<?php echo $NumWindow; ?>" type="hidden" id="hdn_totalent<?php echo $NumWindow; ?>" value="<?php echo $totalentidad; ?>" />
  <input name="txt_totalentidad<?php echo $NumWindow; ?>" type="text" id="txt_totalentidad<?php echo $NumWindow; ?>" value="<?php echo number_format($totalentidad, 2, ",", "."); ?>" size="15" class="izq" disabled="disabled" /><br />
  <input name="hdn_totalenttmp<?php echo $NumWindow; ?>" type="hidden" id="hdn_totalenttmp<?php echo $NumWindow; ?>" value="<?php echo $totalentidad; ?>" />
  <label for="txt_dctoentidad<?php echo $NumWindow; ?>">Descuento Entidad</label>
  <input name="txt_dctoentidad<?php echo $NumWindow; ?>" type="text" id="txt_dctoentidad<?php echo $NumWindow; ?>" value="0,00" size="15" class="izq" disabled="disabled" />

	</div>

	</div>

</div>

</form>
<script >
FechaActual('txt_fechafac<?php echo $NumWindow; ?>');
HoraActual("txt_horafac<?php echo $NumWindow; ?>");
$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();
<?php
	$SQL="Select month(now()), year(now());";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) 
	{
	echo "document.frm_form".$NumWindow.".txt_anyo".$NumWindow.".value='".$row[1]."';";
    if ($row[0]=="1") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='ENERO';";  }
	if ($row[0]=="2") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='FEBRERO';";  }
	if ($row[0]=="3") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='MARZO';";  }
	if ($row[0]=="4") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='ABRIL';";  }
	if ($row[0]=="5") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='MAYO';";  }
	if ($row[0]=="6") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='JUNIO';";  }
	if ($row[0]=="7") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='JULIO';";  }
	if ($row[0]=="8") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='AGOSTO';";  }
	if ($row[0]=="9") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='SEPTIEMBRE';";  }
	if ($row[0]=="10") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='OCTUBRE';";  }
	if ($row[0]=="11") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='NOVIEMBRE';";  }
	if ($row[0]=="12") { echo "document.frm_form".$NumWindow.".cmb_mes".$NumWindow.".value='DICIEMBRE';";  }
	}
	mysqli_free_result($result); 

	echo "
	document.getElementById('div_reingreso".$NumWindow."').style.display = 'none';
		";
	if ($_SESSION["it_CodigoUSR"]>"1") {
		$SQL="Select Codigo_AFC From czsedes a, itusuariossedes b Where b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and a.Codigo_SDE=b.Codigo_SDE and Estado_SDE='1'";
		$result = mysqli_query($conexion, $SQL);
		$contasedes=0;
		while($row = mysqli_fetch_array($result)) 
		{
			$contasedes++;
	 	echo "	    	document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[0]."';";
	    
		}
		mysqli_free_result($result); 
		if ($contasedes==1) {
			echo "			document.getElementById('cmb_sede".$NumWindow."').setAttribute('disabled', true);";
		} else {
			if (isset($_GET["Ingreso"])) {	
				$SQL="Select Codigo_AFC From gxadmision a, itusuariossedes b, czsedes c  Where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0') and b.Codigo_SDE=c.Codigo_SDE and b.Codigo_USR=a.Codigo_USR";
				$result = mysqli_query($conexion, $SQL);
				if($row = mysqli_fetch_array($result)) {
					echo "document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[0]."';";
				}
				mysqli_free_result($result); 
			}
		}
	}

	if (isset($_GET["Ingreso"])) {	
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), b.ID_TER, e.Nombre_TER, Nombre_PLA, Nombre_CAM, Cuota_MOD, Porcentaje_COP, Maximo_COP, MaxAnual, Copago_ADM, Cuota_ADM, c.Codigo_EPS, d.Codigo_PLA, k.Codigo_AFC, a.Codigo_PTT, Reingreso_PTT, Nombre_PTT from gxpacientestipos z, czterceros b, gxeps c, gxplanes d, czterceros e, gxrangoactual h, gxpacientes i, czsedes k, gxadmision a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where k.Codigo_SDE=a.Codigo_SDE and a.Codigo_TER=b.Codigo_TER and z.Codigo_PTT=a.Codigo_PTT and c.Codigo_TER=e.Codigo_TER and c.Codigo_EPS=a.Codigo_EPS and d.Codigo_PLA=a.Codigo_PLA and i.Codigo_TER=a.Codigo_TER and h.Codigo_ANY=DATE_FORMAT(curdate(), '%Y') and h.Codigo_RNG=i.Codigo_RNG and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0') and Estado_ADM='I' Limit 1";
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), b.ID_TER, e.Nombre_TER, Nombre_PLA, Nombre_CAM, Cuota_MOD, Porcentaje_COP, Maximo_COP, MaxAnual, Copago_ADM, Cuota_ADM, c.Codigo_EPS, d.Codigo_PLA, k.Codigo_AFC, a.Codigo_PTT, Reingreso_PTT, Nombre_PTT from gxpacientestipos z, czterceros b, gxeps c, gxplanes d, czterceros e, gxrangoactual h, gxpacientes i, czsedes k, gxadmision  a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where  k.Codigo_SDE=a.Codigo_SDE and a.Codigo_TER=b.Codigo_TER and z.Codigo_PTT=a.Codigo_PTT and c.Codigo_TER=e.Codigo_TER and c.Codigo_EPS=a.Codigo_EPS and d.Codigo_PLA=a.Codigo_PLA and i.Codigo_TER=a.Codigo_TER and h.Codigo_ANY=DATE_FORMAT(curdate(), '%Y') and h.Codigo_RNG=i.Codigo_RNG and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0') and Estado_ADM='I' Limit 1";
	$result = mysqli_query($conexion, $SQL);
	//$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".($row[0])."';
		document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_paciente2".$NumWindow.".value='".$row[3]."';
		document.frm_form".$NumWindow.".txt_NombreEPS".$NumWindow.".value='".$row[4]."';
		document.frm_form".$NumWindow.".txt_NombrePlan".$NumWindow.".value='".$row[5]."';
		document.frm_form".$NumWindow.".txt_cama".$NumWindow.".value='".$row[6]."';
		document.frm_form".$NumWindow.".hdn_cuotamod".$NumWindow.".value='".$row[7]."';
		document.frm_form".$NumWindow.".hdn_porccop".$NumWindow.".value='".$row[8]."';
		document.frm_form".$NumWindow.".hdn_maximocop".$NumWindow.".value='".$row[9]."';
		document.frm_form".$NumWindow.".hdn_maxanual".$NumWindow.".value='".$row[10]."';
		document.frm_form".$NumWindow.".hdn_copagoadm".$NumWindow.".value='".$row[11]."';
		document.frm_form".$NumWindow.".hdn_cuotaadm".$NumWindow.".value='".$row[12]."';
		document.frm_form".$NumWindow.".hdn_contrato".$NumWindow.".value='".$row[13]."';
		document.frm_form".$NumWindow.".hdn_plan".$NumWindow.".value='".$row[14]."';
		document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[15]."';
		NombreTercero('".$NumWindow."', '".$row[3]."', 'gxpacientes');

	";
	
		if ($row["Reingreso_PTT"]=='1') {
			echo "
			document.getElementById('div_reingreso".$NumWindow."').style.display = 'block';
			document.getElementById('lbl_reingreso".$NumWindow."').innerHTML='El paciente se encuentra clasificado en el ingreso como <strong>".$row["Nombre_PTT"]."</strong>.<br> ¿Desea realizar un reingreso del mismo al liquidar la cuenta? <input id=\"chkring".$NumWindow."\" name=\"chkring".$NumWindow."\" type=\"checkbox\" value=\"1\" checked onclick=\"fncreing".$NumWindow."(this.value);\">';
			document.getElementById('hdn_reingreso".$NumWindow."').value=\"1\";
			";

	}
	}
	else {
		echo "
		MsgBox1('Liquidación de cuentas','No se encuentra el ingreso ".$_GET["Ingreso"]."');
		";
	}
	mysqli_free_result($result); 
	}
?>
function fncreing<?php echo $NumWindow; ?>(rvalor) {
	if (rvalor=="0") {
		document.getElementById('chkring<?php echo $NumWindow; ?>').value="1";
		document.getElementById('hdn_reingreso<?php echo $NumWindow; ?>').value="1";
	} else {
		document.getElementById('chkring<?php echo $NumWindow; ?>').value="0";
		document.getElementById('hdn_reingreso<?php echo $NumWindow; ?>').value="0";
	}
}

function AgregarFila<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AgregarFilaOrden(document.frm_form<?php echo $NumWindow; ?>.txt_codigo<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.hdn_codigox<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_nombreserv<?php echo $NumWindow; ?>.value,document.frm_form<?php echo $NumWindow; ?>.txt_cantidad<?php echo $NumWindow; ?>.value, '<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.hdn_controw<?php echo $NumWindow; ?>.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>');	  
  }
}

function BuscarIng<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	AbrirForm('application/forms/facturasalud.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
  }
}

function chngvalpte<?php echo $NumWindow; ?>() {
	valtot=document.getElementById('hdn_totalenttmp<?php echo $NumWindow; ?>').value;
	valpte=0;
	valent=0;
	if (document.getElementById('cmb_porcentaje<?php echo $NumWindow; ?>').value=="1") {
		porcpte=document.getElementById('txt_valpaciente<?php echo $NumWindow; ?>').value;
		porcpte=porcpte/100;
		valpte=valtot*porcpte;
		valent=valtot-valpte;
	} else {
		valpte=document.getElementById('txt_valpaciente<?php echo $NumWindow; ?>').value;
		valent=valtot-valpte;
	}
	document.getElementById('hdn_totalent<?php echo $NumWindow; ?>').value=valent;
	document.getElementById('hdn_totalpte<?php echo $NumWindow; ?>').value=valpte;
	document.getElementById('txt_totalentidad<?php echo $NumWindow; ?>').value=valent.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
	document.getElementById('txt_totalpaciente<?php echo $NumWindow; ?>').value=valpte.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;

}

 	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

<?php
if ($Partic=="PARTIC") {
?>
	valtot=document.getElementById('hdn_totalenttmp<?php echo $NumWindow; ?>').value;
	valpte=0;
	valent=0;
	porcpte=1;
	valpte=valtot*porcpte;
	valent=valtot-valpte;
	document.getElementById('hdn_totalent<?php echo $NumWindow; ?>').value=valent;
	document.getElementById('hdn_totalpte<?php echo $NumWindow; ?>').value=valpte;
	document.getElementById('txt_totalentidad<?php echo $NumWindow; ?>').value=valent.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
	document.getElementById('txt_totalpaciente<?php echo $NumWindow; ?>').value=valpte.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
<?php	
}
?>

	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");


</script>
<script src="functions/nexus/facturasalud.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
