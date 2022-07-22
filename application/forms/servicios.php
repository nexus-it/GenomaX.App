<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<div class="col-md-12">
<label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> General</label>
	<div class="row well well-sm">

	<div class="col-md-1">
<div class="form-group">
<label for="txt_tiposervicio<?php echo $NumWindow; ?>">Tipo:</label>
<select name="txt_tiposervicio<?php echo $NumWindow; ?>" id="txt_tiposervicio<?php echo $NumWindow; ?>"  onChange="javascript:ShowHideServicios(document.frm_form<?php echo $NumWindow; ?>.txt_tiposervicio<?php echo $NumWindow; ?>.value, '<?php echo $NumWindow; ?>');">
  <option value="1" selected>Servicio</option>
  <option value="2">Producto</option>
  <option value="3">Paquete</option>
</select>
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
	<label for="txt_codigoprod<?php echo $NumWindow; ?>">Codigo</label>
	<div class="input-group">	
		<input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="6" maxlength="6" onkeypress="BuscarServ<?php echo $NumWindow; ?>(event);" >
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ServiciosX" onclick="javascript:CargarSearch('ServiciosX'+document.frm_form<?php echo $NumWindow; ?>.txt_tiposervicio<?php echo $NumWindow; ?>.value, 'txt_codigo<?php echo $NumWindow; ?>', 'Tipo_SER=*'+document.frm_form<?php echo $NumWindow; ?>.txt_tiposervicio<?php echo $NumWindow; ?>.value+'*');"><i class="fas fa-search"></i></button>
		</span>
	</div>
</div>
	</div>
	<div class="col-md-4">
<div class="form-group">
<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" size="25">
</div>
	</div>
	<div class="col-md-3">
<div class="form-group">
<label for="txt_conceptofact<?php echo $NumWindow; ?>">Concepto Facturacion</label>
<select name="txt_conceptofact<?php echo $NumWindow; ?>" id="txt_conceptofact<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_CFC, Nombre_CFC from gxconceptosfactura order by Codigo_CFC";
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
	<div class="col-md-1">
<div class="form-group">
<label for="txt_complejidad<?php echo $NumWindow; ?>">Complejidad</label>
<input name="txt_complejidad<?php echo $NumWindow; ?>" type="number" id="txt_complejidad<?php echo $NumWindow; ?>" value="2" min="1" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
  <option value="1" selected>Activo</option>
  <option value="0">Inactivo</option>
</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_edadminima<?php echo $NumWindow; ?>">Edad Mínima</label>
<input name="txt_edadminima<?php echo $NumWindow; ?>" type="number" id="txt_edadminima<?php echo $NumWindow; ?>" value="0" min="0" max="80">
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_edadminmed<?php echo $NumWindow; ?>">Medida</label>
<select name="txt_edadminmed<?php echo $NumWindow; ?>" id="txt_edadminmed<?php echo $NumWindow; ?>">
  <option value="1" selected>Días</option>
  <option value="30">Meses</option>
  <option value="365">Años</option>
</select>
</div>
	</div>
	
	<div class="col-md-1">
<div class="form-group">
<label for="txt_edadmaxima<?php echo $NumWindow; ?>">Edad Máxima</label>
<input name="txt_edadmaxima<?php echo $NumWindow; ?>" type="number" id="txt_edadmaxima<?php echo $NumWindow; ?>" value="120" min="0" max="150"> 
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_edadmaxmed<?php echo $NumWindow; ?>">Medida</label>
<select name="txt_edadmaxmed<?php echo $NumWindow; ?>" id="txt_edadmaxmed<?php echo $NumWindow; ?>">
  <option value="1" >Días</option>
  <option value="30">Meses</option>
  <option value="365" selected>Años</option>
</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_masculino<?php echo $NumWindow; ?>">Masculino</label>
<select name="txt_masculino<?php echo $NumWindow; ?>" id="txt_masculino<?php echo $NumWindow; ?>">
  <option value="1" selected>SI</option>
  <option value="0">NO</option>
</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_femenino<?php echo $NumWindow; ?>">Femenino</label>
<select name="txt_femenino<?php echo $NumWindow; ?>" id="txt_femenino<?php echo $NumWindow; ?>">
  <option value="1" selected>SI</option>
  <option value="0">NO</option>
</select>
</div>
	</div>
	
	</div> 
</div>
<div class="col-md-12" id="div_servicios<?php echo $NumWindow; ?>">
<label class="label label-default"> Datos Servicio:</label>
	<div class="row well well-sm">

	<div class="col-md-2">
<div class="form-group">
	<label for="txt_quirurgico<?php echo $NumWindow; ?>">Tipo Servicio</label>
	<select name="txt_quirurgico<?php echo $NumWindow; ?>" id="txt_quirurgico<?php echo $NumWindow; ?>" onchange="ProcQx('<?php echo $NumWindow; ?>', this.value);">
	  <option value="1" >Procedimiento Quirúrgico</option>
	  <option value="0" selected>Servicio NO Quirúrgico</option>
	</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_cups2<?php echo $NumWindow; ?>">CUPS</label>
<input name="txt_cups2<?php echo $NumWindow; ?>" type="text" id="txt_cups2<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_iss2000<?php echo $NumWindow; ?>">ISS 2000</label>
<input name="txt_iss2000<?php echo $NumWindow; ?>" type="text" id="txt_iss2000<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_iss2001<?php echo $NumWindow; ?>">ISS 2001</label>
<input name="txt_iss2001<?php echo $NumWindow; ?>" type="text" id="txt_iss2001<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_soat<?php echo $NumWindow; ?>">SOAT</label>
<input name="txt_soat<?php echo $NumWindow; ?>" type="text" id="txt_soat<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_mapipos<?php echo $NumWindow; ?>">MAPIPOS</label>
<input name="txt_mapipos<?php echo $NumWindow; ?>" type="text" id="txt_mapipos<?php echo $NumWindow; ?>" ">
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_uvr<?php echo $NumWindow; ?>">UVR</label>
<input name="txt_uvr<?php echo $NumWindow; ?>" type="text" id="txt_uvr<?php echo $NumWindow; ?>" value="0" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_gruposoat<?php echo $NumWindow; ?>">Grupo SOAT</label>
<input name="txt_gruposoat<?php echo $NumWindow; ?>" type="number" id="txt_gruposoat<?php echo $NumWindow; ?>" value="0" min="0" >
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_puntossoat<?php echo $NumWindow; ?>">Puntos SOAT</label>
<input name="txt_puntossoat<?php echo $NumWindow; ?>" type="number" id="txt_puntossoat<?php echo $NumWindow; ?>" value="0" min="0">
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
	<label for="cmb_tipoqx<?php echo $NumWindow; ?>">Pertenece a Proc. Qx?</label>
	<select name="cmb_tipoqx<?php echo $NumWindow; ?>" id="cmb_tipoqx<?php echo $NumWindow; ?>" >
	  <option value="0" selected >No Pertenece</option>
	  <option value="Sala_PRC">Derecho de Sala</option>
	  <option value="Material_PRC">Materiales y Sutura</option>
	  <option value="Especialista_PRC">Médico Especialista</option>
	  <option value="Anestesiologo_PRC">Médico Anestesiólogo</option>
	  <option value="Ayudante_PRC">Médico Ayudante</option>
	</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_uvrmin<?php echo $NumWindow; ?>">UVR Mínimo</label>
<input name="txt_uvrmin<?php echo $NumWindow; ?>" type="number" id="txt_uvrmin<?php echo $NumWindow; ?>" value="0" min="0">
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_uvrmax<?php echo $NumWindow; ?>">UVR Máximo</label>
<input name="txt_uvrmax<?php echo $NumWindow; ?>" type="number" id="txt_uvrmax<?php echo $NumWindow; ?>" value="0" min="0">
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
<label for="cmb_tercerizar<?php echo $NumWindow; ?>">Orden de Servicio</label>
<select name="cmb_tercerizar<?php echo $NumWindow; ?>" id="cmb_tercerizar<?php echo $NumWindow; ?>">
  <option value="0" selected>Institucional</option>
  <option value="1">Tercero</option>
</select>
</div>
	</div>
	<div class="col-md-4">
<div class="form-group">
<label for="txt_nombresoat<?php echo $NumWindow; ?>">Nombre SOAT</label>
<input name="txt_nombresoat<?php echo $NumWindow; ?>" type="text" id="txt_nombresoat<?php echo $NumWindow; ?>" >
</div>
	</div>
	

	</div>
</div>
<div class="col-md-12" id="div_productos<?php echo $NumWindow; ?>">
<label class="label label-default"> Datos Producto:</label>
	<div class="row well well-sm">

	<div class="col-md-2">
<div class="form-group">
<label for="txt_codigoprod<?php echo $NumWindow; ?>">Codigo Producto</label>
<input name="txt_codigoprod<?php echo $NumWindow; ?>" type="text" id="txt_codigoprod<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
<label for="txt_cum<?php echo $NumWindow; ?>">CUM</label>
<input name="txt_cum<?php echo $NumWindow; ?>" type="text" id="txt_cum<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
<label for="txt_cups<?php echo $NumWindow; ?>">CUPS</label>
<input name="txt_cups<?php echo $NumWindow; ?>" type="text" id="txt_cups<?php echo $NumWindow; ?>" >
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
<label for="txt_disp<?php echo $NumWindow; ?>">Cambio de Dispositivo</label>
<select name="txt_disp<?php echo $NumWindow; ?>" id="txt_disp<?php echo $NumWindow; ?>">
	<option value="0">NO</option>
	<option value="1">SI</option>
</select>
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
<label for="txt_concentracion<?php echo $NumWindow; ?>">Concentración</label>
<input name="txt_concentracion<?php echo $NumWindow; ?>" type="text" id="txt_concentracion<?php echo $NumWindow; ?>"  value="0">
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
<label for="txt_medida<?php echo $NumWindow; ?>">Unidad de Medida</label>
<select name="txt_medida<?php echo $NumWindow; ?>" id="txt_medida<?php echo $NumWindow; ?>">
<?php 
	$SQL="Select Codigo_UNM, Descripcion_UNM from gxunidadmed order by 2";
	$result = mysqli_query($conexion, $SQL);
	while ($row = mysqli_fetch_array($result)) {
		echo '<option value="'.$row[0].'">'.$row[1].'</option>';
	}
	mysqli_free_result($result); 
?>
</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_via<?php echo $NumWindow; ?>">Vía Admon.</label>
<select name="txt_via<?php echo $NumWindow; ?>" id="txt_via<?php echo $NumWindow; ?>">
<?php 
	$SQL="Select Codigo_VIA, Descripcion_VIA from gxviasmed order by 2";
	$result = mysqli_query($conexion, $SQL);
	while ($row = mysqli_fetch_array($result)) {
		echo '<option value="'.$row[0].'">'.$row[1].'</option>';
	}
	mysqli_free_result($result); 
?>
</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
<label for="txt_invent<?php echo $NumWindow; ?>">Inventario</label>
<select name="txt_invent<?php echo $NumWindow; ?>" id="txt_invent<?php echo $NumWindow; ?>">
	<option value="1">SI</option>
	<option value="0">NO</option>
</select>
</div>
	</div>
	<div class="col-md-6">
<div class="form-group">
<label for="txt_ppioactivo<?php echo $NumWindow; ?>">Principio Activo</label>
<input name="txt_ppioactivo<?php echo $NumWindow; ?>" type="text" id="txt_ppioactivo<?php echo $NumWindow; ?>" >
</div>
	</div>

	</div>
</div>
<div class="col-md-12" id="div_paquete<?php echo $NumWindow; ?>">
<label class="label label-default"> Detalle Paquete:</label>
	<div class="row well well-sm">
	<div class="col-md-1">
  <div class="form-group">
  <label for="txt_codigopq<?php echo $NumWindow; ?>">Código</label>
  <input name="txt_codigopq<?php echo $NumWindow; ?>" type="text" id="txt_codigopq<?php echo $NumWindow; ?>" onblur="NombreServiciopq<?php echo $NumWindow; ?>();" onkeypress="NombreServiciopq0<?php echo $NumWindow; ?>(event);"  />
  </div>
    </div>
    <div class="col-md-7">
  <div class="form-group">
  <label for="lbl_servicionom<?php echo $NumWindow; ?>">Descripción</label>
  <input name="lbl_servicionom<?php echo $NumWindow; ?>" type="text" id="lbl_servicionom<?php echo $NumWindow; ?>" placeholder="Ingrese las palabras clave para la búsqueda" class="typeahead" />
  </div>
    </div>

    <div class="col-md-2">
  <div class="form-group">
  <label for="txt_cant<?php echo $NumWindow; ?>">Cantidad</label>
  <input name="txt_cant<?php echo $NumWindow; ?>" type="number" id="txt_cant<?php echo $NumWindow; ?>" value="1" min="1" />
  </div>
    </div>
    <div class="col-md-2 ">
      <button class="btn btn-success btn-md btn-block" type="button" onclick="javascript:AgregarFilaPQ<?php echo $NumWindow; ?>();" style="height: 35px; margin-top: 25px;margin-left: 15px;"> <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>  Agregar Ítem
      </button>
    </div>
	<div class="table-responsive detalleord col-md-12" >
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="table table-striped table-condensed tblDetalle table-bordered" id="tbPQX<?php echo $NumWindow; ?>" name="tbPQX<?php echo $NumWindow; ?>">
        <tbody style="font-size: 12px;">
          <tr><th >Codigo</th><th>Ítem</th><th>Cantidad</th><th>ELIMINAR</th></tr>
          <?php 
          $TotalFpq=0;
          if (isset($_GET["Servicio"])) {	
	          $SQL="Select Codigo_PQT, Nombre_SER, Cantidad_PQT from gxpaquetes a, gxservicios b where a.Codigo_PQT=b.Codigo_SER and a.Codigo_SER='".$_GET["Servicio"]."' Order By 2";
	          $result = mysqli_query($conexion, $SQL);
	          while($row = mysqli_fetch_array($result)) 
	            {
	            	$TotalFpq++;
	                echo '<tr id="tr'.$TotalFpq.$NumWindow.'">
	                <td><input name="hdn_codigopqt'.$TotalFpq.$NumWindow.'" type="hidden" id="hdn_codigopqt'.$TotalFpq.$NumWindow.'" value="'.$row[0].'" />'.$row[0].'</td><td>'.$row[1].'</td><td><input name="hdn_cantpqt'.$TotalFpq.$NumWindow.'" type="hidden" id="hdn_cantpqt'.$TotalFpq.$NumWindow.'" value="'.$row[2].'" />'.$row[2].'</td><td align="center"><button onclick="EliminarFilaPQ'.$NumWindow.'(\''.$TotalFpq.'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button></td>
	                </tr>';
	            }
	            mysqli_free_result($result);
        	}
          ?>
        </tbody>
      </table>
      <input type="hidden" name="hdn_controwPq<?php echo $NumWindow; ?>" id="hdn_controwPq<?php echo $NumWindow; ?>" value="<?php echo $TotalFpq; ?>">
    </div>    
	</div>
	
</div>
<?php
if (isset($_GET["Mode"])) {
	echo '<button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Guardar_servicios2(\''.$NumWindow.'\');" data-dismiss="modal" ><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Guardar</button>';
}
?>
</form>
<script src="functions/nexus/servicios.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
<script>
ShowHideServicios("1", "<?php echo $NumWindow; ?>");
ProcQx('<?php echo $NumWindow; ?>', '0');
<?php
	if (isset($_GET["Mode"])) {
		echo 'ShowHideServicios("2", "'.$NumWindow.'");
		document.getElementById("txt_tiposervicio'.$NumWindow.'").disabled = true;';
	}
	if (isset($_GET["Servicio"])) {	
	$TipoServ=0;
	$SQL="Select LPAD(Codigo_SER,6,'0'), Nombre_SER, Tipo_SER, Codigo_CFC, case  when EdadMinima_SER < 30 then EdadMinima_SER when EdadMinima_SER> 360 then EdadMinima_SER/365 else EdadMinima_SER/30 END, case   when EdadMaxima_SER< 30 then EdadMaxima_SER when EdadMaxima_SER> 360 then EdadMaxima_SER/365 else EdadMaxima_SER/30 end, SexoM_SER, SexoF_SER, Complejidad_SER, Estado_SER, case  when EdadMinima_SER < 30 then '1' when EdadMinima_SER> 360 then '365' else '30' END, case  when EdadMaxima_SER < 30 then '1' when EdadMaxima_SER> 360 then '365' else '30' END From gxservicios where LPAD(Codigo_SER,6,'0')=LPAD('".$_GET["Servicio"]."',6,'0')";
	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_tiposervicio".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_conceptofact".$NumWindow.".value='".$row[3]."';
		document.frm_form".$NumWindow.".txt_edadminima".$NumWindow.".value='".intval($row[4])."';
		document.frm_form".$NumWindow.".txt_edadmaxima".$NumWindow.".value='".intval($row[5])."';
		document.frm_form".$NumWindow.".txt_masculino".$NumWindow.".value='".$row[6]."';
		document.frm_form".$NumWindow.".txt_femenino".$NumWindow.".value='".$row[7]."';
		document.frm_form".$NumWindow.".txt_complejidad".$NumWindow.".value='".$row[8]."';
		document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$row[9]."';
		document.frm_form".$NumWindow.".txt_edadminmed".$NumWindow.".value='".$row[10]."';
		document.frm_form".$NumWindow.".txt_edadmaxmed".$NumWindow.".value='".$row[11]."';
	";
	$TipoServ=$row[2];
	}
	else {
		echo "
		MsgBox1('Servicios','No se encuentra el servicio ".$_GET["Servicio"]."');
		";
	}
	mysqli_free_result($result); 
	echo 'ShowHideServicios("'.$TipoServ.'", "'.$NumWindow.'");';
	if ($TipoServ=="2") {
		$SQL="Select Codigo_MED, CUPS_MED, CUM_MED, Dispositivo_MED, Concentracion_MED, Codigo_UNM, Codigo_VIA, Inventario_MED, PpioActivo_MED from gxmedicamentos where LPAD(Codigo_SER,6,'0')=LPAD('".$_GET["Servicio"]."',6,'0')";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_codigoprod".$NumWindow.".value='".$row[0]."';
			document.frm_form".$NumWindow.".txt_cum".$NumWindow.".value='".$row[2]."';
			document.frm_form".$NumWindow.".txt_cups".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_disp".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".txt_concentracion".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".txt_medida".$NumWindow.".value='".$row[5]."';
			document.frm_form".$NumWindow.".txt_via".$NumWindow.".value='".$row[6]."';
			document.frm_form".$NumWindow.".txt_invent".$NumWindow.".value='".$row[7]."';
			document.frm_form".$NumWindow.".txt_ppioactivo".$NumWindow.".value='".$row[8]."';
		";
		}
		mysqli_free_result($result); 
	}
	
	//colocar aca el llenado de campos para tiposervicio=1
	if ($TipoServ=="1") {
		$SQL="Select CUPS_PRC, ISS2001_PRC, ISS2000_PRC, SOAT_PRC, MAPIPOS_PRC, UVR_PRC, GRUPOSOAT_PRC, Procedimiento_PRC, UVRMin_PRC, UVRMax_PRC, Sala_PRC, Material_PRC, Especialista_PRC, Anestesiologo_PRC, Ayudante_PRC, PuntosSOAT_PRC, Tercerizar_PRC, NombreSOAT_PRC from gxprocedimientos where LPAD(Codigo_SER,6,'0')=LPAD('".$_GET["Servicio"]."',6,'0')";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
		$rdntipo='0';
		if ($row[10]==1) {
			$rdntipo='Sala_PRC';}
		if ($row[11]==1) {
			$rdntipo='Material_PRC';}
		if ($row[12]==1) {
			$rdntipo='Especialista_PRC';}
		if ($row[13]==1) {
			$rdntipo='Anestesiologo_PRC';}
		if ($row[14]==1) {
			$rdntipo='Ayudante_PRC';}

		echo "
			document.frm_form".$NumWindow.".txt_cups2".$NumWindow.".value='".$row[0]."';
			document.frm_form".$NumWindow.".txt_iss2000".$NumWindow.".value='".$row[2]."';
			document.frm_form".$NumWindow.".txt_iss2001".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_soat".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".txt_mapipos".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".txt_quirurgico".$NumWindow.".value='".$row[7]."';
			document.frm_form".$NumWindow.".txt_uvr".$NumWindow.".value='".$row[5]."';
			document.frm_form".$NumWindow.".txt_gruposoat".$NumWindow.".value='".$row[6]."';
			document.frm_form".$NumWindow.".cmb_tipoqx".$NumWindow.".value='".$rdntipo."';
			document.frm_form".$NumWindow.".txt_uvrmin".$NumWindow.".value='".$row[8]."';
			document.frm_form".$NumWindow.".cmb_tercerizar".$NumWindow.".value='".$row[16]."';
			document.frm_form".$NumWindow.".txt_uvrmax".$NumWindow.".value='".$row[9]."';
			document.frm_form".$NumWindow.".txt_puntossoat".$NumWindow.".value='".$row[15]."';
			document.frm_form".$NumWindow.".txt_nombresoat".$NumWindow.".value='".$row[17]."';
		";
		}
		mysqli_free_result($result); 
	}
	
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function NombreServiciopq0<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	 NombreServiciopq<?php echo $NumWindow; ?>();
  }
}

function NombreServiciopq<?php echo $NumWindow; ?>() {
  NombreServicioPQ('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_codigopq<?php echo $NumWindow; ?>.value);
}

function cambiarcheck<?php echo $NumWindow; ?>() {
	if(document.getElementById('txt_quirurgico<?php echo $NumWindow; ?>').checked) {
		document.frm_form<?php echo $NumWindow; ?>.txt_quirurgico<?php echo $NumWindow; ?>.value='1';
	} else {
		document.frm_form<?php echo $NumWindow; ?>.txt_quirurgico<?php echo $NumWindow; ?>.value='0';
	}
}

function BuscarServ<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if ((document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="000000")) {
		document.frm_form<?php echo $NumWindow; ?>.txt_codigo<?php echo $NumWindow; ?>.value='000000';
		document.frm_form<?php echo $NumWindow; ?>.txt_nombre<?php echo $NumWindow; ?>.focus();
	} else {
		AbrirForm('application/forms/servicios.php', '<?php echo $NumWindow; ?>', '&Servicio='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

function EliminarFilaPQ<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#tr'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AgregarFilaPQ<?php echo $NumWindow; ?>()  {
	var CodigoPQT = document.getElementById("txt_codigopq<?php echo $NumWindow; ?>").value; 
	var NombrePQT = document.getElementById("lbl_servicionom<?php echo $NumWindow; ?>").value; 
	var CantPQT = document.getElementById("txt_cant<?php echo $NumWindow; ?>").value; 
	if ((CodigoPQT!="")&& (NombrePQT!="")){	
		TotalFilas=document.getElementById("hdn_controwPq<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbPQX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda0 = document.createElement("td"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda0.innerHTML = '<input name="hdn_codigopqt'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigopqt'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodigoPQT+''+'" /> '+CodigoPQT; 
		celda1.innerHTML = NombrePQT; 
		celda2.innerHTML = '<input name="hdn_cantpqt'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantpqt'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantPQT+'" /> '+CantPQT; 
		celda3.innerHTML = '<button onclick="EliminarFilaPQ<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda0); 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    miTabla.appendChild(fila); 
		document.getElementById('txt_codigopq<?php echo $NumWindow; ?>').value="";
		document.getElementById("hdn_controwPq<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('lbl_servicionom<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codigopq<?php echo $NumWindow; ?>').focus();
		document.getElementById('lbl_servicionom<?php echo $NumWindow; ?>').focus();
	}
}

var substringMatcher<?php echo $NumWindow; ?> = function(strs) {
  return function findMatches<?php echo $NumWindow; ?>(q, cb) {
    var matches, substringRegex;
    matches = [];
    substrRegex = new RegExp(q, 'i');
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });
    cb(matches);
  };
};
/* 
<?php
$nombres="";
$SQL="SELECT trim(a.Nombre_SER) FROM gxservicios a WHERE a.Estado_SER='1' AND a.Codigo_CFC<>'04' ORDER BY 1";
$result = mysqli_query($conexion, $SQL);
  while ($rowx=mysqli_fetch_array(($result))) {
    $nombres=$nombres."'".$rowx[0]."',";
  }
  mysqli_free_result($result);
  $nombres=$nombres."''";
?>
var nombres<?php echo $NumWindow; ?> = [<?php echo $nombres; ?>];
$('#lbl_servicionom<?php echo $NumWindow; ?>').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'nombres<?php echo $NumWindow; ?>',
  source: substringMatcher<?php echo $NumWindow; ?>(nombres<?php echo $NumWindow; ?>)
  }).on('typeahead:selected', function(e) {
    var result = $('#lbl_servicionom<?php echo $NumWindow; ?>').val();
    $('#txt_codigopq<?php echo $NumWindow; ?>').val('');
    CodigoServicioPQ('<?php echo $NumWindow; ?>', result);
}); */


	$("form").addClass("form-horizontal container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$(".twitter-typeahead").addClass("form-control");

</script>
