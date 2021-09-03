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

<?php
$LaCaja="";
$NombreCaja="";
$FechaCaja="";
$UsrCaja="";
$IniCaja="0.00";
$ConsecCaja="0";
if (isset($_GET["LaCaja"])) {
	if ($_GET["LaCaja"]!="") {
		$SQL="Select Nombre_CJA, FechaApertura_MDC, Nombre_USR, a.SaldoInicial_MDC, Consec_CJA From czmovcajadiario a, czcajas b, itusuarios c Where a.Codigo_CJA=b.Codigo_CJA and a.Codigo_USR=c.Codigo_USR and Estado_MDC='1' and a.Codigo_CJA='".$_GET["LaCaja"]."'";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) {
			$LaCaja=$_GET["LaCaja"];
			$NombreCaja=$row[0];
			$FechaCaja=$row[1];
			$UsrCaja=$row[2];
			$IniCaja=$row[3];
			$ConsecCaja=$row[4];
		} else {
			echo "
			alert('No se encuentra la caja abierta ".$_GET["LaCaja"]."');";
		}
		mysqli_free_result($result);
	}
}
?>
	<label class="label label-success"> DATOS CAJA ABIERTA</label>
	<div class="row well well-sm">

				<div class="col-md-1">
			<div class="form-group">
				<label for="txt_idcaja<?php echo $NumWindow; ?>">Caja Abierta</label>
				<div class="input-group">	
					<input name="txt_idcaja<?php echo $NumWindow; ?>" id="txt_idcaja<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCaja<?php echo $NumWindow; ?>(event);" onblur="BuscarCaja2<?php echo $NumWindow; ?>();" value="<?php echo $LaCaja; ?>" />
					<span class="input-group-btn">	
						<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Caja" onclick="javascript:CargarSearch('Caja', 'txt_idcaja<?php echo $NumWindow; ?>', 'Abierta_CJA=*1*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</span>
				</div>
			</div>
		</div>

<input type="hidden" name="hdn_conseccja<?php echo $NumWindow; ?>" id="hdn_conseccja<?php echo $NumWindow; ?>" value="<?php echo $ConsecCaja; ?>" />

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_nombrecaja<?php echo $NumWindow; ?>">Descripcion</label>
		<input  name="txt_nombrecaja<?php echo $NumWindow; ?>" id="txt_nombrecaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" value="<?php echo $NombreCaja; ?>" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_fechacaja<?php echo $NumWindow; ?>">Fecha Apertura</label>
		<input  name="txt_fechacaja<?php echo $NumWindow; ?>" id="txt_fechacaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" value="<?php echo $FechaCaja; ?>" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_usrcaja<?php echo $NumWindow; ?>">Usuario Apertura</label>
		<input  name="txt_usrcaja<?php echo $NumWindow; ?>" id="txt_usrcaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" value="<?php echo $UsrCaja; ?>" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_inicialcaja<?php echo $NumWindow; ?>">Saldo Inicial</label>
		<input  name="txt_inicialcaja<?php echo $NumWindow; ?>" id="txt_inicialcaja<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" style="font-size:15px; font-weight: bold; color:#0E5012; " value="<?php echo $IniCaja; ?>"/>
	</div>

		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="cmb_optcierre<?php echo $NumWindow; ?>">Opcion de Cierre</label>
				<select name="cmb_optcierre<?php echo $NumWindow; ?>" id="cmb_optcierre<?php echo $NumWindow; ?>" >
				<option value="SI" >Arrastrar saldo de caja para próxima apertura</option>
			  	<option value="NO" >No arrastrar saldo de caja para próxima apertura</option>
			  	</select>
				<input name="hdn_origen<?php echo $NumWindow; ?>" type="hidden" id="hdn_origen<?php echo $NumWindow; ?>" value="" />
			</div>
		</div> 

	</div>

	<div class="row well well-sm">

<?php
$TotIngreso="0.00";
$TotEgreso="0.00";
$TotSaldo="0.00";
if (isset($_GET["LaCaja"])) {
	if ($_GET["LaCaja"]!="") {
		$SQL="Select sum(b.Valor_MCJ) From czmovcajaenc a, czmovcajadet b, cztipomovcaja c Where a.Codigo_MCJ=b.Codigo_MCJ and c.Codigo_TMC=a.Codigo_TMC and Estado_MCJ='1' and a.Codigo_CJA='".$_GET["LaCaja"]."' and c.Naturaleza_TMC='I' and Consec_CJA='".$ConsecCaja."' ";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) {
			$TotIngreso=$row[0];
		} 
		mysqli_free_result($result);
		$SQL="Select sum(b.Valor_MCJ) From czmovcajaenc a, czmovcajadet b, cztipomovcaja c Where a.Codigo_MCJ=b.Codigo_MCJ and c.Codigo_TMC=a.Codigo_TMC and Estado_MCJ='1' and a.Codigo_CJA='".$_GET["LaCaja"]."' and c.Naturaleza_TMC='E' and Consec_CJA='".$ConsecCaja."'";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) {
			$TotEgreso=$row[0];
		} 
		mysqli_free_result($result);
		$TotSaldo=$TotIngreso-$TotEgreso;
	}
}
?>
		<div class="col-md-4">

	<div class="form-group" >
		<label for="txt_totingresos<?php echo $NumWindow; ?>">Total Ingresos</label>
		<input  name="txt_totingresos<?php echo $NumWindow; ?>" id="txt_totingresos<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" style="font-size:16px; font-weight: bold; color:#008800; "  value="<?php echo $TotIngreso; ?>"/>
	</div>

		</div>
		<div class="col-md-4">

	<div class="form-group" >
		<label for="txt_totegresos<?php echo $NumWindow; ?>">Total Egresos</label>
		<input  name="txt_totegresos<?php echo $NumWindow; ?>" id="txt_totegresos<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" style="font-size:16px; font-weight: bold; color:#880000; " value="<?php echo $TotEgreso; ?>" />
	</div>

		</div>
		<div class="col-md-4">

	<div class="form-group" >
		<label for="txt_totsaldo<?php echo $NumWindow; ?>">Saldo Final</label>
		<input  name="txt_totsaldo<?php echo $NumWindow; ?>" id="txt_totsaldo<?php echo $NumWindow; ?>" type="text" required class="form-control" disabled="disabled" style="font-size:16px; font-weight: bold; color:#000088; " value="<?php echo $TotSaldo; ?>" />
	</div>

		</div>

	</div>

	<label class="label label-success"> Totales por forma de pago</label>
	<div class="row well well-sm">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetalle  table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="thant<?php echo $NumWindow; ?>">FORMA DE PAGO</th> 
					<th id="thant<?php echo $NumWindow; ?>">INGRESOS</th> 
					<th id="thant<?php echo $NumWindow; ?>">EGRESOS</th> 
					<th id="thant<?php echo $NumWindow; ?>">SALDO</th> 
				</tr> 
<?php
if (isset($_GET["LaCaja"])) {
	if ($_GET["LaCaja"]!="") {
		$SQL="Select distinct b1.TipoPago_MCJ, concat(b1.TipoPago_MCJ,' - ',c1.Nombre_FPG) From czmovcajaenc a1, czmovcajadet b1, czformasdepago c1 Where a1.Codigo_MCJ=b1.Codigo_MCJ and b1.TipoPago_MCJ=c1.Codigo_FPG and a1.Estado_MCJ='1' and a1.Codigo_CJA='".$_GET["LaCaja"]."' and a1.Consec_CJA=".$ConsecCaja."";
		$result = mysqli_query($conexion, $SQL);
		while ($row = mysqli_fetch_array($result)) {
			$sALDOx=0;
			$iNGREOSx=0;
			$eGRESOSx=0;
			$SQL="Select sum(b1.Valor_MCJ) From czmovcajaenc a1, czmovcajadet b1, czformasdepago c1, cztipomovcaja d1 Where a1.Codigo_MCJ=b1.Codigo_MCJ and b1.TipoPago_MCJ=c1.Codigo_FPG and d1.Codigo_TMC=a1.Codigo_TMC and d1.Naturaleza_TMC='I' and a1.Estado_MCJ='1' and a1.Codigo_CJA='".$_GET["LaCaja"]."' and a1.Consec_CJA=".$ConsecCaja."";
			$resultI = mysqli_query($conexion, $SQL);
			while ($rowI = mysqli_fetch_array($resultI)) {
				$iNGREOSx=$rowI[0];
			}
			mysqli_free_result($resultI);
			$SQL="Select sum(b1.Valor_MCJ) From czmovcajaenc a1, czmovcajadet b1, czformasdepago c1, cztipomovcaja d1 Where a1.Codigo_MCJ=b1.Codigo_MCJ and b1.TipoPago_MCJ=c1.Codigo_FPG and d1.Codigo_TMC=a1.Codigo_TMC and d1.Naturaleza_TMC='E' and a1.Estado_MCJ='1' and a1.Codigo_CJA='".$_GET["LaCaja"]."' and a1.Consec_CJA=".$ConsecCaja."";
			$resultE = mysqli_query($conexion, $SQL);
			while ($rowE = mysqli_fetch_array($resultE)) {
				$eGRESOSx=$rowE[0];
			}
			mysqli_free_result($resultE);
			$sALDOx=$iNGREOSx-$eGRESOSx;
			echo '
			<tr id="tr<?php echo $NumWindow; ?>"> 
					<td id="th2<?php echo $NumWindow; ?>" align="left">'.$row[1] .'</td> 
					<td id="th3<?php echo $NumWindow; ?>" align="right">'.number_format($iNGREOSx,2,'.',',') .'</td> 
					<td id="th4<?php echo $NumWindow; ?>" align="right">'.number_format($eGRESOSx,2,'.',',') .'</td> 
					<td id="th5<?php echo $NumWindow; ?>" align="right">'.number_format($sALDOx,2,'.',',') .'</td> 
				</tr> 
			';
		}
		mysqli_free_result($result);
	}
}
?>
			</tbody>
				</table>
			</div>

	</div>
</form>

<script >

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
	AbrirForm('application/forms/cajascierre.php', '<?php echo $NumWindow; ?>', '&LaCaja='+LaCaja);
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/cajascierre.php', '<?php echo $NumWindow; ?>', '');	
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
