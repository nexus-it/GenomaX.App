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
						
		<div class="col-md-12">
				<button type="button" class="btn btn-xs btn-block btn-primary" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:TercDetEdit<?php echo $NumWindow; ?>('');"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Nuevo Tercero</button>
			</div>	
	</div>
		
	<div class="row">
	<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive col-md-12" style="height:80%">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Nombre</th> 
				<th id="th2<?php echo $NumWindow; ?>">Identificación</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Departamento</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Municipio</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Dirección</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Teléfono</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Correo</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Web</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Regimen</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Cliente</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Proveedor</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Tipo Persona</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Editar</th> 
			</tr> 
<?php
echo '			<tr id="trhx'.$NumWindow.'" style="background-color: #85b943;"> 
				<td id="thx1" style="padding: 1px;"><input name="txt_nombreter'.$NumWindow.'" id="txt_nombreter'.$NumWindow.'" type="text" value="" style="height: 22px; border-style: solid; border-color: green; border-width: thin; width: 100%;"/></td> 
				<td id="thx2" style="padding: 1px;"><input name="txt_idter'.$NumWindow.'" id="txt_idter'.$NumWindow.'" type="text" value="" style="height: 22px; border-style: solid; border-color: green; border-width: thin; width: 100%;"/></td> 
			    <td id="thx5" colspan="9"  style="padding: 1px;"> <button type="button" class="btn btn-xs btn-block btn-default" onclick="javascript:UpdtTerceros'.$NumWindow.'(\'0\');"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button> </td> 
			</tr> ';
?>
			 </tbody>
			</table>
	</div>

	</div>
	
		
<input name="hdn_totregistros<?php echo $NumWindow; ?>" type="hidden" id="hdn_totregistros<?php echo $NumWindow; ?>" value="<?php echo $totregistros; ?>" />
</form>

<script >
var Funciones="functions/php/nexus/functions.php";

UpdtTerceros<?php echo $NumWindow; ?>('0');

function UpdtTerceros<?php echo $NumWindow; ?>(pagina) {
	pagini=0;
	pagini=parseFloat(pagina)+1;
	pagfin=0;
	pagfin=parseFloat(pagina)+<?php echo $limitsql; ?>;
	varnombreter=document.frm_form<?php echo $NumWindow; ?>.txt_nombreter<?php echo $NumWindow; ?>.value;
	varidter=document.frm_form<?php echo $NumWindow; ?>.txt_idter<?php echo $NumWindow; ?>.value;
	varcantidad="<?php echo $limitsql; ?>";
	varcliente='0';
	varprov='0';
	document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML='<tr><th align="center">Consultando Registros...</th></tr><tr ><td align="center" ><div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Consultando Registros...</span>  </div></div></td></tr> ';
	$.get(Funciones,{'Func':'UpdtTerceros','varnombreter':varnombreter,'varidter':varidter,'varcantidad':varcantidad,'varcomienzo':pagina,'ventana':'<?php echo $NumWindow; ?>','varprov':varprov,'varcliente':varcliente},function(data){
		document.getElementById('tbDetalle<?php echo $NumWindow; ?>').innerHTML=data;
	});
	
}

<?php 
	/*if (!(isset($_GET["varcomienzo"]))) {
		echo 'UpdtTerceros'.$NumWindow.'("0");';
	}*/
?>

var NumWin='<?php echo $NumWindow; ?>';
	NumWin=NumWin.substring(6, NumWin.length);
	document.getElementById('zTools_'+NumWin).style.display  = 'none';

function TercDetEdit<?php echo $NumWindow; ?>(tercero) {
	var nuewo="";
	if (tercero=="") {
		nuewo="Nuevo ";
	}
	CargarWind(nuewo+'Tercero', 'forms/tercero.php?tercero='+tercero, 'reseller_account_template.png', 'ctterceros.php','<?php echo $NumWindow; ?>' );
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
