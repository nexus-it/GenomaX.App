<?php	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="" target="" onreset="LoadForm<?php echo $NumWindow; ?>();">
	
	<label  class="label label-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> EDICIÓN</label>
		
	<div class="row  well well-sm">

		<input name="hdn_codigo<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigo<?php echo $NumWindow; ?>" value="">
		
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_descripcion<?php echo $NumWindow; ?>">
	  <label for="txt_descripcion<?php echo $NumWindow; ?>">Descripción</label>
	  <input name="txt_descripcion<?php echo $NumWindow; ?>" type="text"  id="txt_descripcion<?php echo $NumWindow; ?>" required >
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_descripcion<?php echo $NumWindow; ?>">
	  <label for="txt_resolucion<?php echo $NumWindow; ?>">Autorización No.</label>
	  <input name="txt_resolucion<?php echo $NumWindow; ?>" type="text"  id="txt_resolucion<?php echo $NumWindow; ?>" required	 >
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha </label>
		<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" />
	</div>

		</div>	
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_prefijo<?php echo $NumWindow; ?>">
	  <label for="txt_prefijo<?php echo $NumWindow; ?>">Prefijo</label>
	  <input name="txt_prefijo<?php echo $NumWindow; ?>" type="text"  id="txt_prefijo<?php echo $NumWindow; ?>" maxlength="4">
	</div>

		</div>
		
			
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_tipoaut<?php echo $NumWindow; ?>">Tipo </label>
		<select name="cmb_tipoaut<?php echo $NumWindow; ?>" id="cmb_tipoaut<?php echo $NumWindow; ?>" >
			<option value="1">Manual</option>
			<option value="2">Por Computador</option>
			<option value="3">Electrónica</option>
		</select>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_aviso<?php echo $NumWindow; ?>">
		<label for="txt_aviso<?php echo $NumWindow; ?>">Aviso antes de</label>
		<input  name="txt_aviso<?php echo $NumWindow; ?>" id="txt_aviso<?php echo $NumWindow; ?>" type="number" required class="form-control"  value="100" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_sede<?php echo $NumWindow; ?>">Sede </label>
		<select name="cmb_sede<?php echo $NumWindow; ?>" id="cmb_sede<?php echo $NumWindow; ?>" >
	<?php 
	$SQL="Select Codigo_SDE, Nombre_SDE from czsedes where Estado_SDE='1' order by 2";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) {
	?>
			<option value="<?php echo ($row[0]); ?>"><?php echo ($row[1]); ?></option>
	<?php
		}
	mysqli_free_result($result); 
	?>  
		</select>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_fechaini<?php echo $NumWindow; ?>">
		<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
		<input  name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_fechafin<?php echo $NumWindow; ?>">
		<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
		<input  name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" required class="form-control" value="2500-12-31"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_consecini<?php echo $NumWindow; ?>">
		<label for="txt_consecini<?php echo $NumWindow; ?>">Factura Inicial</label>
		<input  name="txt_consecini<?php echo $NumWindow; ?>" id="txt_consecini<?php echo $NumWindow; ?>" type="number" required class="form-control"  value="" />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_consecfin<?php echo $NumWindow; ?>">
		<label for="txt_consecfin<?php echo $NumWindow; ?>">Factura Final</label>
		<input  name="txt_consecfin<?php echo $NumWindow; ?>" id="txt_consecfin<?php echo $NumWindow; ?>" type="number" required class="form-control"  value="" />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_consecfin<?php echo $NumWindow; ?>">
		<label for="txt_actual<?php echo $NumWindow; ?>">Cons. Actual</label>
		<input  name="txt_actual<?php echo $NumWindow; ?>" id="txt_actual<?php echo $NumWindow; ?>" type="number" class="form-control"  value="0" disabled="disabled"/>
	</div>

		</div>
		
		<div class="col-md-3">

	<div class="form-group" id="grp_txt_ctecnica<?php echo $NumWindow; ?>">
	  <label for="txt_ctecnica<?php echo $NumWindow; ?>">Clave Técnica</label>
	  <input name="txt_ctecnica<?php echo $NumWindow; ?>" type="text"  id="txt_ctecnica<?php echo $NumWindow; ?>"  required>
	</div>

		</div>
		
		<div class="col-md-1">

	<div class="form-group">
		<label for="cmb_estado<?php echo $NumWindow; ?>">Estado </label>
		<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>" >
			<option value="1">Activo</option>
			<option value="0">Inactivo</option>
		</select>
	</div>

		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Save<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> GUARDAR</button>
		</div>
</div>
</form>

	<label  class="label label-success"><i class="fas fa-search"></i> RESOLUCIONES / AUTORIZACIONES</label>
<div class="row  well well-sm">

		<div class="col-md-12">

			

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive altura100" >
<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
	<th id="th1<?php echo $NumWindow; ?>">Sede</th> 
	<th id="th1<?php echo $NumWindow; ?>"># Autorización</th> 
	<th id="th1<?php echo $NumWindow; ?>">Tipo</th> 
	<th id="th1<?php echo $NumWindow; ?>">Fecha</th> 
	<th id="th1<?php echo $NumWindow; ?>">Prefijo</th> 
	<th id="th1<?php echo $NumWindow; ?>">Factura Inicial</th> 
	<th id="th1<?php echo $NumWindow; ?>">Factura Final</th> 
	<th id="th1<?php echo $NumWindow; ?>">Actual</th> 
	<th id="th1<?php echo $NumWindow; ?>">Activo</th>           
</tr> 
	 <?php 
	$SQL="Select b.Nombre_SDE, a.Codigo_AFC, a.Prefijo_AFC, a.Resolucion_AFC, a.Fecha_AFC, a.ConsecIni_AFC, a.ConsecFin_AFC, case a.Tipo_AFC when '1' then 'Manual' when '2' then 'Por Computador' else 'Electrónica' end, a.Estado_AFC, ConsecNow_AFC From czautfacturacion a, czsedes b Where b.Codigo_AFC=a.Codigo_AFC and Estado_SDE='1' order by 9 desc,1 asc,3 asc";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
			echo '
	  <tr onclick="javascript:BuscarAutF3'.$NumWindow.'(\''.$row[1].'\');" style="font-size: 13px;">
	  	<td>'.$row[0].'</td>
	  	<td>'.$row[3].'</td>
	  	<td align="center">'.$row[7].'</td>
	  	<td align="center">'.$row[4].'</td>
	  	<td>'.$row[2].'</td>
	  	<td align="right">'.$row[5].'</td>
	  	<td align="right">'.$row[6].'</td>
	  	<td align="right">'.$row[9].'</td>
	  	';
	if ($row[8]=='1'){
		echo '
		<td align="center" title="Activo" style="font-size: 14px;"> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> </td>';
	} else {
		echo '
		<td align="center" title="Inactivo" style="font-size: 14px;"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </td>';
	}

			echo '
	  </tr>
	  ';
		}
	mysqli_free_result($result); 
	 ?>  

</tbody>
</table><input name="hdn_contare<?php echo $NumWindow; ?>" type="hidden" id="hdn_contare<?php echo $NumWindow; ?>" value="<?php echo $contaare; ?>" />
 </div>
<input name="hdn_accesosareas<?php echo $NumWindow; ?>" type="hidden" id="hdn_accesosareas<?php echo $NumWindow; ?>" value="" />
		
		</div>

		
 
</div>


<script >
	// $('#frm_form<?php echo $NumWindow; ?>').fadeOut(10);
<?php
	if (isset($_GET["Codigo"])) {
		$SQL="Select  a.Codigo_AFC, a.Codigo_AFC, a.Prefijo_AFC, a.Resolucion_AFC, a.Fecha_AFC, a.ConsecIni_AFC, a.ConsecFin_AFC, a.Tipo_AFC, a.Estado_AFC, a.Descripcion_AFC, a.ConsecNow_AFC, a.AvisoAntesDe_AFC, a.IdFormSiigo_AFC, a.FechaIni_AFC, a.FechaFin_AFC, date(now()), Codigo_SDE From czautfacturacion a, czsedes b Where a.Codigo_AFC=b.Codigo_AFC and a.Codigo_AFC='".$_GET["Codigo"]."'";
		$result = mysqli_query($conexion, $SQL);
		
		if($row = mysqli_fetch_array($result)) {
			if (($row[14]<$row[15])||($row[6]<=$row[10])) {
				echo "MsgBox1('Autorización Vencida','El consecutivo llegó a su fin o la fecha actual es mayor a la autorizada. Por favor Verifique');";
			} else {
				if ($row[6]<=($row[10]+$row[11])) {
					echo "MsgBox1('Autorización Próxima a Vencer','El consecutivo actual (".$row[10].") se encuentra cercano a su límite autorizado (".$row[6]."). Por favor Verifique');";
				} else {
					echo "
					document.frm_form".$NumWindow.".hdn_codigo".$NumWindow.".value='".$_GET[1]."';
					document.frm_form".$NumWindow.".txt_resolucion".$NumWindow.".value='".$row[3]."';
					document.frm_form".$NumWindow.".txt_prefijo".$NumWindow.".value='".$row[2]."';
					document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".($row[4])."';
					document.frm_form".$NumWindow.".txt_consecini".$NumWindow.".value='".$row[5]."';
					document.frm_form".$NumWindow.".txt_consecfin".$NumWindow.".value='".$row[6]."';
					document.frm_form".$NumWindow.".cmb_tipoaut".$NumWindow.".value='".$row[7]."';
					document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row[8]."';
					document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[16]."';
					document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".value='".$row[9]."';
					document.frm_form".$NumWindow.".txt_actual".$NumWindow.".value='".$row[10]."';
					document.frm_form".$NumWindow.".txt_aviso".$NumWindow.".value='".$row[11]."';
					document.frm_form".$NumWindow.".txt_ctecnica".$NumWindow.".value='".$row[12]."';	
					document.frm_form".$NumWindow.".txt_fechaini".$NumWindow.".value='".($row[13])."';
					document.frm_form".$NumWindow.".txt_fechafin".$NumWindow.".value='".($row[14])."';
					$('#frm_form".$NumWindow."').fadeIn(700);
					";
				}
			}
		}
		mysqli_free_result($result); 
	}
?>

function LoadForm<?php echo $NumWindow; ?>() {
	$('#frm_form<?php echo $NumWindow; ?>').fadeOut(700);
	<?php 
	echo "
	document.frm_form".$NumWindow.".hdn_codigo".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_resolucion".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_prefijo".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".($row[4])."';
	document.frm_form".$NumWindow.".txt_consecini".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_consecfin".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_actual".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_aviso".$NumWindow.".value='100';
	document.frm_form".$NumWindow.".txt_ctecnica".$NumWindow.".value='';	
	document.frm_form".$NumWindow.".txt_fechaini".$NumWindow.".value='';
	document.frm_form".$NumWindow.".txt_fechafin".$NumWindow.".value='';
	";
	?>
	$('#frm_form<?php echo $NumWindow; ?>').fadeIn(700);
}

function BuscarAutF<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('hdn_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/autfacturacion.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/autfacturacion.php', '<?php echo $NumWindow; ?>', '&Codigo='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarAutF2<?php echo $NumWindow; ?>() {
	if (document.getElementById('hdn_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/autfacturacion.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/autfacturacion.php', '<?php echo $NumWindow; ?>', '&Codigo='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
}

function BuscarAutF3<?php echo $NumWindow; ?>(ElCodigo) {
	AbrirForm('application/forms/autfacturacion.php', '<?php echo $NumWindow; ?>', '&Codigo='+ElCodigo);
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


	$("input[type=text]").addClass("md_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("md_<?php echo $NumWindow; ?>");
	$("textarea").addClass("md_<?php echo $NumWindow; ?>");
	$("select").addClass("md_<?php echo $NumWindow; ?>");

</script>
