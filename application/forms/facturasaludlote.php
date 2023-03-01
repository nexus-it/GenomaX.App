<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>">
	<div class="row">

		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_Contrato<?php echo $NumWindow; ?>">Contrato</label>
		<select name="txt_Contrato<?php echo $NumWindow; ?>" id="txt_Contrato<?php echo $NumWindow; ?>" onchange="BuscarContrato<?php echo $NumWindow; ?>();">
			<option value="">Seleccione:</option>
		<?php
		$SQL="select Codigo_EPS, concat(Nombre_EPS,' : ',Contrato_EPS) from gxeps Where estado_EPS='1' Order by 2";
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
		<label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
	  	<select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>">
	  	</select>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
	  <input name="txt_fechaini<?php echo $NumWindow; ?>" type="date"  id="txt_fechaini<?php echo $NumWindow; ?>" >
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
	  <input name="txt_fechafin<?php echo $NumWindow; ?>" type="date"  id="txt_fechafin<?php echo $NumWindow; ?>"  >
	</div>

		</div>
		<div class="col-md-1">
			
	<div class="form-group">
	  <label for="txt_sede<?php echo $NumWindow; ?>">Sede</label>
	  <select name="txt_sede<?php echo $NumWindow; ?>" id="txt_sede<?php echo $NumWindow; ?>">
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
	  <input name="hdn_prefijo<?php echo $NumWindow; ?>" type="hidden" id="hdn_prefijo<?php echo $NumWindow; ?>" value="" />
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
	<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_fechafac<?php echo $NumWindow; ?>">Fecha Facturas</label>
	  <input name="txt_fechafac<?php echo $NumWindow; ?>" type="date"  id="txt_fechafac<?php echo $NumWindow; ?>" >
	</div>

		</div>
		<div class="col-md-12">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" >
	  <tbody >
	  <tr>
	  	<td width="20%" align="right" style="vertical-align: middle;">Realizar reingreso de manera automática</td>
	  	<td style="vertical-align: middle;">
		<?php nxs_chk('reingreso', $NumWindow); ?>
		</td>
		<td>
 
			<div class="btn-group pull-right">
			  <button type="button" class="btn btn-success btn-lg btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Cargar Cuentas <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" >
			  	<li ><a href="javascript:ordenar<?php echo $NumWindow; ?>('1');">Por Ingreso</a></li>
			    <li ><a href="javascript:ordenar<?php echo $NumWindow; ?>('3');">Por Paciente</a></li>
			    <li ><a href="javascript:ordenar<?php echo $NumWindow; ?>('7');">Por Finalizacion</a></li>
			    <li ><a href="javascript:ordenar<?php echo $NumWindow; ?>('8');">Por Valor</a></li>
			  </ul>
			</div>
			<input name="hdn_ordenar<?php echo $NumWindow; ?>" type="hidden" id="hdn_ordenar<?php echo $NumWindow; ?>" value="1" />
			</td>
		</tr>
	</tbody>
	</table>
		</div>

</div>
<div class="row">

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" style="height: 90%;" >
<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
	<th id="th1<?php echo $NumWindow; ?>">Ingreso</th> 
	<th id="th2<?php echo $NumWindow; ?>">Id. Paciente</th> 
	<th id="th2<?php echo $NumWindow; ?>">Nombre</th> 
	<th id="th2<?php echo $NumWindow; ?>">Fecha Ing.</th> 
	<th id="th2<?php echo $NumWindow; ?>">Diagnostico</th> 
	<th id="th2<?php echo $NumWindow; ?>">Autorizacion</th> 
	<th id="th2<?php echo $NumWindow; ?>">Fecha Fin</th>
	<th id="th2<?php echo $NumWindow; ?>">Valor Pte</th> 
	<th id="th2<?php echo $NumWindow; ?>">Valor Entidad</th> 
	<th id="th2<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></th> 
          
</tr> 
</tbody>
</table>
 </div>


 </div>
 <div class="row">
 	<div class="col-md-6 text-left">
		<label for="txt_cantidad<?php echo $NumWindow; ?>"> Cantidad Seleccionada </label>
		<input name="txt_cantidad<?php echo $NumWindow; ?>" id="txt_cantidad<?php echo $NumWindow; ?>" type="text" value="0" class="izq" disabled="disabled" /><input name="hdn_total<?php echo $NumWindow; ?>" type="hidden" id="hdn_total<?php echo $NumWindow; ?>" value="0" />
	</div>
	<div class="col-md-6 text-right">
		<label for="txt_total<?php echo $NumWindow; ?>"> Total a Facturar </label>
		<input name="txt_total<?php echo $NumWindow; ?>" id="txt_total<?php echo $NumWindow; ?>" type="text" value="<?php echo number_format(0, 2, ",", "."); ?>" class="izq" disabled="disabled" /><input name="hdn_total<?php echo $NumWindow; ?>" type="hidden" id="hdn_total<?php echo $NumWindow; ?>" value="0.00" />
	</div>
</div>

</div>

</form>

<script >

$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();
FechaActual('txt_fechaini<?php echo $NumWindow; ?>');
FechaActual('txt_fechafin<?php echo $NumWindow; ?>');
FechaActual('txt_fechafac<?php echo $NumWindow; ?>');

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

	echo '
	function ElPref'.$NumWindow.'(CodigoAFC) {
		switch(CodigoAFC) {
			';
	$SQL="Select a.Codigo_AFC, a.Prefijo_AFC From czautfacturacion a Where a.Estado_AFC='1' order By 1";
	$result = mysqli_query($conexion, $SQL);
	while($rowi = mysqli_fetch_array($result)) 
	{
		echo 'case "'.$rowi[0].'":
			document.frm_form'.$NumWindow.'.hdn_prefijo'.$NumWindow.'.value="'.$rowi[1].'";
			break;
			';
	}
	mysqli_free_result($result); 
	echo 'default:
			document.frm_form'.$NumWindow.'.hdn_prefijo'.$NumWindow.'.value="";
		}
	}
	';
	if ($_SESSION["it_CodigoUSR"]>"1") {
		$SQL="Select Codigo_AFC From czsedes a, itusuariossedes b Where b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and a.Codigo_SDE=b.Codigo_SDE and Estado_SDE='1'";
		$result = mysqli_query($conexion, $SQL);
		$contasedes=0;
		while($row = mysqli_fetch_array($result)) 
		{
			$contasedes++;
	 	echo "	    	document.frm_form".$NumWindow.".txt_sede".$NumWindow.".value='".$row[0]."';";
	    
		}
		mysqli_free_result($result); 
		if ($contasedes==1) {
			echo "			document.getElementById('txt_sede".$NumWindow."').setAttribute('disabled', true);";
		}
	}
?>

function ordenar<?php echo $NumWindow; ?>(Orden) {
	ElPref<?php echo $NumWindow; ?>(document.getElementById('txt_sede<?php echo $NumWindow; ?>').value);
	document.getElementById('txt_cantidad<?php echo $NumWindow; ?>').value='0';
	document.getElementById('hdn_total<?php echo $NumWindow; ?>').value='0';
	document.getElementById('txt_total<?php echo $NumWindow; ?>').value='0.00';
	document.getElementById('zero_detalle<?php echo $NumWindow; ?>').innerHTML="<span id='zfctlot<?php echo $NumWindow; ?>''><img src='themes/ghenx/img/loading.gif' align='left'></span>";
	document.getElementById('hdn_ordenar<?php echo $NumWindow; ?>').value=Orden;
	cargarcuentaslote('<?php echo $NumWindow; ?>');
}

function BuscarContrato<?php echo $NumWindow; ?>() {
  CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
}

function totalfac<?php echo $NumWindow; ?>() {
	total =0;
	cantifac=0;
	totx=0;
	for (i=1;i<=hdx_contfila<?php echo $NumWindow; ?>.value;i++) {
	 	cuadro=document.getElementById('chk_facturarok'+i+'<?php echo $NumWindow; ?>');
		cuadro2=document.getElementById('hdn_facturar'+i+'<?php echo $NumWindow; ?>');
		valor=document.getElementById('hdn_valorEnt'+i+'<?php echo $NumWindow; ?>').value;
		valor=parseFloat(valor.toString().replace(/\$|\,/g,''));
		totx=totx+1;
		if (cuadro.checked) {
			cuadro2.value='1';
			total= total+valor;
			cantifac=cantifac+1;
		}
		else {
			cuadro2.value='0';
		}
	}
	document.getElementById('txt_cantidad<?php echo $NumWindow; ?>').value=cantifac;
	document.getElementById('hdn_total<?php echo $NumWindow; ?>').value=total;
	document.getElementById('txt_total<?php echo $NumWindow; ?>').value=formatCurrency(total);
	document.getElementById('hdx_contfila<?php echo $NumWindow; ?>').value=totx;
}

function facturarAll<?php echo $NumWindow; ?>(Mode) {
	if (Mode=='All') {
		for (i=1;i<=hdx_contfila<?php echo $NumWindow; ?>.value;i++) {
			document.getElementById('chk_facturarok'+i+'<?php echo $NumWindow; ?>').checked=1; 
		}
	} else {
		for (i=1;i<=hdx_contfila<?php echo $NumWindow; ?>.value;i++) {
			document.getElementById('chk_facturarok'+i+'<?php echo $NumWindow; ?>').checked=0; 
		}
	}
	totalfac<?php echo $NumWindow; ?>();
}

    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
