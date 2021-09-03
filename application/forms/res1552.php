<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
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
			<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
			<input name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" />
		</div>
			
			</div>	
			<div class="col-md-12">

		<div class="form-group">
			<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
			<input name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" />
		</div>
			
			</div>	
			<div class="col-md-12">

		<div class="form-group">
			<label for="cmb_entidad<?php echo $NumWindow; ?>">Entidad</label>
			<select name="cmb_entidad<?php echo $NumWindow; ?>" id="cmb_entidad<?php echo $NumWindow; ?>">
			<?php 
			$SQL="SELECT Codigo_TER, Nombre_TER FROM czterceros WHERE Codigo_TER in (Select Codigo_TER from gxeps where Codigo_EPS in (Select distinct Codigo_EPS from gxagendacab)) Order By 2;";
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
			
			<div class="col-md-12">

		<button class="btn btn-success btn-block" type="button"  onclick="javascript:GenRes1552<?php echo $NumWindow; ?>();"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Generar Registros</button>
		
			</div>
		</div>
			
		<div class="col-md-9 ">
	<div id="res1552<?php echo $NumWindow; ?>" class="row" >
		

	</div>

		</div>
	</div>		
		
</form>

<script >

var Funciones="functions/php/nexus/functions.php";

FechaActual('txt_fechaini<?php echo $NumWindow; ?>');
FechaActual('txt_fechafin<?php echo $NumWindow; ?>');

function GenRes1552<?php echo $NumWindow; ?>() {
	document.getElementById('res1552<?php echo $NumWindow; ?>').innerHTML='<div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Consultando Registros...</span>  </div></div> ';
	varfecini=document.frm_form<?php echo $NumWindow; ?>.txt_fechaini<?php echo $NumWindow; ?>.value;
	varfecfin=document.frm_form<?php echo $NumWindow; ?>.txt_fechafin<?php echo $NumWindow; ?>.value;
	varentidad=document.frm_form<?php echo $NumWindow; ?>.cmb_entidad<?php echo $NumWindow; ?>.value;
	$.get(Funciones,{'Func':'GenRes1552','varfecini':varfecini,'varfecfin':varfecfin,'varentidad':varentidad,'ventana':'<?php echo $NumWindow; ?>'},function(data){
		document.getElementById('res1552<?php echo $NumWindow; ?>').innerHTML=data;
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
