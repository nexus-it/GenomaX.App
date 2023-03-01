<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>


<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
	
	<label class="label label-success "><span class="">Cultivos</span></label>

	<div class="row well well-sm">
		<div class="container">
			<div class="row">
				<div class="form-group">
				   <div class="col-lg-9">
				       <label for="txt_muestra<?php echo $NumWindow; ?>">Muestra</label>
				       <select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
						    <option value=""></option>
						    <option value="">1</option>
						    <option value="">1</option>
						    <option value="">1</option>
						    <option value="">1</option>
					    </select>
					</div>
				</div>
			</div>
			<div class="row well well-sm">
				<div class="form-group">
					<div class="col-md-5">
					   <label for="txt_cultivo<?php echo $NumWindow; ?>">Cultivo</label>
					   <select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
						<option value=""></option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
					   </select>
					</div>
	
					<div class="col-md-5">
					   <label for="txt_microorganismo<?php echo $NumWindow; ?>">Microorganismo</label>
					   <select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
						<option value=""></option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
					   </select>
					</div>
				</div>
			</div>
			<div class="row well well-sm">
				<div class="col-md-4">
					<label for="txt_microorganismo<?php echo $NumWindow; ?>">Microorganismo</label>
					<select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
						<option value=""></option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="txt_resultados<?php echo $NumWindow; ?>">Resultado</label>
					<select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
						<option value=""></option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="txt_antibiograma<?php echo $NumWindow; ?>">Antibiograma</label>
					<select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
						<option value=""></option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
						<option value="">1</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<textarea name="" id="" cols="3" rows="3" class="form-control" placeholder="Observacion"></textarea>
		</div>
	</div>
	<div class="">
		<input type="checkbox" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?> value="">
		<label for="txt_confirmada<?php echo $NumWindow; ?>">Confirmado</label>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
		    <label for="txt_metodo<?php echo $NumWindow; ?>" class="label label-success">Metodo:</label>
			<select class="form-control" name=""<?php echo $NumWindow; ?> id=""<?php echo $NumWindow; ?>>
			    <option value=""></option>
				<option value="">1</option>
				<option value="">1</option>
				<option value="">1</option>
				<option value="">1</option>
			</select>
		</div>
	</div>
</form>


<script>

$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

	$("input[type=text]").addClass("nxs_<?php echo $NumWindow; ?>");
    $("textarea").addClass("nxs_<?php echo $NumWindow; ?>");
	$("select").addClass("nxs_<?php echo $NumWindow; ?>");

</script>