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
	<div class="row well well-sm">
			<div class="col-md-2">

		<div class="form-group">
			<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha</label>
			<input name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" onchange="Censo<?php echo $NumWindow; ?>();" value='2200-12-31' />
		</div>
		
			</div>	
			<div class="col-md-2">

		<div class="form-group">
			<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
			<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="time" onchange="Censo<?php echo $NumWindow; ?>();"  />
		</div>
		
			</div>				
	</div>
	<div class="row">	
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
		<div class="col-md-12 co">
<span class="pull-right" id="showtotal<?php echo $NumWindow; ?>">Mostrando 1 - 14 de <?php echo $totregistros; ?></span>
		</div>
	</div>
		
		
<input name="hdn_totregistros<?php echo $NumWindow; ?>" type="hidden" id="hdn_totregistros<?php echo $NumWindow; ?>" value="<?php echo $totregistros; ?>" />
</form>

<script >
var Funciones="functions/php/nexus/functions.php";

Censo<?php echo $NumWindow; ?>();

document.getElementById('txt_fecha<?php echo $NumWindow; ?>').value='';
document.getElementById('txt_hora<?php echo $NumWindow; ?>').value='';

<?php 
	if (!(isset($_GET["fechax"]))) {
?>
FechaActual('txt_fecha<?php echo $NumWindow; ?>');
HoraActual('txt_hora<?php echo $NumWindow; ?>');
<?php
	} else {
?>
document.getElementById('txt_fecha<?php echo $NumWindow; ?>').value='<?php echo $_GET["fechax"]; ?>';
document.getElementById('txt_hora<?php echo $NumWindow; ?>').value='<?php echo $_GET["horax"]; ?>';
<?php		
	}
?>
function Censo<?php echo $NumWindow; ?>() {
	document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML='<tr><th align="center">Consultando Fecha...</th></tr><tr ><td align="center" ><div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Consultando Fecha...</span>  </div></div></td></tr> ';
	varfecha=document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value;
	varhora=document.frm_form<?php echo $NumWindow; ?>.txt_hora<?php echo $NumWindow; ?>.value;
	$.get(Funciones,{'Func':'Censo','varfecha':varfecha,'varhora':varhora,'ventana':'<?php echo $NumWindow; ?>'},function(data){
		document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML=data;
	});
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
