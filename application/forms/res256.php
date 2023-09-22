<?php
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';
	$NumPago="";
	$NumFak="";
	if (isset($_GET["CodigoPGS"])) {
		$NumPago=$_GET["CodigoPGS"];
	}
	if (isset($_GET["CodigoFAC"])) {
		$NumFak=$_GET["CodigoFAC"];
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row well well-sm">
		<div class="col-md-3">
			<div class="col-md-12">

		<div class="form-group">
			<label for="cmb_periodo<?php echo $NumWindow; ?>">Periodo</label>
			<select name="cmb_periodo<?php echo $NumWindow; ?>" id="cmb_periodo<?php echo $NumWindow; ?>">
			  <option value="*1*#!*2*#!*3*#!*4*#!*5*#!*6*">Primer Semestre</option>
			  <option value="*7*#!*8*#!*9*#!*10*#!*11*#!*12*">Segundo Semestre</option>
			</select>
		</div>
			
			</div>	
			<div class="col-md-12">

		<div class="form-group">
			<label for="cmb_anyo<?php echo $NumWindow; ?>">Año</label>
			<select name="cmb_anyo<?php echo $NumWindow; ?>" id="cmb_anyo<?php echo $NumWindow; ?>">
			<?php
			$SQL="Select year(FechaCreacion_USR), year(now()) from itusuarios Where codigo_USR not in ('0', '1') order by FechaCreacion_USR limit 1";
			$result = mysqli_query($conexion, $SQL);
			if ($row = mysqli_fetch_array($result)) 
				{
				for ($i=$row[0]; $i <= $row[1]; $i++) 
					{ 
			?>
			  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			 <?php
			 		}
			 	}
			mysqli_free_result($result);
			 ?>
			</select>
		</div>
			
			</div>	
			
			<div class="col-md-12">

		<button class="btn btn-success btn-block" type="button"  onclick="javascript:GenRes256<?php echo $NumWindow; ?>();"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Generar Registros</button>
		
			</div>
		</div>
			
		<div class="col-md-9 ">
	<div id="res256<?php echo $NumWindow; ?>" class="row" >
		

	</div>

		</div>
	</div>		
		
</form>

<script >

var Funciones="functions/php/nexus/functions.php";

function GenRes256<?php echo $NumWindow; ?>() {
	document.getElementById('res256<?php echo $NumWindow; ?>').innerHTML='<div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Consultando Facturas...</span>  </div></div> ';
	varperiodo=document.frm_form<?php echo $NumWindow; ?>.cmb_periodo<?php echo $NumWindow; ?>.value;
	varanyo=document.frm_form<?php echo $NumWindow; ?>.cmb_anyo<?php echo $NumWindow; ?>.value;
	$.get(Funciones,{'Func':'GenRes256','varperiodo':varperiodo,'varanyo':varanyo,'ventana':'<?php echo $NumWindow; ?>'},function(data){
		document.getElementById('res256<?php echo $NumWindow; ?>').innerHTML=data;
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
