<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$factura="";
	if (isset($_GET["faktura"])) {
		$factura=str_replace("!", " ", $_GET["faktura"] );
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row well well-sm">
			<div class="col-md-1">

		<div class="form-group">
			<label for="txt_pago<?php echo $NumWindow; ?>"># Pago</label>
			<div class="input-group" id="grp_txt_pago<?php echo $NumWindow; ?>">	
				<input name="txt_pago<?php echo $NumWindow; ?>" id="txt_pago<?php echo $NumWindow; ?>" style="font-size:14px; text-align:center;font-weight: bold;" type="text" value="<?php echo $factura; ?>"  onblur="TraerFactura<?php echo $NumWindow; ?>();" onkeypress="BuscarFact<?php echo $NumWindow; ?>(event);" />
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="CartFactura" onclick="javascript:CargarSearch('PagosCartera', 'txt_pago<?php echo $NumWindow; ?>', 'Estado_PGS=*1*');" ><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		
			</div>	
			<div class="col-md-3">
		<div class="form-group">
			<label for="txt_tercero<?php echo $NumWindow; ?>">Tercero</label>
			<input name="txt_tercero<?php echo $NumWindow; ?>" id="txt_tercero<?php echo $NumWindow; ?>" style="font-size:14px;font-weight: bold;" type="text" value="" disabled />
		</div>
			</div>
			<div class="col-md-1">
		<div class="form-group">
			<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
			<input name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>"  type="text" style="font-size:14px;font-weight: bold;" disabled />
		</div>
			</div>
			<div class="col-md-2">
		<div class="form-group">
			<label for="txt_valor<?php echo $NumWindow; ?>">Valor</label>
			<input name="txt_valor<?php echo $NumWindow; ?>" id="txt_valor<?php echo $NumWindow; ?>"  type="text" style="font-size:14px;font-weight: bold;text-align: right;" disabled value="0" />
		</div>
			</div>
			<div class="col-md-2">
		<div class="form-group">
			<label for="txt_fpago<?php echo $NumWindow; ?>">Forma Pago</label>
			<input name="txt_fpago<?php echo $NumWindow; ?>" id="txt_fpago<?php echo $NumWindow; ?>"  type="text" style="font-size:14px;font-weight: bold;" disabled />
		</div>
			</div>
			<div class="col-md-3">
		<div class="form-group">
			<label for="txt_ctabco<?php echo $NumWindow; ?>">Cuenta Banco</label>
			<input name="txt_ctabco<?php echo $NumWindow; ?>" id="txt_ctabco<?php echo $NumWindow; ?>"  type="text" style="font-size:14px;font-weight: bold;" disabled />
		</div>
			</div>
			<div class="col-md-12">

		<div class="form-group">
			<label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
			<textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="2" id="txt_observacion<?php echo $NumWindow; ?>" disabled>
			</textarea>
		</div>

			</div> 
			<div class="col-md-6">
        <button type="button" class="btn btn-success btn-sm btn-block" title="Exportar" data-toggle="modal" data-target="#GnmX_WinModal" onclick="previewpago<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> VER DETALLE</button>
			</div>
			<div class="col-md-6">
		<button type="button" class="btn btn-success btn-sm btn-block" onclick="Guardar_pagoscartconf('<?php echo $NumWindow; ?>')"> <span class="glyphicon glyphicon-saved" aria-hidden="true"></span> CONFIRMAR PAGO</button>
			</div>			
			
		</div>
		
		<div class="row">
			<div class="col-md-12">
		<div class="row">
			<iframe src="" frameborder="0" allowtransparency="true" style="margin:0; padding:0; width:100%; height: 70%; " name="iframecont<?php echo $NumWindow; ?>" id="iframecont<?php echo $NumWindow; ?>" class="pdf1 panel-body">      </iframe>

		</div>

			</div>
		</div>
	
		
		
<input name="hdn_totregistros<?php echo $NumWindow; ?>" type="hidden" id="hdn_totregistros<?php echo $NumWindow; ?>" value="<?php echo $totregistros; ?>" />
</form>

<script >
	TotalFilas=0;
<?php
	if ($factura!="") {	
	$SQL="SELECT a.Codigo_PGS, a.Fecha_PGS, d.Nombre_TER, e.Nombre_FPG, f.Nombre_BCO, a.Total_PGS, a.Observaciones_PGS
FROM czpagosenc a, czterceros d, czformasdepago e, czbancos f
WHERE  d.Codigo_TER=a.Codigo_TER AND e.Codigo_FPG=a.Codigo_FPG
AND f.Codigo_BCO=a.Codigo_BCO AND a.Codigo_PGS = '".$factura."' AND Estado_PGS='1'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_tercero".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".FormatoFecha($row[1])."';
		document.frm_form".$NumWindow.".txt_valor".$NumWindow.".value='$ ".$row[5]."';
		document.frm_form".$NumWindow.".txt_fpago".$NumWindow.".value='".$row[3]."';
		document.frm_form".$NumWindow.".txt_ctabco".$NumWindow.".value='".$row[4]."';
		document.frm_form".$NumWindow.".txt_observacion".$NumWindow.".innerHTML='".$row[6]."';
	";
	}
	else {
		echo "
		MsgBox1('Pagos Cartera','No se encuentra el pago ".$factura."');
		";
	}
	mysqli_free_result($result); 
	}
?>

function previewpago<?php echo $NumWindow; ?>() {
	CargarWind('Detalle Pago de Cartera <?php echo $factura; ?>', 'reports/pagoscartera.php?CODIGO_INICIAL=<?php echo $factura; ?>&CODIGO_FINAL=<?php echo $factura; ?>', 'card_money.png', 'pagoscartconf.php','<?php echo $NumWindow; ?>' );
}

 function BuscarFact<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AbrirForm('application/forms/pagoscartconf.php', '<?php echo $NumWindow; ?>', '&faktura='+document.getElementById('txt_pago<?php echo $NumWindow; ?>').value);
  }
 }

 function TraerFactura<?php echo $NumWindow; ?>() {
 	AbrirForm('application/forms/pagoscartconf.php', '<?php echo $NumWindow; ?>', '&faktura='+document.getElementById('txt_pago<?php echo $NumWindow; ?>').value);
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
