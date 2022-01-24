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
	<div class="row">

		<div class="col-md-1">

	<div class="form-group">
	  <label for="txt_Contrato<?php echo $NumWindow; ?>">Codigo</label>
	  	<div class="input-group">	
	  		<input name="txt_Contrato<?php echo $NumWindow; ?>" type="text" id="txt_Contrato<?php echo $NumWindow; ?>" onkeypress="BuscarContrato<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*__and__TipoContrato_EPS=*EVENTO*')};" required="true"/>
	  		<span class="input-group-btn">	
	  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*__and__TipoContrato_EPS=*EVENTO*');"><i class="fas fa-search"></i></button>
	  		</span>
	  	</div>
  	</div> 

		</div>
		<div class="col-md-4">
	
	<div class="form-group">
		<label for="txt_NombreEPS<?php echo $NumWindow; ?>">Nombre</label>
		<input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>"/>
	</div>
	
		</div>
		<div class="col-md-3">
	
	<div class="form-group">
		<label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
	  	<select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>" change="cargaringresos<?php echo $NumWindow; ?>();">
	  	</select>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_numcontrato<?php echo $NumWindow; ?>">Contrato No.</label>
	  <input name="txt_numcontrato<?php echo $NumWindow; ?>" type="text"  id="txt_numcontrato<?php echo $NumWindow; ?>"  style="font-size:14px; font-weight: bold; color:#0E5012; " disabled>
	</div>

		</div>
		<div class="col-md-2">
			
	<div class="form-group">
	  <label for="txt_sede<?php echo $NumWindow; ?>">Sede</label>
	  <select name="txt_sede<?php echo $NumWindow; ?>" id="txt_sede<?php echo $NumWindow; ?>" onchange="cargaringresos<?php echo $NumWindow; ?>();">
    <?php 
	$SQL="Select Codigo_SDE, Nombre_SDE From czsedes Where Estado_SDE='1' Order By Codigo_SDE";
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
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
	  <input name="txt_fechaini<?php echo $NumWindow; ?>" type="date"  id="txt_fechaini<?php echo $NumWindow; ?>" onchange="cargaringresos<?php echo $NumWindow; ?>();" value="<?php echo primer_dia_mes_actual(); ?>">
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
	  <input name="txt_fechafin<?php echo $NumWindow; ?>" type="date"  id="txt_fechafin<?php echo $NumWindow; ?>" onchange="cargaringresos<?php echo $NumWindow; ?>();" value="<?php echo ultimo_dia_mes_actual(); ?>" >
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_valfactura<?php echo $NumWindow; ?>">Valor Factura</label>
	  <input name="txt_valfactura<?php echo $NumWindow; ?>" type="number"  id="txt_valfactura<?php echo $NumWindow; ?>"  style="font-size:14px; font-weight: bold; color:#0E5012; " value="0">
	</div>

		</div>
</div>
<div class="row">

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" >
<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
	<th id="th1<?php echo $NumWindow; ?>">Ingreso</th> 
	<th id="th2<?php echo $NumWindow; ?>">Id. Paciente</th> 
	<th id="th2<?php echo $NumWindow; ?>">Nombre</th> 
	<th id="th2<?php echo $NumWindow; ?>">Fecha Ing.</th> 
	<th id="th2<?php echo $NumWindow; ?>">Diagnostico</th> 
          
</tr> 
</tbody>
</table>
 </div>


 </div>


</div>

</form>

<script >

$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();

function onblurservicio<?php echo $NumWindow; ?>(valor) {
	NombreServicio(valor,'<?php echo $NumWindow; ?>');
	Eps="";
	Plan="";
	document.getElementById("txt_cantidad<?php echo $NumWindow; ?>").value="1";
	Eps=document.getElementById("txt_Contrato<?php echo $NumWindow; ?>").value;
	Plan=document.getElementById("txt_Plan<?php echo $NumWindow; ?>").value;
	if (Eps!="") {
		ValorServicio(valor,'<?php echo $NumWindow; ?>', Eps, Plan);
		CalTotFact<?php echo $NumWindow; ?>();
	}
}

function CalTotFact<?php echo $NumWindow; ?>() {
	valuni=document.getElementById("txt_valorservicio<?php echo $NumWindow; ?>").value;
	cantidad=document.getElementById("txt_cantidad<?php echo $NumWindow; ?>").value;
	document.getElementById("txt_valfactura<?php echo $NumWindow; ?>").value=valuni*cantidad;
}

<?php
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

function cargaringresos<?php echo $NumWindow; ?>() {
	Eps="";
	Plan="";
	Eps=document.getElementById("txt_Contrato<?php echo $NumWindow; ?>").value;
	Plan=document.getElementById("txt_Plan<?php echo $NumWindow; ?>").value;
	if (Eps!="") {
		ElPref<?php echo $NumWindow; ?>(document.getElementById('txt_sede<?php echo $NumWindow; ?>').value);
		document.getElementById('zero_detalle<?php echo $NumWindow; ?>').innerHTML='<div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Un momento...</span>  </div></div>';
		cargarcuentasgrupal('<?php echo $NumWindow; ?>');
	}
}

function BuscarContrato<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  NumeroContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  cargaringresos<?php echo $NumWindow; ?>();
  }
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
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>
