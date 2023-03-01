<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">

		<!-- <div class="col-md-1">

	<div class="form-group" >
		<label for="txt_facturapre<?php echo $NumWindow; ?>">Prefijo</label>
		<select name="txt_facturapre<?php echo $NumWindow; ?>" id="txt_facturapre<?php echo $NumWindow; ?>">
		<?php 
			$SQL="Select distinct a.Prefijo_AFC From czautfacturacion a, gxfacturas b Where a.Codigo_AFC=b.Codigo_AFC and b.Estado_FAC<>'A'  and b.ValTotal_FAC>0 Order By 1;";
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) 
				{
		?>
			<option value="<?php echo $row[0]; ?>"><?php echo ($row[0]); ?></option>
		<?php
				}
			mysqli_free_result($result); 
		?>
		</select>
	</div>
	
		</div> -->
		<div class="col-md-3">

	<div class="form-group" >
		<label for="txt_factura<?php echo $NumWindow; ?>">No Factura</label>
		<div class="input-group">	
			<input name="txt_factura<?php echo $NumWindow; ?>" id="txt_factura<?php echo $NumWindow; ?>" type="text" onkeypress="CargarFact<?php echo $NumWindow; ?>(event);" onblur="CargarFact2<?php echo $NumWindow; ?>();" style="font-size:16px; font-weight: bold; color:#0E5012; " required/>
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('FacturasPre', 'txt_factura<?php echo $NumWindow; ?>', 'Estado_FAC<>*0*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>
	
		</div>
		
		<div class="col-md-2 col-md-offset-7">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Elaboracion NC</label>
		<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="txt_cedula<?php echo $NumWindow; ?>">Paciente</label>
		<input  name="txt_cedula<?php echo $NumWindow; ?>" id="txt_cedula<?php echo $NumWindow; ?>" type="text" required disabled="disabled" />
	</div>

		</div>
		<div class="col-md-5">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_paciente<?php echo $NumWindow; ?>" title="">Nombre</label>
		<input  name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" required disabled="disabled" />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_nit<?php echo $NumWindow; ?>" title="">Entidad</label>
		<input  name="txt_nit<?php echo $NumWindow; ?>" id="txt_nit<?php echo $NumWindow; ?>" type="text" required disabled="disabled" />
	</div>
	
		</div>
		<div class="col-md-5">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_eps<?php echo $NumWindow; ?>" >Cliente</label>
		<input  name="txt_eps<?php echo $NumWindow; ?>" id="txt_eps<?php echo $NumWindow; ?>" type="text" required disabled="disabled" />
	</div>
	
		</div>
		<div class="col-md-9">
<!--
		<label>Servicios</label>
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:50%">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Servicio</th> 
				<th id="th2<?php echo $NumWindow; ?>">Val Unit.</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Cant. Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Val Total</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Cant. ND</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Val Debito</th> 
			</tr> 
			 <?php /*
			 if (isset($_GET["LaFactura"])) {
			 	if (trim($_GET["LaFactura"])!="") {
					$ElPrefijo=substr($_GET["LaFactura"],0,strpos($_GET["LaFactura"],' '));
					$ElNumero=str_pad(substr($_GET["LaFactura"],strpos($_GET["LaFactura"],' ')+1, strlen($_GET["LaFactura"])-strpos($_GET["LaFactura"],' ')), 10, "0", STR_PAD_LEFT);
					$LaFactura=$ElPrefijo.' '.$ElNumero;
					$LaFactura=trim($_GET["LaFactura"]);
					$SQL="Select b.Codigo_SER, d.Nombre_SER, b.ValorEntidad_ORD, sum(b.Cantidad_ORD), sum(b.ValorEntidad_ORD* b.Cantidad_ORD)  From gxordenescab a, gxordenesdet b, gxfacturas c, gxservicios d Where c.Codigo_ADM=a.Codigo_ADM and a.Codigo_ORD=b.Codigo_ORD and  a.Estado_ORD<>'0' and c.Estado_FAC<>'0' and d.Codigo_SER=b.Codigo_SER and c.Codigo_FAC='".$LaFactura."' group by b.Codigo_SER, d.Nombre_SER, b.ValorEntidad_ORD Order By d.Nombre_SER asc";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					$sumtotal=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							$sumtotal=$sumtotal+$rowhc[4];
							echo '
					  <tr >
					  	<td align="left"><input name="hdn_servicio'.$contarow.$NumWindow.'" type="hidden" id="hdn_servicio'.$contarow.$NumWindow.'" value="'.$rowhc[0].'" />'.$rowhc[1].'</td>
					  	<td align="right"><input name="hdn_valserv'.$contarow.$NumWindow.'" type="hidden" id="hdn_valserv'.$contarow.$NumWindow.'" value="'.$rowhc[2].'" />'.$rowhc[2].'</td>
					  	<td align="center"><input name="hdn_cantant'.$contarow.$NumWindow.'" type="hidden" id="hdn_cantant'.$contarow.$NumWindow.'" value="'.$rowhc[3].'" />'.$rowhc[3].'</td>
					  	<td align="right">'.$rowhc[4].'</td>
					  	<td align="right"><input  name="txt_cantserv'.$contarow.$NumWindow.'" id="txt_cantserv'.$contarow.$NumWindow.'" type="number" min="0" max="'.$rowhc[3].'" class="izq form-control" required value="0" style="height:24px;align:right" onchange="calcvalores'.$NumWindow.'();"/></td>
					  	<td align="right"><input  name="txt_totserv'.$contarow.$NumWindow.'" id="txt_totserv'.$contarow.$NumWindow.'" type="number" min="0" max="'.$rowhc[4].'" class="izq form-control" required  value="0" style="height:24px" onchange="calcvalores'.$NumWindow.'();" /></td>
					  </tr>
					  ';
						}
					mysqli_free_result($resulthc); 
				}
			 }
			 */
			 ?>  

			</tbody>
			</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
	</div>
-->
		</div>
		<div class="col-md-3">

		<div class="row">
			<div class="col-md-12">
	<div class="form-group">
		<label for="txt_valfact<?php echo $NumWindow; ?>">Valor Factura</label>
		<input style="font-size:14px; font-weight: bold; color:#828427; " name="txt_valfact<?php echo $NumWindow; ?>" id="txt_valfact<?php echo $NumWindow; ?>" type="number" min="1" class="izq form-control" disabled value="<?php echo $sumtotal; ?>"/>
	</div>
			</div>
			<div class="col-md-12">
	<div class="form-group">
		<label for="txt_valornc<?php echo $NumWindow; ?>">Valor Nota Debito</label>
		<input style="font-size:15px; font-weight: bold; color:#843232; " name="txt_valornc<?php echo $NumWindow; ?>" id="txt_valornc<?php echo $NumWindow; ?>" type="number" min="1" class="izq form-control"  value="0" onchange="calcvalores<?php echo $NumWindow.'();';?>"/>
	</div>
			</div>
			<div class="col-md-12">
	<div class="form-group">
		<label for="txt_valfactnew<?php echo $NumWindow; ?>">Nuevo Valor Factura</label>
		<input style="font-size:14px; font-weight: bold; color:#0E5012; " name="txt_valfactnew<?php echo $NumWindow; ?>" id="txt_valfactnew<?php echo $NumWindow; ?>" type="number" min="1" class="izq form-control" disabled value="<?php echo $sumtotal; ?>"/>
	</div>
			</div>
			<div class="col-md-12">
	<div class="form-group">
		<label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
		<textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="2" id="txt_observacion<?php echo $NumWindow; ?>" required="required" ></textarea>
	</div>
	<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>"  />
			</div>
		</div>

		</div>

<input name="hdn_numfact<?php echo $NumWindow; ?>" type="hidden" id="hdn_numfact<?php echo $NumWindow; ?>" value="" />
</form>

<script >

<?php
	if (isset($_GET["LaFactura"])) {
		if (trim($_GET["LaFactura"])!="") {
			$ElPrefijo=substr($_GET["LaFactura"],0,strpos($_GET["LaFactura"],' '));
			$ElNumero=str_pad(substr($_GET["LaFactura"],strpos($_GET["LaFactura"],' ')+1, strlen($_GET["LaFactura"])-strpos($_GET["LaFactura"],' ')), 10, "0", STR_PAD_LEFT);
			$LaFactura=$ElPrefijo.' '.$ElNumero;
			$LaFactura=$_GET["LaFactura"];
			$SQL="Select a.Codigo_AFC, SUBSTRING(a.Codigo_FAC, length(a.Codigo_FAC)-10), e.Prefijo_AFC,  c.ID_TER,c.Nombre_TER, f.ID_TER, b.Nombre_EPS, a.Fecha_FAC, a.ValTotal_FAC, date(now()), f.Codigo_TER  From gxfacturas a, gxeps b, czterceros c, gxadmision d, czautfacturacion e, czterceros f Where a.Codigo_EPS=b.Codigo_EPS and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=a.Codigo_ADM and d.Estado_ADM='F' and f.Codigo_TER=b.Codigo_TER and Estado_FAC<>'0' and ValTotal_FAC>0 and e.Codigo_AFC=a.Codigo_AFC and a.codigo_fac='".$LaFactura."'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_array($result)) {
			echo "
				
				document.frm_form".$NumWindow.".txt_factura".$NumWindow.".value='".$LaFactura."';
				document.frm_form".$NumWindow.".txt_cedula".$NumWindow.".value='".$row[3]."';
				document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[4]."';
				document.frm_form".$NumWindow.".txt_nit".$NumWindow.".value='".$row[5]."';
				document.frm_form".$NumWindow.".txt_eps".$NumWindow.".value='".$row[6]."';
				document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$row[9]."';
				document.frm_form".$NumWindow.".txt_valfact".$NumWindow.".value='".$row[8]."';
				document.frm_form".$NumWindow.".hdn_numfact".$NumWindow.".value='".$LaFactura."';
				document.frm_form".$NumWindow.".hdn_codigoter".$NumWindow.".value='".$row[10]."';
				document.frm_form".$NumWindow.".txt_observacion".$NumWindow.".value='';";
			} else {
				echo "MsgBox1('Notas Debitos','No es posible realizar ND a la factura ".$LaFactura."');";
			}
			mysqli_free_result($result); 

		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function calcvalores<?php echo $NumWindow; ?>() {
	var totalfilas=0;
	var contafilas=1;
	var totalnc=0;
	var cantservx=0;
	var cantantx=0;
	var valservx=0;
	
	valfac=parseInt(document.getElementById('txt_valfact<?php echo $NumWindow; ?>').value);
	numfact=document.getElementById('hdn_numfact<?php echo $NumWindow; ?>').value;
	totalnc=parseInt(document.getElementById('txt_valornc<?php echo $NumWindow; ?>').value);
	document.getElementById('txt_valfactnew<?php echo $NumWindow; ?>').value=valfac+totalnc;

	document.frm_form<?php echo $NumWindow; ?>.txt_observacion<?php echo $NumWindow; ?>.value='ND A FACTURA '+numfact+' POR VALOR DE $ '+totalnc;
}

function CargarFact<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_factura<?php echo $NumWindow; ?>').value!="") {
		LaFactura=document.getElementById('txt_factura<?php echo $NumWindow; ?>').value;
		AbrirForm('application/forms/notasdebito.php', '<?php echo $NumWindow; ?>', '&LaFactura='+LaFactura);
	}  
  }
}

function CargarFact2<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_factura<?php echo $NumWindow; ?>').value!="") {
		LaFactura=document.getElementById('txt_factura<?php echo $NumWindow; ?>').value;
		AbrirForm('application/forms/notasdebito.php', '<?php echo $NumWindow; ?>', '&LaFactura='+LaFactura);
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
