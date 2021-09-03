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
	<div class="row">

		<div class="col-md-4">

	<div class="form-group">
		<label for="cmb_medicos<?php echo $NumWindow; ?>">Profesional</label>
		<select name="cmb_medicos<?php echo $NumWindow; ?>" id="cmb_medicos<?php echo $NumWindow; ?>" >
		<?php 
		$SQL="Select distinct b.Codigo_ARE, b.Nombre_ARE From gxagendacab a, gxareas b, gxagendadet c Where a.Codigo_ARE=b.Codigo_ARE and a.Codigo_AGE=c.Codigo_AGE and c.Fecha_AGE >= curdate() and a.Estado_AGE='1' and c.Estado_AGE='0' Order by 2";
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

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Inicial</label>
		<?php 
		$FechaD="";
		if (isset($_GET["fechadeseada"])) {
			$FechaD=$_GET["fechadeseada"];
		} else {
			$SQL="Select curdate();";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_array($result)) 
				{
			 	$FechaD=$row[0];
			 	}
			mysqli_free_result($result);
		} ?>
		<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" onchange="FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);" value="<?php echo $FechaD; ?>"" />
	</div>

		</div>
		<div class="col-md-6">

	<div class="form-group">
		<label for="cmb_medico<?php echo $NumWindow; ?>">Profesional</label>
		<select name="cmb_medico<?php echo $NumWindow; ?>" id="cmb_medico<?php echo $NumWindow; ?>" onchange="javascript:AgendaDia<?php echo $NumWindow; ?>(this.value, document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value);">
		
		</select>
	</div>
	
		</div>
			
	</div>
	
</form>

<script >


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
