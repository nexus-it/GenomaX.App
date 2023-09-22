<?php	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">
<div class="col-md-12">
<label class="label label-default">Orden de Servicio:</label>
  <div class="row well well-sm">

    <div class="col-md-2">
<div class="form-group">
  <label for="txt_Ingreso<?php echo $NumWindow; ?>">Ingreso</label>
  <div class="input-group">
  <input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*')};" />
  	<span class="input-group-btn">
  		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*');"><i class="fas fa-search"></i></button>
  	</span>
  </div>		
</div>

  </div>
  <div class="col-md-1">

<div class="form-group">
  <label for="txt_fechaadm<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechaadm<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_fechaadm<?php echo $NumWindow; ?>">
 </div> 

  </div>
  <div class="col-md-1">

<div class="form-group">
  <label for="txt_horaadm<?php echo $NumWindow; ?>">Hora</label>
  <input name="txt_horaadm<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_horaadm<?php echo $NumWindow; ?>" >
</div> 

  </div>
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_paciente<?php echo $NumWindow; ?>">Documento</label>
  <input name="txt_paciente<?php echo $NumWindow; ?>"  type="text" disabled="disabled" id="txt_paciente<?php echo $NumWindow; ?>"  >
</div>

  </div>
  <div class="col-md-6">

<div class="form-group">
  <label for="txt_pacienten<?php echo $NumWindow; ?>">Paciente</label>
  <input name="txt_pacienten<?php echo $NumWindow; ?>"  type="text" disabled="disabled" id="txt_pacienten<?php echo $NumWindow; ?>" > 
</div>

  </div>
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_NombreEPS<?php echo $NumWindow; ?>">Contrato</label>
  <input type="hidden" name="hdn_contrato<?php echo $NumWindow; ?>" id="hdn_contrato<?php echo $NumWindow; ?>" />
  <input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" />
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
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_cama<?php echo $NumWindow; ?>">Cama</label>
  <input name="txt_cama<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_cama<?php echo $NumWindow; ?>" />
  <span id="lbl_cama<?php echo $NumWindow; ?>" class="nombre"></span>
 </div> 

  </div>
  <div class="col-md-6">

<div class="form-group">
  <label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
  <textarea name="txt_observacion<?php echo $NumWindow; ?>" cols="60" rows="3" id="txt_observacion<?php echo $NumWindow; ?>" ></textarea>
</div>
  
  </div> 
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_orden<?php echo $NumWindow; ?>">Orden No.</label>
  <div class="input-group">
  	<input name="txt_orden<?php echo $NumWindow; ?>" type="text" id="txt_orden<?php echo $NumWindow; ?>" size="10" maxlength="10" onkeypress="BuscarOrd<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){SearchOrd<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.value)};" />
  		<span class="input-group-btn">
  		    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Usuario" onclick="javascript:SearchOrd<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.value);"><i class="fas fa-search"></i></button>
  		</span>
  </div>	
</div>
  </div>
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_area<?php echo $NumWindow; ?>">Area de Servicio</label>
  <select name="txt_area<?php echo $NumWindow; ?>" id="txt_area<?php echo $NumWindow; ?>">
    <?php 
    $CodigoSDE="";
    if (isset($_GET["Ingreso"])) {
      $CodigoSDE="and Codigo_SDE in (select Codigo_SDE from gxadmision Where  LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0'))";
    }
    if (isset($_GET["Orden"])) {
      $CodigoSDE="and Codigo_SDE in (select Codigo_SDE from gxadmision a, gxordenescab b Where a.Codigo_ADM=b.Codigo_ADM and LPAD(b.Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0'))"; 
    }
$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' ".$CodigoSDE." order by Codigo_ARE";
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
  
  </div>
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_fechaord<?php echo $NumWindow; ?>">Fecha Orden</label>
  <input name="txt_fechaord<?php echo $NumWindow; ?>" type="date" id="txt_fechaord<?php echo $NumWindow; ?>" value="<?php echo date('Y-m-d');; ?>" />
</div>

  </div>
  <div class="col-md-4">

<div class="form-group">
  <label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
  <input name="txt_descripcion<?php echo $NumWindow; ?>" type="text" id="txt_descripcion<?php echo $NumWindow; ?>" size="65" />
</div>
  
  </div>
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_autorizaord<?php echo $NumWindow; ?>">No. Autorizacion</label>
  <input name="txt_autorizaord<?php echo $NumWindow; ?>" type="text" id="txt_autorizaord<?php echo $NumWindow; ?>" value="" size="20" maxlength="30" />
</div>
  
  </div>

</div>

<label class="label label-default">Detalle:</label>
  <div class="row well well-sm">

    <div class="col-md-1">
<div class="form-group">
<label for="txt_tiposervicio<?php echo $NumWindow; ?>">Tipo</label>
<select name="txt_tiposervicio<?php echo $NumWindow; ?>" id="txt_tiposervicio<?php echo $NumWindow; ?>">
    <?php 
$SQL="Select Tipo_SER, Descripcion_SER from gxtiposervicios order by Tipo_SER";
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

  </div>
  <div class="col-md-2">

<div class="form-group">
  <label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
	<div class="input-group">
	   <input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="3"  onkeypress="NombreServicio<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Servicios'+document.frm_form<?php echo $NumWindow; ?>.txt_tiposervicio<?php echo $NumWindow; ?>.value, 'txt_codigo<?php echo $NumWindow; ?>', 'c.Codigo_TAR=*'+document.frm_form<?php echo $NumWindow; ?>.hdn_tarifa<?php echo $NumWindow; ?>.value+'*')};" />
		 <span class="input-group-btn">
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Servicios" onclick="javascript:CargarSearch('Servicios'+document.frm_form<?php echo $NumWindow; ?>.txt_tiposervicio<?php echo $NumWindow; ?>.value, 'txt_codigo<?php echo $NumWindow; ?>', 'c.Codigo_TAR=*'+document.frm_form<?php echo $NumWindow; ?>.hdn_tarifa<?php echo $NumWindow; ?>.value+'*');"><i class="fas fa-search"></i></button>
		 </span>
	</div>
</div>
  
  </div>
  <div class="col-md-3">

<div class="form-group">
<label for="txt_nombreserv<?php echo $NumWindow; ?>">Nombre
  <input type="hidden" name="hdn_codigox<?php echo $NumWindow; ?>" id="hdn_codigox<?php echo $NumWindow; ?>" />
</label>
<input name="txt_nombreserv<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_nombreserv<?php echo $NumWindow; ?>" />
</div>

  </div>
  <div class="col-md-3">

<div class="form-group">
<label for="cmb_medico<?php echo $NumWindow; ?>">Profesional</label>
<select name="cmb_medico<?php echo $NumWindow; ?>" id="cmb_medico<?php echo $NumWindow; ?>">
    <?php 
$SQL="Select a.Codigo_TER, concat(a.Nombre1_MED,' ',left(a.Nombre2_MED,1),'. ',a.Apellido1_MED,' ',left(a.Apellido2_MED,1),'.') from gxmedicos a Where a.Estado_MED='1' Order By 2;";
$resultz = mysqli_query($conexion, $SQL);
while($rowz = mysqli_fetch_array($resultz)) 
	{
	?>
    <option value="<?php echo $rowz[0]; ?>"><?php echo ($rowz[1]); ?></option>
    <?php
	}
mysqli_free_result($resultz); 
 ?>
</select>
</div>
  
  </div>
  <div class="col-md-3">

<div class="form-group">
	<label for="txt_cantidad<?php echo $NumWindow; ?>">Cant.</label>
	<div class="input-group">
  <input name="txt_cantidad<?php echo $NumWindow; ?>" type="text" id="txt_cantidad<?php echo $NumWindow; ?>" onkeypress="AgregarFila<?php echo $NumWindow; ?>(event);"/>
    <span class="input-group-btn">
   <button class="btn btn-success" type="button" onclick="javascript:AgregarFilaOrden(document.frm_form<?php echo $NumWindow; ?>.txt_codigo<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.hdn_codigox<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_nombreserv<?php echo $NumWindow; ?>.value,document.frm_form<?php echo $NumWindow; ?>.txt_cantidad<?php echo $NumWindow; ?>.value,document.getElementById('cmb_medico<?php echo $NumWindow; ?>').options[document.getElementById('cmb_medico<?php echo $NumWindow; ?>').selectedIndex ].text,document.frm_form<?php echo $NumWindow; ?>.cmb_medico<?php echo $NumWindow; ?>.value, '<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.hdn_controw<?php echo $NumWindow; ?>.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>');"><i class="fas fa-plus"></i> Agregar</button>
 </span>
 </div>
</div>

  </div>
  
 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" >
<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
          <th id="th1<?php echo $NumWindow; ?>">Codigo</td> 
          <th id="th2<?php echo $NumWindow; ?>">Servicio</td> 
          <th id="th2<?php echo $NumWindow; ?>">Profesional</td> 
          <th id="th3<?php echo $NumWindow; ?>">Cantidad</td> 
          <th id="th4<?php echo $NumWindow; ?>">X</td> 
     </tr> 
<?php 
	if (isset($_GET["Orden"])) {
	$SQL="Select a.Codigo_SER, CUPS_PRC, Nombre_SER, Cantidad_ORD, d.Codigo_TER, concat(Nombre1_MED,' ',left(Nombre2_MED,1),'. ',Apellido1_MED,' ',left(Apellido2_MED,1),'.') from gxservicios a, gxordenesdet b, gxprocedimientos c, gxmedicos d Where d.Codigo_TER=b.Codigo_TER and c.Codigo_SER=b.Codigo_SER AND a.Codigo_SER=b.Codigo_SER and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0') ";
	$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		echo '  <tr id="tr'.$contarow.$NumWindow.'">
    <td><input name="hdn_codigoser'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoser'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td><input name="hdn_codigoter'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoter'.$contarow.$NumWindow.'" value="'.$row[4].'" />'.$row[5].'</td>
    <td align="center"><input class="sinborde" name="hdn_cantidadser'.$contarow.$NumWindow.'" type="number" id="hdn_cantidadser'.$contarow.$NumWindow.'" value="'.$row[3].'" min="1" /></td>
    <td align="center"><a href="javascript:EliminarFilaOrden(\''.$contarow.'\',\''.$NumWindow.'\');"><img src="'.$_SESSION["NEXUS_CDN"].'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar servicio de la orden" /></a></td>
  </tr>
';
	}
	mysqli_free_result($result); 
  $SQL="Select a.Codigo_SER, CUM_MED, Nombre_SER, Cantidad_ORD, d.Codigo_TER, concat(Nombre1_MED,' ',left(Nombre2_MED,1),'. ',Apellido1_MED,' ',left(Apellido2_MED,1),'.') from gxservicios a, gxordenesdet b, gxmedicamentos c, gxmedicos d, gxordenescab e Where d.Codigo_TER=b.Codigo_TER and c.Codigo_SER=b.Codigo_SER  AND a.Codigo_SER=b.Codigo_SER and b.Codigo_ORD=e.Codigo_ORD and LPAD(b.Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0')";
  $result = mysqli_query($conexion, $SQL);
  //echo $SQL;
  while($row = mysqli_fetch_array($result)) {
    $contarow++;
    echo '  <tr id="tr'.$contarow.$NumWindow.'">
    <td><input name="hdn_codigoser'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoser'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td><input name="hdn_codigoter'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoter'.$contarow.$NumWindow.'" value="'.$row[4].'" />'.$row[5].'</td>
    <td align="center"><input class="sinborde" name="hdn_cantidadser'.$contarow.$NumWindow.'" type="number" id="hdn_cantidadser'.$contarow.$NumWindow.'" value="'.$row[3].'" min="1" /></td>
    <td align="center"><a href="javascript:EliminarFilaOrden(\''.$contarow.'\',\''.$NumWindow.'\');"><img src="'.$_SESSION["NEXUS_CDN"].'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar servicio de la orden" /></a></td>
  </tr>
';
  }
  mysqli_free_result($result); 
}
?>     
</tbody>
</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
 </div>
 <span id="detalleproc<?php echo $NumWindow; ?>">
 <input name="hdn_cantporctotal<?php echo $NumWindow; ?>" id="hdn_cantporctotal<?php echo $NumWindow; ?>" type="hidden" value="0" />
 </span>
</div>
</form>
<script >

$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();
<?php
	if (isset($_GET["Ingreso"])) {	
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), b.ID_TER, e.Nombre_TER, Nombre_PLA, Nombre_CAM, g.Codigo_EPS, g.Codigo_PLA, g.Codigo_TAR, Autorizacion_ADM, Observaciones_ADM, b.Nombre_TER from czterceros b, gxeps c, gxplanes d, czterceros e, gxcontratos g, gxadmision a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=e.Codigo_TER and trim(c.Codigo_EPS)=trim(a.Codigo_EPS) and d.Codigo_PLA=a.Codigo_PLA and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0') and Estado_ADM='I' and trim(g.Codigo_EPS)=trim(a.Codigo_EPS) and g.Codigo_PLA=a.Codigo_PLA";
  // echo " alert('".substr($_SESSION["it_CodigoUSR"],0,3)."')";
  if ((($_SESSION["it_CodigoPRF"]=="0") &&(substr($_SESSION["it_CodigoUSR"],0,2)=="NX"))||($_SESSION["it_CodigoUSR"]=="0")) {
		$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), b.ID_TER, e.Nombre_TER, Nombre_PLA, Nombre_CAM, g.Codigo_EPS, g.Codigo_PLA, g.Codigo_TAR, Autorizacion_ADM, Observaciones_ADM, b.Nombre_TER from czterceros b, gxeps c, gxplanes d, czterceros e, gxcontratos g, gxadmision a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=e.Codigo_TER and trim(c.Codigo_EPS)=trim(a.Codigo_EPS) and d.Codigo_PLA=a.Codigo_PLA and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')  and trim(g.Codigo_EPS)=trim(a.Codigo_EPS) and g.Codigo_PLA=a.Codigo_PLA";
  }
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".FormatoFecha($row[0])."';
		document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[3]."';
		document.frm_form".$NumWindow.".txt_NombreEPS".$NumWindow.".value='".$row[4]."';
		document.frm_form".$NumWindow.".txt_NombrePlan".$NumWindow.".value='".$row[5]."';
		document.frm_form".$NumWindow.".txt_cama".$NumWindow.".value='".$row[6]."';
		document.frm_form".$NumWindow.".hdn_contrato".$NumWindow.".value='".$row[7]."';
		document.frm_form".$NumWindow.".hdn_plan".$NumWindow.".value='".$row[8]."';
		document.frm_form".$NumWindow.".hdn_tarifa".$NumWindow.".value='".$row[9]."';
		document.frm_form".$NumWindow.".txt_autorizaord".$NumWindow.".value='".$row[10]."';
		document.frm_form".$NumWindow.".txt_observacion".$NumWindow.".value='".preg_replace("/\r\n|\n|\r/", "<br/>",$row[11])."';
    document.frm_form".$NumWindow.".txt_pacienten".$NumWindow.".value='".$row[12]."';
		document.frm_form".$NumWindow.".txt_orden".$NumWindow.".focus();

	";
	}
	else {
		echo "
		MsgBox1('Ordenes de Servicio','no se encuentra el ingreso ".$_GET["Ingreso"]."');
		";
	}
	mysqli_free_result($result); 
	}
?>

function BuscarOrd<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  if ((document.getElementById('txt_orden<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_orden<?php echo $NumWindow; ?>').value=="0000000000")) {
  		document.frm_form<?php echo $NumWindow; ?>.txt_orden<?php echo $NumWindow; ?>.value='0000000000';
  		FechaActual('txt_fechaord<?php echo $NumWindow; ?>');
  		document.frm_form<?php echo $NumWindow; ?>.txt_area<?php echo $NumWindow; ?>.focus();
  	} else {
  		AbrirForm('application/forms/ordenesdeservicio.php', '<?php echo $NumWindow; ?>', '&Orden='+document.getElementById('txt_orden<?php echo $NumWindow; ?>').value);
  	}
  }
}

function NombreServicio<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreServicio(document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>' );
  }
}

function AgregarFila<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AgregarFilaOrden(document.frm_form<?php echo $NumWindow; ?>.txt_codigo<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.hdn_codigox<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_nombreserv<?php echo $NumWindow; ?>.value,document.frm_form<?php echo $NumWindow; ?>.txt_cantidad<?php echo $NumWindow; ?>.value, '<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.hdn_controw<?php echo $NumWindow; ?>.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>');	  
  }
}

function SearchOrd<?php echo $NumWindow; ?>(Dato) {
	if (Dato=="") {
	CargarSearch('ordenesdeservicio', 'txt_orden<?php echo $NumWindow; ?>', 'NULL');
	} else {
	CargarSearch('ordenesdeservicio', 'txt_orden<?php echo $NumWindow; ?>', 'LPAD(a.Codigo_ADM,10,*0*)=LPAD(*'+Dato+'*,10,*0*)');
	}
}

function BuscarIng<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
		AbrirForm('application/forms/ordenesdeservicio.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
  }
}
<?php
	if (isset($_GET["Orden"])) {	
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(a.Codigo_ADM,10,'0'), b.ID_TER, e.Nombre_TER, Nombre_PLA, Nombre_CAM, LPAD(Codigo_ORD,10,'0'), g.Codigo_ARE, date(Fecha_ORD), Descripcion_ORD, h.Codigo_EPS, h.Codigo_PLA, h.Codigo_TAR, Autorizacion_ORD, b.Nombre_TER from czterceros b, gxeps c, gxplanes d, czterceros e, gxordenescab g, gxcontratos h, gxadmision a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=e.Codigo_TER and trim(c.Codigo_EPS)=trim(a.Codigo_EPS) and d.Codigo_PLA=a.Codigo_PLA and a.Codigo_ADM=g.Codigo_ADM and Estado_ADM='I' and Estado_ORD<>'A' and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0') and trim(h.Codigo_EPS)=trim(a.Codigo_EPS) and h.Codigo_PLA=a.Codigo_PLA";
  if ((($_SESSION["it_CodigoPRF"]=="0") &&(substr($_SESSION["it_CodigoUSR"],0,2)=="NX"))||($_SESSION["it_CodigoUSR"]=="0")) {
	  $SQL="Select date(fecha_adm), time(fecha_adm), LPAD(a.Codigo_ADM,10,'0'), b.ID_TER, e.Nombre_TER, Nombre_PLA, Nombre_CAM, LPAD(Codigo_ORD,10,'0'), g.Codigo_ARE, date(Fecha_ORD), Descripcion_ORD, h.Codigo_EPS, h.Codigo_PLA, h.Codigo_TAR, Autorizacion_ORD, b.Nombre_TER from czterceros b, gxeps c, gxplanes d, czterceros e, gxordenescab g, gxcontratos h, gxadmision a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=e.Codigo_TER and trim(c.Codigo_EPS)=trim(a.Codigo_EPS) and d.Codigo_PLA=a.Codigo_PLA and a.Codigo_ADM=g.Codigo_ADM  and Estado_ORD<>'A' and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0') and trim(h.Codigo_EPS)=trim(a.Codigo_EPS) and h.Codigo_PLA=a.Codigo_PLA";
  }
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".FormatoFecha($row[0])."';
		document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[3]."';
		document.frm_form".$NumWindow.".txt_NombreEPS".$NumWindow.".value='".$row[4]."';
		document.frm_form".$NumWindow.".txt_NombrePlan".$NumWindow.".value='".$row[5]."';
		document.frm_form".$NumWindow.".txt_cama".$NumWindow.".value='".$row[6]."';
		document.frm_form".$NumWindow.".txt_orden".$NumWindow.".value='".$row[7]."';
		document.frm_form".$NumWindow.".txt_area".$NumWindow.".value='".$row[8]."';
		document.frm_form".$NumWindow.".txt_fechaord".$NumWindow.".value='".($row[9])."';
		document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".value='".$row[10]."';
		document.frm_form".$NumWindow.".txt_autorizaord".$NumWindow.".value='".$row[14]."';
    document.frm_form".$NumWindow.".txt_pacienten".$NumWindow.".value='".$row[15]."';
		document.frm_form".$NumWindow.".hdn_contrato".$NumWindow.".value='".$row[11]."';
		document.frm_form".$NumWindow.".hdn_plan".$NumWindow.".value='".$row[12]."';
		document.frm_form".$NumWindow.".hdn_tarifa".$NumWindow.".value='".$row[13]."';
	";
	}
	else {
		echo "
		MsgBox1('Ordenes de Servicio','No se encuentra activa la orden ".$_GET["Orden"]."');
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
