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
			<div class="col-md-2">

		<div class="form-group">
			<label for="txt_factura<?php echo $NumWindow; ?>">Factura</label>
			<div class="input-group" id="grp_txt_factura<?php echo $NumWindow; ?>">	
				<input name="txt_factura<?php echo $NumWindow; ?>" id="txt_factura<?php echo $NumWindow; ?>" style="font-size:14px; text-align:center;font-weight: bold;" type="text" value="<?php echo $factura; ?>"  onblur="TraerFactura<?php echo $NumWindow; ?>();" onkeypress="BuscarFact<?php echo $NumWindow; ?>(event);" <?php if (isset($_GET["faktura"])) { echo 'disabled'; } ?>/>
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="CartFactura" onclick="javascript:CargarSearch('FacturaCartera', 'txt_factura<?php echo $NumWindow; ?>', 'NULL');" <?php if (isset($_GET["faktura"])) { echo 'disabled'; } ?>><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
				</span>
			</div>
		</div>
		
			</div>	
			<div class="col-md-2">
	
		<div class="form-group">
			<label for="txt_radicado<?php echo $NumWindow; ?>">Radicado</label>
			<input style="font-size:14px; text-align:center;font-weight: bold;" name="txt_radicado<?php echo $NumWindow; ?>" id="txt_radicado<?php echo $NumWindow; ?>" type="text" disabled="disabled" value=""/>
		</div>

			</div>
			<div class="col-md-2">
	
		<div class="form-group">
			<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
			<input style="font-size:14px; text-align:center;font-weight: bold;" name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="00/00/0000"/>
		</div>

			</div>
			<div class="col-md-2">
	
		<div class="form-group">
			<label for="txt_confirmado<?php echo $NumWindow; ?>">Confirmado</label>
			<input style="font-size:14px; text-align:center;font-weight: bold;" name="txt_confirmado<?php echo $NumWindow; ?>" id="txt_confirmado<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="00/00/0000"/>
		</div>

			</div>
			<div class="col-md-2">
	
		<div class="form-group">
			<label for="txt_sello<?php echo $NumWindow; ?>">Sello</label>
			<input style="font-size:14px; text-align:center;font-weight: bold;" name="txt_sello<?php echo $NumWindow; ?>" id="txt_sello<?php echo $NumWindow; ?>" type="text" disabled="disabled" value=""/>
		</div>

			</div>
			<div class="col-md-2">
	
		<div class="form-group">
			<label for="txt_usuario<?php echo $NumWindow; ?>">Usuario</label>
			<input style="font-size:14px; text-align:center;font-weight: bold;" name="txt_usuario<?php echo $NumWindow; ?>" id="txt_usuario<?php echo $NumWindow; ?>" type="text" disabled="disabled" value=""/>
		</div>

			</div>				
			
		</div>
		
		<div class="row">
			<div class="col-md-4">

			<div class="col-md-12">
			<label>Notas Crédito</label>
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive  " style="height:120px;">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleNC<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalleNC<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Fecha</th>
				<th id="th1<?php echo $NumWindow; ?>">#</th> 
				<th id="th2<?php echo $NumWindow; ?>">Valor</th> 
			</tr> 
			 </tbody>
			</table>
	</div>
			</div>
			<div class="col-md-12">
			<label>Notas Débito</label>
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive  " style="height:120px;">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleND<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalleND<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Fecha</th> 
				<th id="th1<?php echo $NumWindow; ?>">#</th>
				<th id="th2<?php echo $NumWindow; ?>">Valor</th> 
			</tr> 
			 </tbody>
			</table>
	</div>
			</div>
			<div class="col-md-12">
			<label>Pagos</label>
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:120px;">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallePG<?php echo $NumWindow; ?>" >
			<tbody id="tbDetallePG<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Fecha</th> 
				<th id="th1<?php echo $NumWindow; ?>">#</th>
				<th id="th2<?php echo $NumWindow; ?>">Valor</th> 
			</tr> 
			 </tbody>
			</table>
	</div>
			</div>

			</div>
			<div class="col-md-8">
		<div class="row">
			<iframe src="" frameborder="0" allowtransparency="true" style="margin:0; padding:0; width:100%; height: 70%; " name="iframecont<?php echo $NumWindow; ?>" id="iframecont<?php echo $NumWindow; ?>" class="pdf1 panel-body">      </iframe>

		</div>

			</div>
		</div>
	
		
</form>

<script >
	TotalFilas=0;
/*
	 */
 <?php
 	if ($factura!="") {
 		//PreView Factura
 		$Pref="";
 		$Num="";
 		$Pos=strpos($factura,' ');
 		if ($Pos!== false) {
 			$Pref=substr($factura, 0, $Pos);
 			$Num=substr($factura, $Pos+1, strlen($factura) - $Pos);
 		} else {
 			$Num=trim($factura);
 		}
 		$Num=intval($Num);
 		
 		echo '
	window.frames.iframecont'.$NumWindow.'.location.href = (\'application/reports/facturasaluddet.php?PREFIJO='.$Pref.'&CODIGO_INICIAL='.$Num.'&CODIGO_FINAL='.$Num.'\');
		';
		
		$SQL="Select a.Codigo_RAD, date(a.Fecha_RAD), date(a.FechaConf_RAD), c.Nombre_USR, Radicado_RAD From czradicacionescab a, czradicacionesdet b, itusuarios c Where c.Codigo_USR=a.UsuarioConf_USR and a.Codigo_RAD=b.Codigo_RAD and b.Codigo_FAC='".$factura."'";
		$resulthc = mysqli_query($conexion, $SQL);
		if ($rowhc = mysqli_fetch_array($resulthc)) {
			echo '
		document.getElementById(\'txt_radicado'.$NumWindow.'\').value=\''.$rowhc[0].'\';
		document.getElementById(\'txt_fecha'.$NumWindow.'\').value=\''.formatofecha($rowhc[1]).'\';
		document.getElementById(\'txt_confirmado'.$NumWindow.'\').value=\''.formatofecha($rowhc[2]).'\';
		document.getElementById(\'txt_usuario'.$NumWindow.'\').value=\''.$rowhc[3].'\';
		document.getElementById(\'txt_sello'.$NumWindow.'\').value=\''.$rowhc[4].'\';
			';
		}
		mysqli_free_result($resulthc); 
 		//NCredito
 		echo '
 		var miTablaNC = document.getElementById("tblDetalleNC'.$NumWindow.'"); ';
    	$kontafilas=0;
 		$SQL="Select a.Fecha_NCT, a.Codigo_NCT, a.Valor_NCT From cznotascontablesenc a Where NumeroDoc_NCT='".$factura."' and Estado_NCT<>'0' and Naturaleza_NCT='C'";
 		$resulthc = mysqli_query($conexion, $SQL);
		while($rowhc = mysqli_fetch_array($resulthc)) {
			$kontafilas++;
			echo '
	var fila'.$kontafilas.' = document.createElement("tr"); 
    var celda'.$kontafilas.'_0 = document.createElement("td"); 
    var celda'.$kontafilas.'_1 = document.createElement("td"); 
    var celda'.$kontafilas.'_2 = document.createElement("td"); 
    TotalFilas++;
    fila'.$kontafilas.'.id="trNC'.$kontafilas.$NumWindow.'";
	celda'.$kontafilas.'_0.innerHTML = "'.$rowhc[0].'"; 
	celda'.$kontafilas.'_1.innerHTML = "'.$rowhc[1].'"; 
	celda'.$kontafilas.'_2.innerHTML = "'.$rowhc[2].'"; 
	fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_0); 
    fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_1); 
    fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_2); 
    miTablaNC.appendChild(fila'.$kontafilas.');
	';
		}
		mysqli_free_result($resulthc); 
		//NDebito
 		echo '
 		var miTablaND = document.getElementById("tblDetalleND'.$NumWindow.'"); ';
    	$kontafilas=0;
 		$SQL="Select a.Fecha_NCT, a.Codigo_NCT, a.Valor_NCT From cznotascontablesenc a Where NumeroDoc_NCT='".$factura."' and Estado_NCT<>'0' and Naturaleza_NCT='D'";
 		$resulthc = mysqli_query($conexion, $SQL);
		while($rowhc = mysqli_fetch_array($resulthc)) {
			$kontafilas++;
			echo '
	var fila'.$kontafilas.' = document.createElement("tr"); 
    var celda'.$kontafilas.'_0 = document.createElement("td"); 
    var celda'.$kontafilas.'_1 = document.createElement("td"); 
    var celda'.$kontafilas.'_2 = document.createElement("td"); 
    TotalFilas++;
    fila'.$kontafilas.'.id="trND'.$kontafilas.$NumWindow.'";
	celda'.$kontafilas.'_0.innerHTML = "'.$rowhc[0].'"; 
	celda'.$kontafilas.'_1.innerHTML = "'.$rowhc[1].'"; 
	celda'.$kontafilas.'_2.innerHTML = "'.$rowhc[2].'"; 
	fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_0); 
    fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_1); 
    fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_2); 
    miTablaND.appendChild(fila'.$kontafilas.');
	';
		}
		mysqli_free_result($resulthc); 
		//NDebito
 		echo '
 		var miTablaPG = document.getElementById("tblDetallePG'.$NumWindow.'"); ';
    	$kontafilas=0;
 		$SQL="Select a.Fecha_PGS, a.Codigo_PGS, b.Valor_PGS From czpagosenc a, czpagosdet b Where a.Codigo_PGS=b.Codigo_PGS and  Codigo_FAC='".$factura."' and Estado_PGS<>'0' ";
 		$resulthc = mysqli_query($conexion, $SQL);
		while($rowhc = mysqli_fetch_array($resulthc)) {
			$kontafilas++;
			echo '
	var fila'.$kontafilas.' = document.createElement("tr"); 
    var celda'.$kontafilas.'_0 = document.createElement("td"); 
    var celda'.$kontafilas.'_1 = document.createElement("td"); 
    var celda'.$kontafilas.'_2 = document.createElement("td"); 
    TotalFilas++;
    fila'.$kontafilas.'.id="trPG'.$kontafilas.$NumWindow.'";
	celda'.$kontafilas.'_0.innerHTML = "'.$rowhc[0].'"; 
	celda'.$kontafilas.'_1.innerHTML = "'.$rowhc[1].'"; 
	celda'.$kontafilas.'_2.innerHTML = "'.$rowhc[2].'"; 
	fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_0); 
    fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_1); 
    fila'.$kontafilas.'.appendChild(celda'.$kontafilas.'_2); 
    miTablaPG.appendChild(fila'.$kontafilas.');
	';
		}
		mysqli_free_result($resulthc); 
 	}
 ?>

 function BuscarFact<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	faktura=document.getElementById('txt_factura<?php echo $NumWindow; ?>').value;
  	if (faktura!='') {
  		faktura=faktura.replace(" ", "!");
		$("#<?php echo $NumWindow; ?>").load('application/forms/factdetcar.php?target=<?php echo $NumWindow; ?>&faktura='+faktura);
	}
  }
 }

 function TraerFactura<?php echo $NumWindow; ?>() {
 	faktura=document.getElementById('txt_factura<?php echo $NumWindow; ?>').value;
  	if (faktura!='') {
  		faktura=faktura.replace(" ", "!");
		$("#<?php echo $NumWindow; ?>").load('application/forms/factdetcar.php?target=<?php echo $NumWindow; ?>&faktura='+faktura);
	}
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
