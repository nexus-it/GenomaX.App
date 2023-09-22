<?php
	session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">
  
  <div class="form-group">
    <label class="col-sm-3 control-label" >NIT DIAN</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="NitDIAN_XCT<?php echo $NumWindow; ?>" name="NitDIAN_XCT<?php echo $NumWindow; ?>" placeholder="NIT DIAN">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >NIT Tesorería</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="NitTesoreria_XCT<?php echo $NumWindow; ?>" name="NitTesoreria_XCT<?php echo $NumWindow; ?>" placeholder="NIT Tesorería">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Cuenta Cierre</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="CtCierre_XCT<?php echo $NumWindow; ?>" name="CtCierre_XCT<?php echo $NumWindow; ?>" placeholder="CUENTA Cierre">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Cuenta Ganancias</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="CtaGanancias_XCT<?php echo $NumWindow; ?>" name="CtaGanancias_XCT<?php echo $NumWindow; ?>" placeholder="CUENTA ganancias">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Cuenta Déficit</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="CtaDeficit_XCT<?php echo $NumWindow; ?>" name="CtaDeficit_XCT<?php echo $NumWindow; ?>" placeholder="CUENTA DEFICIT">
    </div>
  </div> 
  <div class="form-group">
    <label class="col-sm-3 control-label" >Cuenta Superavit</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="CtaSuperavit_XCT<?php echo $NumWindow; ?>" name="CtaSuperavit_XCT<?php echo $NumWindow; ?>" placeholder="CUENTA superavit">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Retenedor de IVA</label>
    <div class="col-sm-9">
		<select name="ReteIVA_XCT<?php echo $NumWindow; ?>" id="ReteIVA_XCT<?php echo $NumWindow; ?>">
			<option value="0">NO</option>
			<option value="1">SI</option>
		</select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Retenedor de ICA</label>
    <div class="col-sm-9">
		<select name="ReteICA_XCT<?php echo $NumWindow; ?>" id="ReteICA_XCT<?php echo $NumWindow; ?>">
			<option value="0">NO</option>
			<option value="1">SI</option>
		</select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Retenedor Fuente</label>
    <div class="col-sm-9">
		<select name="ReteFuente_XCT<?php echo $NumWindow; ?>" id="ReteFuente_XCT<?php echo $NumWindow; ?>">
			<option value="0">NO</option>
			<option value="1">SI</option>
		</select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Cuenta Cuotas Moderadoras</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="CtaCuotaMod_XCT<?php echo $NumWindow; ?>" name="CtaCuotaMod_XCT<?php echo $NumWindow; ?>" placeholder="CUENTA cuotas moderadoras">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Cuenta Copagos</label>
    <div class="col-sm-9">
		<input type="text" class="form-control" id="CtaCopagos_XCT<?php echo $NumWindow; ?>" name="CtaCopagos_XCT<?php echo $NumWindow; ?>" placeholder="CUENTA copagos">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Saldos Iniciales</label>
    <div class="col-sm-9">
		<select name="SaldosIni_XCT<?php echo $NumWindow; ?>" id="SaldosIni_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Traslados</label>
    <div class="col-sm-9">
		<select name="CtTraslados_XCT<?php echo $NumWindow; ?>" id="CtTraslados_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Ajustes Contables</label>
    <div class="col-sm-9">
		<select name="Codigo_FNC<?php echo $NumWindow; ?>" id="Codigo_FNC<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Facturas de Venta</label>
    <div class="col-sm-9">
		<select name="InterfazFC_XCT<?php echo $NumWindow; ?>" id="InterfazFC_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Facturas de Compra</label>
    <div class="col-sm-9">
		<select name="InterfazCO_XCT<?php echo $NumWindow; ?>" id="InterfazCO_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Documento Soporte</label>
    <div class="col-sm-9">
		<select name="InterfazDS_XCT<?php echo $NumWindow; ?>" id="InterfazDS_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Recibo de Caja</label>
    <div class="col-sm-9">
		<select name="InterfazTS_XCT<?php echo $NumWindow; ?>" id="InterfazTS_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Pago Facturas Venta</label>
    <div class="col-sm-9">
		<select name="InterfazCR_XCT<?php echo $NumWindow; ?>" id="InterfazCR_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Pago Facturas Compra</label>
    <div class="col-sm-9">
		<select name="InterfazEG_XCT<?php echo $NumWindow; ?>" id="InterfazEG_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Comprobante Movimiento Inventario</label>
    <div class="col-sm-9">
		<select name="InterfazIN_XCT<?php echo $NumWindow; ?>" id="InterfazIN_XCT<?php echo $NumWindow; ?>">
			<?php 
				$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont Order By 2";
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
  <div class="form-group">
    <label class="col-sm-3 control-label" >Calcular RteFte Fact Venta</label>
    <div class="col-sm-9">
		<select name="RetFteAutoFV_XCT<?php echo $NumWindow; ?>" id="RetFteAutoFV_XCT<?php echo $NumWindow; ?>">
			<option value="FAC">Al causar Factura</option>
			<option value="PAG">Al registrar el pago</option>
		</select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" >Calcular RteFte Fact Compra</label>
    <div class="col-sm-9">
		<select name="RetFteAutoFC_XCT<?php echo $NumWindow; ?>" id="RetFteAutoFC_XCT<?php echo $NumWindow; ?>">
			<option value="FAC">Al causar Factura</option>
			<option value="PAG">Al registrar el pago</option>
		</select>
    </div>
  </div>



	<button type="button" class="btn btn-success btn-sm btn-block" onclick="movconts<?php echo $NumWindow; ?>('Facturacion');">Generar Movimientos</button>
</div>

</form>

<script >

function movconts<?php echo $NumWindow; ?>(modulo) {
	var Transact="functions/php/transactions/";
	$.ajax({  
		type: "POST",  
		url: Transact + "interfacecont.php",  
		data: "Module="+modulo,  
		success: function(respuesta) { 
			MsgBox1("Mov Contables", "Registros de "+modulo+" cargados."); 
		}  
	});  
	return false; 
}
<?php
	$SQL="Select * From itconfig_ct";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='itconfig_ct' ORDER BY ORDINAL_POSITION;";
  		$rstColumns = mysqli_query($conexion, $SQL);
		  $i=0;
		while($rowColumns = mysqli_fetch_array($rstColumns)) {
			echo '
	document.getElementById("'.$rowColumns[0].$NumWindow.'").value = "'.$row[$i].'";			
			';
			$i++;
		}
		mysqli_free_result($rstColumns); 
	}
	mysqli_free_result($result); 
?>

    $("input[type=text]").addClass("input-sm form-control");
    $("input[type=date]").addClass("input-sm form-control");
	$("input[type=number]").addClass("input-sm form-control");
	$("input[type=time]").addClass("input-sm form-control");
    
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("input-sm form-control");

</script>
