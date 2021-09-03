<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';
	$NumPago="";
	$NumFak="";
	if (isset($_GET["CodigoPGS"])) {
		$NumPago=$_GET["CodigoPGS"];
	}
	if (isset($_GET["CodigoFAC"])) {
		$NumFak=$_GET["CodigoFAC"];
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">
			<div class="col-md-2">

		<div class="form-group">
			<label for="txt_pago<?php echo $NumWindow; ?>">Pago</label>
			<div class="input-group" id="grp_txt_factura<?php echo $NumWindow; ?>">	
				<input name="txt_pago<?php echo $NumWindow; ?>" id="txt_pago<?php echo $NumWindow; ?>" style="font-size:14px; font-weight: bold;" type="text" value="<?php echo $NumPago; ?>" onblur="FacturasPagos<?php echo $NumWindow; ?>('<?php echo $NumWindow; ?>');" onkeypress="BuscarPago<?php echo $NumWindow; ?>(event);"  />
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="CartFactura" onclick="javascript:CargarSearch('PagosCartera', 'txt_pago<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
				</span>
			</div>
		</div>
		
			</div>	
			<div class="col-md-2 col-md-offset-8">

		<div class="form-group">
			<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
			<input name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" />
		</div>
		
			</div>
			<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_tercero<?php echo $NumWindow; ?>">Tercero</label>
		  	<div class="input-group">	
		  		<input name="txt_tercero<?php echo $NumWindow; ?>" type="text" id="txt_tercero<?php echo $NumWindow; ?>"  onblur="NombreTer<?php echo $NumWindow; ?>(this.value); FacturasPagos<?php echo $NumWindow; ?>('<?php echo $NumWindow; ?>');"  required />
		  		<span class="input-group-btn">	
		  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Tercero" onclick="javascript:CargarSearch('Tercero', 'txt_tercero<?php echo $NumWindow; ?>', 'Codigo_TID=*9*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		  		</span>
		  	</div>
		</div>

			</div>
			<div class="col-md-3">

		<div class="form-group">
			<label for="txt_NombreTER<?php echo $NumWindow; ?>">Nombre Tercero	</label>
			<input name="txt_NombreTER<?php echo $NumWindow; ?>" type="text"  disabled="disabled" style="font-size:14px; font-weight: bold;" id="txt_NombreTER<?php echo $NumWindow; ?>" />
		</div>
		
			</div>
			<div class="col-md-2">

		<div class="form-group">
			<label for="cmb_formapago<?php echo $NumWindow; ?>">Pago Por</label>
			<select name="cmb_formapago<?php echo $NumWindow; ?>" id="cmb_formapago<?php echo $NumWindow; ?>">
			<?php 
			$SQL="SELECT Codigo_FPG, Nombre_FPG FROM czformasdepago WHERE Estado_FPG ='1' Order By 2;";
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
			<label for="cmb_banco<?php echo $NumWindow; ?>">Banco</label>
			<select name="cmb_banco<?php echo $NumWindow; ?>" id="cmb_banco<?php echo $NumWindow; ?>">
			<?php 
			$SQL="SELECT Codigo_BCO, concat(Nombre_BCO, ' ', TipoCta_BCO,' ', CuentaNo_BCO) FROM czbancos WHERE Estado_BCO ='1' Order By 2;";
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
			<label for="txt_total<?php echo $NumWindow; ?>">Total</label>
			<input style="font-size:14px; text-align:right;font-weight: bold;" name="txt_total<?php echo $NumWindow; ?>" id="txt_total<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="$0.00"/>
		</div>

			</div>
			<div class="col-md-12 ">
		<div class="form-group">
		<label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
		<textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="2" id="txt_observacion<?php echo $NumWindow; ?>" ></textarea>
		</div>
			</div>
			
							

		<?php 
			 
		?>
		<div class="col-md-12">
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:50%">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th2<?php echo $NumWindow; ?>">Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Fecha Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Radicado</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Fecha Cartera</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Edad Cartera</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Valor Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Notas Débito</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Notas Crédito</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Pagado</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Saldo</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Pagar</th> 
			</tr> 
			<input name="hdn_totregistros<?php echo $NumWindow; ?>" type="hidden" id="hdn_totregistros<?php echo $NumWindow; ?>" value="0" />
			 </tbody>

			</table>
	</div>

		</div>
	</div>		
		
</form>

<script >
FechaActual('txt_fecha<?php echo $NumWindow; ?>');
<?php
	if ($NumPago!="") {
		$SQL="SELECT Codigo_PGS, Fecha_PGS, Codigo_TER, Codigo_FPG, Codigo_BCO, Total_PGS, Observaciones_PGS, Estado_PGS From czpagosenc where Codigo_PGS='".$NumPago."'";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) 
			{
		 echo "
		document.getElementById('txt_pago".$NumWindow."').value = '".$row[0]."';
		document.getElementById('txt_fecha".$NumWindow."').value = '".$row[1]."';
		document.getElementById('txt_tercero".$NumWindow."').value = '".$row[2]."';
		document.getElementById('cmb_formapago".$NumWindow."').value = '".$row[3]."';
		document.getElementById('cmb_banco".$NumWindow."').value = '".$row[4]."';
		document.getElementById('txt_total".$NumWindow."').value = '".$row[5]."';
		document.getElementById('txt_observacion".$NumWindow."').innerHTML = '".$row[6]."';
		";
			$SQL="Select ID_TER from czterceros Where Codigo_TER='".$row[2]."'";
			$resultx = mysqli_query($conexion, $SQL);
			if ($rowx = mysqli_fetch_array($resultx)) 
				{

			  echo "
		NombreTer".$NumWindow."('".$rowx[0]."');
		document.getElementById('txt_tercero".$NumWindow."').value = '".$rowx[0]."';
		";
				}
				mysqli_free_result($resultx);
			if ($row[7]=='0') {
				echo 'MsgBox1("Recepción de Pagos [Cartera]","El consecutivo '.$NumPago.' se encuentra anulado.");';
			} else {
				if ($row[7]=='2') {
					echo 'MsgBox1("Recepción de Pagos [Cartera]","El consecutivo '.$NumPago.' se encuentra confirmado.");
					document.getElementById("tbDetalle'.$NumWindow.'").disabled="true";';
				} else {
					

					echo '
					FacturasPagos'.$NumWindow.'("'.$NumWindow.'");';
				}
			}
		} else {
			echo 'MsgBox1("Recepción de Pagos [Cartera]","El consecutivo '.$NumPago.' no se encuentra.");';
		}
		mysqli_free_result($result);
	}
?>

var Funciones="functions/php/nexus/functions.php";

function FacturasPagos<?php echo $NumWindow; ?>(pagina) {
	document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML='<tr><th align="center">Consultando Facturas...</th></tr><tr ><td align="center" ><div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Consultando Facturas...</span>  </div></div></td></tr> ';
	varpagos='<?php echo $NumPago; ?>';
	vartercero=document.frm_form<?php echo $NumWindow; ?>.txt_tercero<?php echo $NumWindow; ?>.value;
	$.get(Funciones,{'Func':'FacturasPagos','varpagos':varpagos,'vartercero':vartercero,'ventana':'<?php echo $NumWindow; ?>'},function(data){
		document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML=data;
		TotPago<?php echo $NumWindow; ?>();
	});
	
}

function BuscarPago<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
    AbrirForm('application/forms/pagoscartera.php', '<?php echo $NumWindow; ?>', '&CodigoPGS='+document.getElementById('txt_pago<?php echo $NumWindow; ?>').value);
  }
}

function NombreTer<?php echo $NumWindow; ?>(Codigo) {
	$.get(Funciones,{'Func':'NombreTercero','value':Codigo, 'tabla':'gxeps'},function(data){ 
		if (data=="No se encuentra el tercero") {
			swal('DOCUMENTO NO VALIDO', data,'error');
			document.getElementById('txt_NombreTER<?php echo $NumWindow; ?>').value="";
		} else {
			document.getElementById('txt_NombreTER<?php echo $NumWindow; ?>').value=data;
		}
	}); 
}

function TotPago<?php echo $NumWindow; ?>() {
	TotRegistros=document.getElementById('hdn_totregistros<?php echo $NumWindow; ?>').value;
	var Suma=0;
	for (var i = 1; i <= TotRegistros; i++) {
		Valor=0;
		Chkeado=document.getElementById('hdn_pagara'+i+'<?php echo $NumWindow; ?>').value;
		if (Chkeado=="1") {
			Valor=parseFloat(document.getElementById('txt_pagado'+i+'<?php echo $NumWindow; ?>').value);
			Suma=Suma+Valor;
		}
	}
	document.getElementById('txt_total<?php echo $NumWindow; ?>').value=Suma;
}

function swapPagado<?php echo $NumWindow; ?>(Kontador) {
	Extado=document.getElementById('hdn_pagara'+Kontador+'<?php echo $NumWindow; ?>').value;
	if (Extado=='1') {
		document.getElementById('hdn_pagara'+Kontador+'<?php echo $NumWindow; ?>').value='0';
		document.getElementById('txt_pagado'+Kontador+'<?php echo $NumWindow; ?>').disabled=true;
	} else {
		document.getElementById('hdn_pagara'+Kontador+'<?php echo $NumWindow; ?>').value='1';
		document.getElementById('txt_pagado'+Kontador+'<?php echo $NumWindow; ?>').disabled=false;
		if (document.getElementById('txt_pagado'+Kontador+'<?php echo $NumWindow; ?>').value=="") {
			document.getElementById('txt_pagado'+Kontador+'<?php echo $NumWindow; ?>').value=document.getElementById('hdn_valsaldo'+Kontador+'<?php echo $NumWindow; ?>').value;
		}
	}
	TotPago<?php echo $NumWindow; ?>();
}

function FactDetCar<?php echo $NumWindow; ?>(factura) {
	var faktura= factura.replace(" ", "!");
	<?php
	$SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From nxs_gnx.ititems Where Codigo_ITM='512';";
	$resulthc = mysqli_query($conexion, $SQL);
	if ($rowhc = mysqli_fetch_array($resulthc)) 
		{
	?>
	CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>?faktura='+faktura, '<?php echo $rowhc[2]; ?>', 'pagoscartera.php','<?php echo $NumWindow; ?>' );
	<?php
		}
	mysqli_free_result($resulthc); 
	?>
}
	
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
<script src="functions/nexus/pagoscartera.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>