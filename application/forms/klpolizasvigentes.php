<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	 if (isset($_GET["dias"])) {
        $dias=$_GET["dias"];
        $tipo=$_GET["tipo"];
    } else {
        $dias="7";
        $tipo="c.FechaIni_CTZ";
        flush();
    }
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal col-md-12" id="frm_form<?php echo $NumWindow; ?>"  >

<label class="label label-success"> POLIZAS A ENTRAR EN VIGENCIA</label>
	<div class="row well well-sm">
		<div class="col-md-4 col-md-offset-5"><select class="form-select" id="cmb_tipo<?php echo $NumWindow; ?>" name="cmb_tipo<?php echo $NumWindow; ?>" ><option value="c.FechaIni_CTZ">Mostrar pólizas que entran en vigencia hasta en</option><option value="c.FechaFin_CTZ">Mostrar pólizas que entran vencen hasta en</option>  </select></div> <div class="col-md-3 "><div class="input-group input-group-sm"> <input type="number" class="form-control" style="text-align: center; font-weight: bold; color: #7faf42;" id="txt_dias<?php echo $NumWindow; ?>" max="30" min="1" value="<?php echo $dias; ?>"><span class="input-group-addon" style="color: #7faf42;">días</span><span class="input-group-btn"> <button class="btn btn-success" type="button" onclick="refresk<?php echo $NumWindow; ?>();"> <i class="fas fa-sync-alt"></i> </button> </span></div></div>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style=" height: 80%;">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetalle table-striped table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="thant<?php echo $NumWindow; ?>">#</th> 
					<th id="thant<?php echo $NumWindow; ?>">POLIZA</th> 	
					<th id="thant<?php echo $NumWindow; ?>">CLIENTE</th> 
					<th id="thant<?php echo $NumWindow; ?>">AGENCIA</th> 
					<th id="thant<?php echo $NumWindow; ?>">PROMOTOR</th> 
					<th id="thant<?php echo $NumWindow; ?>">PLAN</th> 
					<th id="thant<?php echo $NumWindow; ?>">INICIA</th>
					<th id="thant<?php echo $NumWindow; ?>">FINALIZA</th>
					<th id="thant<?php echo $NumWindow; ?>">RECORDAR</th> 
				</tr> 
<?php
		$SQL="SELECT d.Codigo_EMI, a.Nombre_TER, b.Nombre_AGE, e.Nombre_USR, f.Nombre_PLA, c.FechaIni_CTZ, Prefijo_EMI, Correo_TER, c.FechaFin_CTZ FROM czterceros a, klagencias b, klcotizaciones c, klemisiones d, itusuarios e, klplanes f WHERE c.Codigo_CTZ=d.Codigo_CTZ AND c.Codigo_TER= a.Codigo_TER AND c.Codigo_AGE=b.Codigo_AGE AND e.Codigo_USR=d.Codigo_USR AND f.Codigo_PLA=c.Codigo_PLA AND d.Estado_EMI<> 'A'  AND ".$tipo." BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL +".$dias." DAY) ORDER BY 6 ASC";
		if ($_SESSION["it_CodigoPRF"]=="0") {
			$SQL="SELECT d.Codigo_EMI, a.Nombre_TER, b.Nombre_AGE, e.Nombre_USR, f.Nombre_PLA, c.FechaIni_CTZ, Prefijo_EMI, Correo_TER, c.FechaFin_CTZ FROM czterceros a, klagencias b, klcotizaciones c, klemisiones d, itusuarios e, klplanes f WHERE c.Codigo_CTZ=d.Codigo_CTZ AND c.Codigo_TER= a.Codigo_TER AND c.Codigo_AGE=b.Codigo_AGE AND e.Codigo_USR=d.Codigo_USR AND f.Codigo_PLA=c.Codigo_PLA AND d.Estado_EMI<> 'A'  AND ".$tipo." BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL +".$dias." DAY) ORDER BY 6 ASC";
		} else {
			$SQL="SELECT d.Codigo_EMI, a.Nombre_TER, b.Nombre_AGE, e.Nombre_USR, f.Nombre_PLA, c.FechaIni_CTZ, Prefijo_EMI, Correo_TER, c.FechaFin_CTZ FROM czterceros a, klagencias b, klcotizaciones c, klemisiones d, itusuarios e, klplanes f WHERE AND d.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and c.Codigo_CTZ=d.Codigo_CTZ AND c.Codigo_TER= a.Codigo_TER AND c.Codigo_AGE=b.Codigo_AGE AND e.Codigo_USR=d.Codigo_USR AND f.Codigo_PLA=c.Codigo_PLA AND d.Estado_EMI<> 'A'  AND ".$tipo." BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL +".$dias." DAY) ORDER BY 6 ASC";
		}
		$result = mysqli_query($conexion, $SQL);
		$contarow=0;
		while ($row = mysqli_fetch_array($result)) {
			$contarow++;
			if (filter_var($row[7], FILTER_VALIDATE_EMAIL)) {
			    $enabledmail="";
			} else {
				$enabledmail=' disabled="disabled" ';
			}
			echo '
			<tr id="tr'.$NumWindow.'" style="   font-size: 11px;"> 
					<td id="th0'.$NumWindow.'" align="right" style="color: #EFEFEF; background-color: #7faf42;">'.$contarow.'</td> 
					<td id="th1'.$NumWindow.'" align="center">'.$row[6].'-'.str_pad($row[0], 10, "0", STR_PAD_LEFT).'</td> 
					<td id="th2'.$NumWindow.'" align="left">'.$row[1] .'</td> 
					<td id="th3'.$NumWindow.'" align="left">'.$row[2] .'</td> 
					<td id="th4'.$NumWindow.'" align="left">'.$row[3].'</td> 
					<td id="th5'.$NumWindow.'" align="left">'.$row[4].'</td> 
					<td id="th6'.$NumWindow.'" align="center"><b>'.$row[5].'</b></td> 
					<td id="th8'.$NumWindow.'" align="center"><b>'.$row[8].'</b></td> 
					<td id="th7'.$NumWindow.'" align="center">
						<div class="btn-group btn-group-xs" role="group" aria-label="...">
						  <button class="btn btn-success" onclick="MailPoliza'.$NumWindow.'(\''.$row[0].'\')" '.$enabledmail.' title="Enviar eMail"> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>
						  <button class="btn btn-primary" onclick="SMSPoliza'.$NumWindow.'(\''.$row[0].'\')" '.$enabledmail.' title="Enviar SMS"> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
						</div>
					</td> 
				</tr> 
			';
		}
		mysqli_free_result($result);
	
?>
			</tbody>
				</table>
			</div>
		<div class="col-md-12"><p align="right"> Total pólizas a entrar en vigencia encontradas: <b><?php echo $contarow; ?></b> </p></div>
	</div>

</form>

<script >

document.getElementById('cmb_tipo<?php echo $NumWindow; ?>').value='<?php echo $tipo; ?>';

function refresk<?php echo $NumWindow; ?>() {
	diax=document.getElementById('txt_dias<?php echo $NumWindow; ?>').value;
	tipo=document.getElementById('cmb_tipo<?php echo $NumWindow; ?>').value;
	AbrirForm('application/forms/klpolizasvigentes.php', '<?php echo $NumWindow; ?>', '&dias='+diax+'&tipo='+tipo);
}

function MailPoliza<?php echo $NumWindow; ?>(Poliza) {
  

  nxs_mailing($desde, $para, $titulo, $mensaje);
  
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
