<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">
			<label>Filtros</label>
		<div class="col-md-12 well well-sm pull-right">
			<div class="col-md-2">

		<div class="form-group">
			<label for="cmb_eps<?php echo $NumWindow; ?>">Contrato</label>
			<select name="cmb_eps<?php echo $NumWindow; ?>" id="cmb_eps<?php echo $NumWindow; ?>">
				<option value="_all"> - TODOS LOS CONTRATOS -</option>
			<?php 
			$SQL="SELECT Codigo_eps, Nombre_eps FROM gxeps WHERE codigo_eps IN (SELECT DISTINCT codigo_eps FROM czcartera WHERE saldo_car >0) AND estado_eps='1' Order By 2;";
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
			<label for="cmb_edades<?php echo $NumWindow; ?>">Edad Cartera</label>
			<select name="cmb_edades<?php echo $NumWindow; ?>" id="cmb_edades<?php echo $NumWindow; ?>">
				<option value="_all"> - TODAS -</option>
			<?php 
			$SQL="SELECT Codigo_EDA, Nombre_EDA, Color_EDA FROM czcarteraedades Order By 1;";
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
			<label for="txt_factura<?php echo $NumWindow; ?>">Factura</label>
			<div class="input-group" id="grp_txt_factura<?php echo $NumWindow; ?>">	
				<input name="txt_factura<?php echo $NumWindow; ?>" id="txt_factura<?php echo $NumWindow; ?>" type="text" />
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="CartFactura" onclick="javascript:CargarSearch('FacturaCartera', 'txt_factura<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
		
			</div>	
			<div class="col-md-1">

		<div class="form-group">
			<label for="cmb_anyo<?php echo $NumWindow; ?>">Año Facturas</label>
			<select name="cmb_anyo<?php echo $NumWindow; ?>" id="cmb_anyo<?php echo $NumWindow; ?>">
				<option value="_all"> - TODOS -</option>
			<?php 
			$SQL="SELECT distinct year(fecha_fac) FROM czcartera where estado_car='1' Order By 1;";
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
		
			</div>
			<div class="col-md-1">
	
		<div class="form-group">
			<label for="txt_facturado<?php echo $NumWindow; ?>">Facturado</label>
			<input name="txt_facturado<?php echo $NumWindow; ?>" id="txt_facturado<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="$0" style="text-align:right;"/>
		</div>

			</div>
			<div class="col-md-1">
	
		<div class="form-group">
			<label for="txt_ndebito<?php echo $NumWindow; ?>">N. Débito</label>
			<input name="txt_ndebito<?php echo $NumWindow; ?>" id="txt_ndebito<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="$0" style="text-align:right;"/>
		</div>

			</div>
			<div class="col-md-1">
	
		<div class="form-group">
			<label for="txt_ncredito<?php echo $NumWindow; ?>">N. Crédito</label>
			<input name="txt_ncredito<?php echo $NumWindow; ?>" id="txt_ncredito<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="$0" style="text-align:right;"/>
		</div>

			</div>
			<div class="col-md-1">
	
		<div class="form-group">
			<label for="txt_pagado<?php echo $NumWindow; ?>">Pagado</label>
			<input name="txt_pagado<?php echo $NumWindow; ?>" id="txt_pagado<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="$0" style="text-align:right;"/>
		</div>

			</div>
			<div class="col-md-2">
	
		<div class="form-group">
			<label for="txt_saldo<?php echo $NumWindow; ?>">Saldo</label>
			<input style="font-size:14px; text-align:right;font-weight: bold;" name="txt_saldo<?php echo $NumWindow; ?>" id="txt_saldo<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="$0"/>
		</div>

			</div>
			
			
							

		</div>
		<?php 
			 
			$t_facturado="$0";
			$t_ndebito="$0";
			$t_ncredito="$0";
			$t_pagado="$0";
			$t_saldo="$0";
			$SQL="Select count(Codigo_FAC), SUM(a.ValorFac_CAR), SUM(a.ValorDeb_CAR), SUM(a.ValorCre_CAR), SUM(a.ValPagos_CAR), SUM(a.Saldo_CAR) from czcartera a Where Estado_CAR='1' ";
			$resulthc = mysqli_query($conexion, $SQL);
			while($rowhc = mysqli_fetch_array($resulthc)) {
				$totregistros=$rowhc[0];
				$t_facturado=$rowhc[1];
				$t_ndebito=$rowhc[2];
				$t_ncredito=$rowhc[3];
				$t_pagado=$rowhc[4];
				$t_saldo=$rowhc[5];
				
			}
			mysqli_free_result($resulthc);  
		?>
		<div class="col-md-12">
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:50%">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Cliente</th> 
				<th id="th2<?php echo $NumWindow; ?>">Contrato</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Plan</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Fecha Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Paciente</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Radicado</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Fecha Cartera</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Edad Cartera</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Valor Factura</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Notas Débito</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Notas Crédito</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Pagado</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Saldo</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Acciones</th> 
			</tr> 
			 </tbody>
			</table>
	</div>

		</div>
		</div>

	<div class="row ">
		<div class="col-md-6">
		<nav aria-label="Page navigation">
  <ul class="pagination" style="margin-top: 0px; margin-bottom: 0px;">
    <?php 
    	$kountPage=1;
    	$Komienzo=0;
    	while ($Komienzo<$totregistros) {
    ?>
    <li><a href="javascript:UpdtCartera<?php echo $NumWindow; ?>('<?php echo $Komienzo; ?>')"><?php echo $kountPage; ?></a></li>
    <?php
    		$kountPage++;
    		$Komienzo=$Komienzo+$limitsql;
    	}
    ?>
  </ul>
</nav>
	</div>
	<div class="col-md-6">
<span class="pull-right" id="showtotal<?php echo $NumWindow; ?>">Mostrando 1 - 14 de <?php echo $totregistros; ?></span>
	</div>
	</div>
		
		
<input name="hdn_totregistros<?php echo $NumWindow; ?>" type="hidden" id="hdn_totregistros<?php echo $NumWindow; ?>" value="<?php echo $totregistros; ?>" />
</form>

<script >
var Funciones="functions/php/nexus/functions.php";

function UpdtCartera<?php echo $NumWindow; ?>(pagina) {
	pagini=0;
	pagini=parseFloat(pagina)+1;
	pagfin=0;
	pagfin=parseFloat(pagina)+<?php echo $limitsql; ?>;
	if(pagfin><?php echo $totregistros; ?>) {
		pagfin=<?php echo $totregistros; ?>;
	}
	document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML='<tr><th align="center">Consultando Registros...</th></tr><tr ><td align="center" ><div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Consultando Registros...</span>  </div></div></td></tr> ';
	varcontrato=document.frm_form<?php echo $NumWindow; ?>.cmb_eps<?php echo $NumWindow; ?>.value;
	varedad=document.frm_form<?php echo $NumWindow; ?>.cmb_edades<?php echo $NumWindow; ?>.value;
	varfactura=document.frm_form<?php echo $NumWindow; ?>.txt_factura<?php echo $NumWindow; ?>.value;
	varanyo=document.frm_form<?php echo $NumWindow; ?>.cmb_anyo<?php echo $NumWindow; ?>.value;
	varcantidad="<?php echo $limitsql; ?>";
	$.get(Funciones,{'Func':'UpdtCartera','varcontrato':varcontrato,'varedad':varedad,'varfactura':varfactura,'varanyo':varanyo,'varcantidad':varcantidad,'varcomienzo':pagina,'ventana':'<?php echo $NumWindow; ?>'},function(data){
		document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML=data;
	});
	document.getElementById('showtotal<?php echo $NumWindow; ?>').innerHTML="Mostrando "+(pagini)+" - "+(pagfin)+" de <?php echo $totregistros; ?>";
}

<?php 
	if (!(isset($_GET["varcomienzo"]))) {
		echo 'UpdtCartera'.$NumWindow.'("0");';
	}
?>
document.getElementById('txt_facturado<?php echo $NumWindow; ?>').value=<?php echo $t_facturado; ?>;
document.getElementById('txt_ndebito<?php echo $NumWindow; ?>').value=<?php echo $t_ndebito; ?>;
document.getElementById('txt_ncredito<?php echo $NumWindow; ?>').value=<?php echo $t_ncredito; ?>;
document.getElementById('txt_pagado<?php echo $NumWindow; ?>').value=<?php echo $t_pagado; ?>;
document.getElementById('txt_saldo<?php echo $NumWindow; ?>').value=<?php echo $t_saldo; ?>;

var NumWin='<?php echo $NumWindow; ?>';
	NumWin=NumWin.substring(6, NumWin.length);
	document.getElementById('zTools_'+NumWin).style.display  = 'none';

function FactDetCar<?php echo $NumWindow; ?>(factura) {
	var faktura= factura.replace(" ", "!");
	<?php
	$SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From ".$_SESSION['DB_NXS'].".ititems Where Codigo_ITM='512';";
	$resulthc = mysqli_query($conexion, $SQL);
	if ($rowhc = mysqli_fetch_array($resulthc)) 
		{
	?>
	CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>?faktura='+faktura, '<?php echo $rowhc[2]; ?>', 'cartera.php','<?php echo $NumWindow; ?>' );
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
