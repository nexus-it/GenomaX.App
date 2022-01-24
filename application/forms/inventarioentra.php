<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>">
	<div class="row well well-sm">
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_Ingreso<?php echo $NumWindow; ?>">Entrada No.</label>
	  <div class="input-group">
	  <input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('InventarioEntra', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ENT=*1*')};" value="0"/>
	  	<span class="input-group-btn">
	  		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('InventarioEntra', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ENT=*1*');"><i class="fas fa-search"></i></button>
	  	</span>
	  </div>		
	</div>

		</div>
		<div class="col-md-3">
	
	<div class="form-group">
	  <label for="cmb_concepto<?php echo $NumWindow; ?>">Concepto</label>
	  <select name="cmb_concepto<?php echo $NumWindow; ?>" id="cmb_concepto<?php echo $NumWindow; ?>">
	<?php 
	$SQL="Select Codigo_CEN, Nombre_CEN from czconceptosent where Estado_CEN='1' order by Codigo_CEN";
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
		<div class="col-md-3">
	
	<div class="form-group">
	  <label for="cmb_bodega<?php echo $NumWindow; ?>">Bodega</label>
	  <select name="cmb_bodega<?php echo $NumWindow; ?>" id="cmb_bodega<?php echo $NumWindow; ?>">
	<?php 
	$SQL="Select Codigo_BDG, Nombre_BDG from czbodegas where Estado_BDG='1' order by Codigo_BDG";
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
	  <label for="txt_fechaent<?php echo $NumWindow; ?>">Fecha Entrada</label>
	  <input name="txt_fechaent<?php echo $NumWindow; ?>" type="date"  id="txt_fechaent<?php echo $NumWindow; ?>" >
	</div> 

		</div>
		<div class="col-md-2">
	
	<div class="form-group">
	  <label for="txt_fechainsp<?php echo $NumWindow; ?>">Fecha Inspección</label>
	  <input name="txt_fechainsp<?php echo $NumWindow; ?>" type="date"  id="txt_fechainsp<?php echo $NumWindow; ?>" >
	</div> 
	
	</div>
	<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_compra<?php echo $NumWindow; ?>" title="Orden de Compra">O.C. No.</label>
	  <div class="input-group">
	  	<input name="txt_compra<?php echo $NumWindow; ?>" type="text" id="txt_compra<?php echo $NumWindow; ?>" size="5" maxlength="10" onkeypress="BuscarOrd<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Compra', 'txt_compra<?php echo $NumWindow; ?>', 'Estado_CMP=*1*');" disabled="disabled" value="0"/>
	  		<span class="input-group-btn">
	  		    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Compra" onclick="javascript:CargarSearch('Compra', 'txt_compra<?php echo $NumWindow; ?>', 'Estado_CMP=*1*');"><i class="fas fa-search"></i></button>
	  		</span>
	  </div>	
	</div>

		</div>
		<div class="col-md-2">
	
	<div class="form-group">
		<label for="txt_idproveedor<?php echo $NumWindow; ?>">ID</label>
		<div class="input-group">	
			<input name="txt_idproveedor<?php echo $NumWindow; ?>" id="txt_idproveedor<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarProv<?php echo $NumWindow; ?>(event);" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'czproveedores')" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Proveedor" onclick="javascript:CargarSearch('Proveedor', 'txt_idproveedor<?php echo $NumWindow; ?>', 'Estado_PRV=*1*');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>

		</div>
		<div class="col-md-5">
	<div class="form-group">
	<label for="txt_fechainsp<?php echo $NumWindow; ?>">Tercero</label>
	<input name="txt_fechainsp<?php echo $NumWindow; ?>" type="text"  id="txt_fechainsp<?php echo $NumWindow; ?>" >
	</div>
		</div>
	

	<div class="col-md-2">

	<div class="form-group">
	  <label for="cmb_tipodoc<?php echo $NumWindow; ?>">Documento</label>
	  <select name="cmb_tipodoc<?php echo $NumWindow; ?>" id="cmb_tipodoc<?php echo $NumWindow; ?>">
		  <option value="F">Factura</option>
		  <option value="R">Remisión</option>
		  <option value="0">Ninguno</option>
	  </select>
	</div>
	
	</div>
	<div class="col-md-1">

	<div class="form-group">
	  <label for="txt_numdoc<?php echo $NumWindow; ?>">Número</label>
	  <input name="txt_numdoc<?php echo $NumWindow; ?>" type="text"  id="txt_numdoc<?php echo $NumWindow; ?>" size="10" maxlength="50">  
	</div> 

		</div>
		<div class="col-md-12">

	<div class="form-group">
	  <label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
	<textarea name="txt_observacion<?php echo $NumWindow; ?>" cols="60" rows="3" id="txt_observacion<?php echo $NumWindow; ?>" ></textarea>
    </div>

		</div>
</div>

<div class="row well well-sm">



	<div class="col-md-2">
<div class="form-group">
  <label for="txt_producto<?php echo $NumWindow; ?>">Codigo</label>
	<div class="input-group">
	   <input name="txt_producto<?php echo $NumWindow; ?>" type="text" id="txt_producto<?php echo $NumWindow; ?>" onkeypress="NombreServicio<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('ServiciosX2', 'txt_producto<?php echo $NumWindow; ?>', 'Tipo_SER=*2*')};" />
		 <span class="input-group-btn">
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Servicios" onclick="javascript:CargarSearch('ServiciosX2', 'txt_producto<?php echo $NumWindow; ?>', 'Tipo_SER=*2*');"><i class="fas fa-search"></i></button>
		 </span>
	</div>
</div>
	</div>
	<div class="col-md-8">

<div class="form-group">
<label for="txt_nombreserv<?php echo $NumWindow; ?>">Producto</label>
<input name="txt_nombreserv<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_nombreserv<?php echo $NumWindow; ?>"  />
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
	<label for="txt_cantidad<?php echo $NumWindow; ?>">Cant.</label>
	<input name="txt_cantidad<?php echo $NumWindow; ?>" type="number" id="txt_cantidad<?php echo $NumWindow; ?>"  onkeypress="AgregarFila<?php echo $NumWindow; ?>(event);"/>
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_presentacion<?php echo $NumWindow; ?>">Presentacion</label>
  <input name="txt_presentacion<?php echo $NumWindow; ?>" type="text"  id="txt_presentacion<?php echo $NumWindow; ?>"  maxlength="30">
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_laboratorio<?php echo $NumWindow; ?>">Laboratorio</label>
  <input name="txt_laboratorio<?php echo $NumWindow; ?>" type="text"  id="txt_laboratorio<?php echo $NumWindow; ?>"  maxlength="30">
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_lote<?php echo $NumWindow; ?>">Lote No.</label>
  <input name="txt_lote<?php echo $NumWindow; ?>" type="text"  id="txt_lote<?php echo $NumWindow; ?>"  maxlength="30">
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_vencimiento<?php echo $NumWindow; ?>">Fecha Vence</label>
  <input name="txt_vencimiento<?php echo $NumWindow; ?>" type="date"  id="txt_vencimiento<?php echo $NumWindow; ?>" >
</div> 
	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_invima<?php echo $NumWindow; ?>">Reg. Invima</label>
  <input name="txt_invima<?php echo $NumWindow; ?>" type="text"  id="txt_invima<?php echo $NumWindow; ?>"  maxlength="30">
</div> 
	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="cmb_riesgo<?php echo $NumWindow; ?>">Riesgo</label>
  <select name="cmb_riesgo<?php echo $NumWindow; ?>" id="cmb_riesgo<?php echo $NumWindow; ?>">
	  <option value="Clase I">Clase I</option>
	  <option value="Clase II">Clase II</option>
	  <option value="Clase III">Clase III</option>
	  <option value="Clase IV">Clase IV</option>
  </select>
</div> 
	</div>
	<div class="col-md-12">
		<button class="btn btn-success btn-block btn-sm" type="button" onclick="javascript:AgregarFila2<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i> Agregar</button>
	</div>
</div>
<div class="row well well-sm">
	<div class="col-md-12">

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" >
<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
          <th id="th1<?php echo $NumWindow; ?>">Codigo</td> 
          <th id="th2<?php echo $NumWindow; ?>">Servicio</td> 
          <th id="th2<?php echo $NumWindow; ?>">Presentacion</td> 
          <th id="th2<?php echo $NumWindow; ?>">Laboratorio</td> 
          <th id="th2<?php echo $NumWindow; ?>">Lote No.</td> 
          <th id="th2<?php echo $NumWindow; ?>">Vencimiento</td> 
          <th id="th2<?php echo $NumWindow; ?>">Reg. Invima</td> 
          <th id="th2<?php echo $NumWindow; ?>">Riesgo</td> 
          <th id="th3<?php echo $NumWindow; ?>">Cantidad</td> 
          <th id="th4<?php echo $NumWindow; ?>">X</td> 
     </tr> 
<?php 
	if (isset($_GET["Orden"])) {
	$SQL="Select a.Codigo_SER, CUPS_PRC, Nombre_SER, Cantidad_ORD from gxservicios a, gxordenesdet b, gxprocedimientos c Where c.Codigo_SER=b.Codigo_SER  AND a.Codigo_SER=b.Codigo_SER and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0') 
	Union 
	Select a.Codigo_SER, CUM_MED, Nombre_SER, Cantidad_ORD from gxservicios a, gxordenesdet b, gxmedicamentos c Where c.Codigo_SER=b.Codigo_SER  AND a.Codigo_SER=b.Codigo_SER and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0')";
	$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		echo '  <tr id="tr'.$contarow.$NumWindow.'">
    <td><input name="hdn_codigoser'.$contarow.$NumWindow.'" type="hidden" id="hdn_codigoser'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td>
    <td>'.$row[2].'</td>
    <td align="center"><input name="hdn_cantidadser'.$contarow.$NumWindow.'" type="hidden" id="hdn_cantidadser'.$contarow.$NumWindow.'" value="'.$row[3].'" />'.$row[3].'</td>
    <td align="center"><a href="javascript:EliminarFilaOrden(\''.$contarow.'\',\''.$NumWindow.'\');"><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar servicio de la orden" /></a></td>
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
</div>
</form>
<script >

$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();
FechaActual('txt_fechaent<?php echo $NumWindow; ?>');
FechaActual('txt_fechainsp<?php echo $NumWindow; ?>');
<?php
	if (isset($_GET["Ingreso"])) {	
	$SQL="Select Codigo_ENT, Fecha_ENT, FechaInspeccion_ENT, ID_TER, Nombre_TER, Observaciones_ENT, Codigo_CMP, Codigo_BDG From czinventradascab a, czterceros b Where '".$_GET["Ingreso"]." and Estado_ENT=1 and a.Proveedor_ENT=b.Codigo_TER";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row['Codigo_ENT']."';
		document.frm_form".$NumWindow.".cmb_concepto".$NumWindow.".value='".$row['Codigo_CEN']."';
		document.frm_form".$NumWindow.".txt_fechaent".$NumWindow.".value='".($row['Fecha_ENT'])."';
		document.frm_form".$NumWindow.".txt_fechainsp".$NumWindow.".value='".($row['FechaInspeccion_ENT'])."';
		document.frm_form".$NumWindow.".txt_compra".$NumWindow.".value='".$row['Codigo_CMP']."';
		document.frm_form".$NumWindow.".cmb_bodega".$NumWindow.".value='".$row['Codigo_BDG']."';
		document.frm_form".$NumWindow.".txt_idproveedor".$NumWindow.".value='".$row['ID_TER']."';
		document.frm_form".$NumWindow.".txt_nomproveedor".$NumWindow.".value='".$row['Nombre_TER']."';
		document.frm_form".$NumWindow.".txt_observacion".$NumWindow.".value='".preg_replace("/\r\n|\n|\r/", "<br/>",$row['Observaciones_ENT'])."';
		document.frm_form".$NumWindow.".txt_producto".$NumWindow.".focus();
	";
	}
	else {
		echo "
		MsgBox1('Entrada a Almacen','No se encuentra el documento ".$_GET["Ingreso"]."');
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='0';
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
		AbrirForm('application/forms/inventarioentra.php', '<?php echo $NumWindow; ?>', '&Orden='+document.getElementById('txt_orden<?php echo $NumWindow; ?>').value);
	}
  }
}

function NombreServicio<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreServicio(document.getElementById('txt_producto<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>' );
  }
}

function AgregarFila<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	AgregarFila2<?php echo $NumWindow; ?>();
  }
}

function AgregarFila2<?php echo $NumWindow; ?>() {
	AgregarFilaInvEntra(document.frm_form<?php echo $NumWindow; ?>.txt_producto<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_nombreserv<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_presentacion<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_laboratorio<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_lote<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_vencimiento<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_invima<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_riesgo<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_cantidad<?php echo $NumWindow; ?>.value, '<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.hdn_controw<?php echo $NumWindow; ?>.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>');
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
  	if (document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.value!="0") {
		AbrirForm('application/forms/inventarioentra.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
	} else {
		document.frm_form<?php echo $NumWindow; ?>.txt_compra<?php echo $NumWindow; ?>.focus();
	}
  }
}

    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
