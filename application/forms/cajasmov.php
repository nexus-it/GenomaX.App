<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<label class="label label-success"> DATOS MOVIMIENTO DE CAJA</label>
	<div class="row well well-sm">

		<div class="col-md-3">
			<div class="form-group">
				<label for="cmb_tipmov<?php echo $NumWindow; ?>">Tipo Movimiento</label>
				<select name="cmb_tipmov<?php echo $NumWindow; ?>" id="cmb_tipmov<?php echo $NumWindow; ?>" onchange="TipoIng<?php echo $NumWindow; ?>(this.value);">
				<?php
					$NaturaX="I";
					$SQL="Select Codigo_TMC, Nombre_TMC, Naturaleza_TMC From cztipomovcaja Where Estado_TMC='1'";
					$result = mysqli_query($conexion, $SQL);
					while ($row = mysqli_fetch_array($result)) {
						$rstyle="color:#600";
						$NaturaX=$row[2];
					 	if ($row[2]=="I") {
					 		$rstyle="color:#060";
					 	}
					 	echo '<option value="'.$row[0].'" style="'.$rstyle.'" >'.$row[1].'</option>';
				 	}
					mysqli_free_result($result);
				?>
			  	</select>
				<input name="hdn_origen<?php echo $NumWindow; ?>" type="hidden" id="hdn_origen<?php echo $NumWindow; ?>" value="" />
			</div>
		</div> 
		<div class="col-md-2">
			<div class="form-group">
				<label for="cmb_tiping<?php echo $NumWindow; ?>">Tipo Ingreso</label>
				<select name="cmb_tiping<?php echo $NumWindow; ?>" id="cmb_tiping<?php echo $NumWindow; ?>">
			    <?php
					$SQL="Select Codigo_TIC, Nombre_TIC From cztipoingresocaja Where Estado_TIC='1'";
					$result = mysqli_query($conexion, $SQL);
					while ($row = mysqli_fetch_array($result)) {
					 	echo '<option value="'.$row[0].'" >'.$row[1].'</option>';
				 	}
					mysqli_free_result($result);
				?>
			  	</select>
			</div>
		</div>
		<input type="hidden" name="hdn_conseccja<?php echo $NumWindow; ?>" id="hdn_conseccja<?php echo $NumWindow; ?>" />
		<div class="col-md-1">
			<div class="form-group">
				<label for="txt_idcaja<?php echo $NumWindow; ?>">Caja Abierta</label>
				<div class="input-group">	
					<input name="txt_idcaja<?php echo $NumWindow; ?>" id="txt_idcaja<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCaja<?php echo $NumWindow; ?>(event);" onblur="BuscarCaja2<?php echo $NumWindow; ?>();" />
					<span class="input-group-btn">	
						<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Caja" onclick="javascript:CargarSearch('Caja', 'txt_idcaja<?php echo $NumWindow; ?>', 'Abierta_CJA=*1*');"><i class="fas fa-search"></i></button>
					</span>
				</div>
			</div>
		</div>

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_nombrecaja<?php echo $NumWindow; ?>">Descripcion</label>
		<input  name="txt_nombrecaja<?php echo $NumWindow; ?>" id="txt_nombrecaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_fechacaja<?php echo $NumWindow; ?>">Fecha Apertura</label>
		<input  name="txt_fechacaja<?php echo $NumWindow; ?>" id="txt_fechacaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_usrcaja<?php echo $NumWindow; ?>">Usuario Apertura</label>
		<input  name="txt_usrcaja<?php echo $NumWindow; ?>" id="txt_usrcaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" />
	</div>

		</div>

	</div>

	<div class="row">
		
		<div class="col-md-2">
			<div class="form-group">
				<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
				<div class="input-group">	
					<input name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarIngreso<?php echo $NumWindow; ?>(event);" onblur="BuscarIngreso2<?php echo $NumWindow; ?>();" />
					<span class="input-group-btn">	
						<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Caja" onclick="javascript:CargarSearch('Ingreso', 'txt_ingreso<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-1">
			<div class="form-group" >
				<label for="txt_fechaing<?php echo $NumWindow; ?>">Fecha</label>
				<input  name="txt_fechaing<?php echo $NumWindow; ?>" id="txt_fechaing<?php echo $NumWindow; ?>" type="text"  class="form-control" disabled="disabled" />
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="txt_paciente<?php echo $NumWindow; ?>">Tercero</label>
				<div class="input-group">	
					<input name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" onblur="BuscarPte2<?php echo $NumWindow; ?>();" />
					<span class="input-group-btn">	
						<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Caja" onclick="javascript:CargarSearch('Tercero', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
					</span>

				</div>
			</div>
		</div>
		<input type="hidden" name="hdn_tercero<?php echo $NumWindow; ?>" id="hdn_tercero<?php echo $NumWindow; ?>" />
		<div class="col-md-5">
			<div class="form-group" >
				<label for="txt_paciente2<?php echo $NumWindow; ?>">Nombre</label>
				<div class="input-group">	
					<span class="input-group-btn">	
						<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseTercero" aria-expanded="false" aria-controls="collapseTercero" title="Crear Tercero" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
					</span>
					<input  name="txt_paciente2<?php echo $NumWindow; ?>" id="txt_paciente2<?php echo $NumWindow; ?>" type="text"  class="form-control" disabled="disabled" />
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="txt_valor<?php echo $NumWindow; ?>">Valor</label>
				<input name="txt_valor<?php echo $NumWindow; ?>" id="txt_valor<?php echo $NumWindow; ?>" type="number" class="form-control" style="font-size:15px; font-weight: bold; color:#0E5012; " value="0" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="txt_concepto<?php echo $NumWindow; ?>">Concepto</label>
				<input name="txt_concepto<?php echo $NumWindow; ?>" id="txt_concepto<?php echo $NumWindow; ?>" type="text" class="form-control"  value="" />
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="txt_nota<?php echo $NumWindow; ?>">Observaciones</label>
				<input name="txt_nota<?php echo $NumWindow; ?>" id="txt_nota<?php echo $NumWindow; ?>" type="text" class="form-control"  value="" />
			</div>
		</div>
	</div>

	<div class="collapse" id="collapseTercero">
		<label class="label label-success"> Crear Tercero</label>
	  <div class="well row well-sm">

	  	<div class="col-md-2">
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">Tipo</div>
					<select name="cmb_tipoid<?php echo $NumWindow; ?>" id="cmb_tipoid<?php echo $NumWindow; ?>" >
					<?php 
					$SQL="Select Codigo_TID, Nombre_TID, Sigla_TID from cztipoid order by Codigo_TID";
					$result = mysqli_query($conexion, $SQL);
					while($row = mysqli_fetch_array($result)) 
						{
					?>
					  <option value="<?php echo $row[0]; ?>"><?php echo ($row[2]); ?></option>
					<?php
						}
					mysqli_free_result($result); 
					 ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<div class="input-group">	
					<div class="input-group-addon">Id.</div>
					<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text"  />
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">Exp.</div>
					<input name="txt_expedicion<?php echo $NumWindow; ?>" type="text"  id="txt_expedicion<?php echo $NumWindow; ?>"  />
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">Nombre.</div>
					<input name="txt_nombreter<?php echo $NumWindow; ?>" type="text"  id="txt_nombreter<?php echo $NumWindow; ?>"  />
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<button class="btn btn-success btn-block  btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Crear Tercero" onclick="SaveTerc<?php echo $NumWindow; ?>();" >
					Guardar Tercero <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				</button>
			</div>
		</div>

	  </div>
	</div>

</form>

<script >

<?php
if (isset($_GET["ElMov"])) {
	echo "
	document.getElementById('txt_idcaja".$NumWindow."').value='".$_GET["LaCaja"]."';
	document.getElementById('cmb_tipmov".$NumWindow."').value='".$_GET["ElMov"]."';
	document.getElementById('cmb_tiping".$NumWindow."').value='".$_GET["ElTipIng"]."';
	document.getElementById('txt_ingreso".$NumWindow."').value='".$_GET["ElIngreso"]."';
	document.getElementById('txt_paciente".$NumWindow."').value='".$_GET["ElPte"]."';
	document.getElementById('txt_valor".$NumWindow."').value='".$_GET["ElValor"]."';
	document.getElementById('txt_nota".$NumWindow."').value='".$_GET["LaNota"]."';
	document.getElementById('txt_concepto".$NumWindow."').value='".$_GET["ElConcepto"]."';
	";
	if ($_GET["LaCaja"]!="") {
		$SQL="Select Nombre_CJA, FechaApertura_MDC, Nombre_USR, Consec_CJA From czmovcajadiario a, czcajas b, itusuarios c Where a.Codigo_CJA=b.Codigo_CJA and a.Codigo_USR=c.Codigo_USR and Estado_MDC='1' and a.Codigo_CJA='".$_GET["LaCaja"]."'";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) {
			echo "
			document.getElementById('txt_nombrecaja".$NumWindow."').value='".$row[0]."';
			document.getElementById('txt_fechacaja".$NumWindow."').value='".$row[1]."';
			document.getElementById('txt_usrcaja".$NumWindow."').value='".$row[2]."';
			document.getElementById('hdn_conseccja".$NumWindow."').value='".$row[3]."';
			";
		} else {
			echo "
			alert('No se encuentra la caja abierta ".$_GET["LaCaja"]."');";
		}
		mysqli_free_result($result);
	}
	if (isset($_GET["ElIngreso"])) {
		if ($_GET["ElIngreso"]!="") {
			$SQL="Select Fecha_ADM, ID_TER From gxadmision a, czterceros b Where a.Codigo_TER=b.Codigo_TER and LPAD(a.Codigo_ADM,10,'0')=LPAD('".$_GET["ElIngreso"]."',10,'0') and  a.estado_adm<>'A'";
			$result = mysqli_query($conexion, $SQL);
			if ($row = mysqli_fetch_array($result)) {
				echo "
				document.getElementById('txt_fechaing".$NumWindow."').value='".$row[0]."';
				document.getElementById('txt_paciente".$NumWindow."').value='".$row[1]."';
				";
				$_GET["ElPte"]=$row[1];
			} else {
				echo "
				alert('No se encuentra el ingreso ".$_GET["ElIngreso"]."');";
			}
			mysqli_free_result($result);
		}
	}
	if (isset($_GET["ElPte"])) {
		if ($_GET["ElPte"]!="") {
			echo "
			NombreTercero('".$NumWindow."', '".$_GET["ElPte"]."', 'czterceros');
			";
			$SQL="Select Codigo_TER From czterceros Where ID_TER='".$_GET["ElPte"]."';";
			$resultw = mysqli_query($conexion, $SQL);
			if ($roww = mysqli_fetch_array($resultw)) {
				echo "
				document.getElementById('hdn_tercero".$NumWindow."').value='".$roww[0]."';
				";
			}
			mysqli_free_result($resultw);
		}
	}
}
if (isset($_GET["ElOrigen"])) {
	echo "
	document.getElementById('hdn_origen".$NumWindow."').value='".$_GET["ElOrigen"]."';
	";
	if ($_GET["ElOrigen"]=="Ingresos") {
		echo 'document.getElementById("cmb_tipmov'.$NumWindow.'").disabled =false;
		document.getElementById("cmb_tiping'.$NumWindow.'").disabled =false;
		document.getElementById("txt_ingreso'.$NumWindow.'").disabled =false;
		document.getElementById("txt_paciente'.$NumWindow.'").disabled =false;
		';
	}
}
?>

function SaveTerc<?php echo $NumWindow; ?>() {
	TipoID=document.getElementById('cmb_tipoid<?php echo $NumWindow; ?>').value;
	TheID=document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value;
	LugarExp=document.getElementById('txt_expedicion<?php echo $NumWindow; ?>').value;
	NombreTer=document.getElementById('txt_nombreter<?php echo $NumWindow; ?>').value;
	GuardarTercero(TipoID, TheID, LugarExp, NombreTer);
	$("#collapseTercero").collapse('hide');
	document.getElementById('txt_paciente<?php echo $NumWindow; ?>').value=document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value;
	$( "#txt_paciente<?php echo $NumWindow; ?>" ).focus();
	$( "#txt_valor<?php echo $NumWindow; ?>" ).focus();
}

function TipoIng<?php echo $NumWindow; ?>(comboMov) {
	switch (comboMov) {
	<?php
	$SQL="Select Codigo_TMC, Nombre_TMC, Naturaleza_TMC From cztipomovcaja Where Estado_TMC='1'";
	$result = mysqli_query($conexion, $SQL);
	while ($row = mysqli_fetch_array($result)) {
		if ($row[2]=="I") {
			$enableded="false";
		} else {
			$enableded="true";
		}

		echo 'case "'.$row[0].'":
			document.getElementById("cmb_tiping'.$NumWindow.'").disabled ='.$enableded.';
	break;
	';
 	}
	mysqli_free_result($result);
	?>
	}
}

function BuscarIngreso<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  Recargar<?php echo $NumWindow; ?>();
  }
}

function BuscarIngreso2<?php echo $NumWindow; ?>() {
	Recargar<?php echo $NumWindow; ?>();	
}

function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  Recargar<?php echo $NumWindow; ?>();
  }
}

function BuscarPte2<?php echo $NumWindow; ?>() {
	Recargar<?php echo $NumWindow; ?>();	
}

function BuscarCaja<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  Recargar<?php echo $NumWindow; ?>();
  }
}

function BuscarCaja2<?php echo $NumWindow; ?>() {
	Recargar<?php echo $NumWindow; ?>();	
}

function Recargar<?php echo $NumWindow; ?>() {
	LaCaja=document.getElementById('txt_idcaja<?php echo $NumWindow; ?>').value;
	ElMov=document.getElementById('cmb_tipmov<?php echo $NumWindow; ?>').value;
	ElTipIng=document.getElementById('cmb_tiping<?php echo $NumWindow; ?>').value;
	ElIngreso=document.getElementById('txt_ingreso<?php echo $NumWindow; ?>').value;
	ElPte=document.getElementById('txt_paciente<?php echo $NumWindow; ?>').value;
	ElValor=document.getElementById('txt_valor<?php echo $NumWindow; ?>').value;
	ElOrigen=document.getElementById('hdn_origen<?php echo $NumWindow; ?>').value;
	LaNota=document.getElementById('txt_nota<?php echo $NumWindow; ?>').value;
	ElConcepto=document.getElementById('txt_concepto<?php echo $NumWindow; ?>').value;
	AbrirForm('application/forms/cajasmov.php', '<?php echo $NumWindow; ?>', '&ElMov='+ElMov+'&ElTipIng='+ElTipIng+'&LaCaja='+LaCaja+'&ElIngreso='+ElIngreso+'&ElPte='+ElPte+'&ElValor='+ElValor+'&ElOrigen='+ElOrigen+'&ElConcepto='+ElConcepto+'&LaNota='+LaNota);
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/cajasmov.php', '<?php echo $NumWindow; ?>', '');	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
